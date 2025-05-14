const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const mysql = require('mysql2');
const session = require('express-session');
const phpExpress = require('php-express')({ binPath: '/usr/bin/php' }); // Ensure PHP is installed and available in PATH

const app = express();
const port = 3000;

// Middleware
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, '../'))); // Serve the entire src directory
app.use(session({
  secret: 'your_secret_key',
  resave: false,
  saveUninitialized: true,
  cookie: { secure: false }
}));

// Set up PHP Express
app.engine('php', phpExpress.engine);
app.set('views', path.join(__dirname, '../views')); // Path to your PHP views
app.set('view engine', 'php');

app.use((req, res, next) => {
  if (req.session.user) {
    console.log('Session User:', { id: req.session.user.id, email: req.session.user.email });
  } else {
    console.log('Session User: Not logged in');
  }
  next();
});

app.use((req, res, next) => {
  res.locals.user = req.session.user || null; // Make user available in all views
  next();
});

const db = mysql.createConnection({
  host: 'db', // Matches the service name in docker-compose.yml
  user: 'root',
  password: '', // No password
  database: 'children_db', // Matches MYSQL_DATABASE
  port: 3306
});

const maxRetries = 20; // Increase retries
const retryInterval = 5000; // Retry every 5 seconds
let retries = 0;

function connectWithRetry() {
  db.connect((err) => {
    if (err) {
      console.error('Error connecting to MySQL:', err);
      retries++;
      if (retries < maxRetries) {
        console.log(`Retrying to connect to MySQL (${retries}/${maxRetries})...`);
        setTimeout(connectWithRetry, retryInterval);
      } else {
        console.error('Max retries reached. Could not connect to MySQL.');
        process.exit(1);
      }
    } else {
      console.log('Connected to MySQL');
    }
  });
}

connectWithRetry();

// Routes
app.get('/', (req, res) => {
  res.render('index.php'); // Render index.php
});


app.get('/login', (req, res) => {
  res.render('login.php'); // Render found-person.php
});

app.get('/search', (req, res) => {
  res.render('search-image.php'); // Render search-image.php
});

app.get('/missing', (req, res) => {
  res.render('missing-person.php'); // Render missing-person.php
});

app.get('/found', (req, res) => {
  res.render('found-person.php'); // Render found-person.php
});

app.get('/about-us', (req, res) => {
  res.render('about-us.php'); // render about-us.php
});
app.get('/contact', (req, res) => {
  res.render('contact.php'); // render contact.php
});
app.get('/all-people', (req, res) => {
  res.render('all-people.php'); // render people.php
});

app.get('/upload-missed', (req, res) => {
  res.render('upload-report-missed.php'); // render people.php
});


app.post('/login', (req, res) => {
  const { email, pass } = req.body;
  const query = 'SELECT * FROM users WHERE email = ? AND pass = SHA1(?)';
  db.query(query, [email, pass], (err, result) => {
    if (err) {
      console.error(err);
      res.status(500).send('Server error');
    } else if (result.length === 0) {
      console.log('Invalid login attempt:', { email });
      res.status(401).send('Invalid email or password');
    } else {
      req.session.user = result[0];
      console.log('User logged in:', { id: req.session.user.id, email: req.session.user.email });
      req.session.save((err) => {
        if (err) {
          console.error('Error saving session:', err);
          res.status(500).send('Server error');
        } else {
          console.log('Session successfully saved:', { id: req.session.user.id, email: req.session.user.email });
          res.redirect('/');
        }
      });
    }
  });
});

app.get('/signup', (req, res) => {
  res.render('signup.php'); // Render signup.php
});

app.post('/signup', (req, res) => {
  const { fname, lname, email, pass } = req.body;
  const query = 'INSERT INTO users (fname, lname, email, pass, is_admin) VALUES (?, ?, ?, SHA1(?), 0)';
  db.query(query, [fname, lname, email, pass], (err, result) => {
    if (err) {
      console.error(err);
      res.status(500).send('Server error');
    } else {
      res.redirect('/login');
    }
  });
});

app.get('/logout', (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      console.error('Error destroying session:', err);
      res.status(500).send('Server error');
    } else {
      res.redirect('/');
    }
  });
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
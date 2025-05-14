# Mafqood - Missing Children Platform

A platform for reporting and finding missing children, built with PHP, Node.js, and Docker.

## Prerequisites

- Docker
- Docker Compose
- Git

## Local Development Setup

1. Clone the repository:
```bash
git clone https://github.com/yousifhub/mafqood.git
cd mafqood
```

2. Create environment file:
```bash
cp .env.example .env
```

3. Start the containers:
```bash
docker-compose up -d
```

4. Access the application:
- Frontend: http://localhost:8080
- Backend API: http://localhost:3000

## VPS Deployment

1. SSH into your VPS:
```bash
ssh user@your-vps-ip
```

2. Install Docker and Docker Compose:
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

3. Clone the repository:
```bash
git clone https://github.com/yousifhub/mafqood.git
cd mafqood
```

4. Create and configure environment file:
```bash
cp .env.example .env
# Edit .env with your production settings
nano .env
```

5. Start the application:
```bash
docker-compose up -d
```

## Environment Variables

Create a `.env` file with the following variables:

```env
# Database
DB_HOST=db
DB_USER=root
DB_PASS=your_password
DB_NAME=children_db

# Application
PHP_ROOT_URL=http://localhost:8080
NODE_ROOT_URL=http://localhost:3000

# Docker Configuration
DOCKER_APP_PORT=8080
DOCKER_DB_PORT=3306
DOCKER_NODE_PORT=3000
```

## Docker Commands

- Start containers: `docker-compose up -d`
- Stop containers: `docker-compose down`
- View logs: `docker-compose logs -f`
- Rebuild containers: `docker-compose up -d --build`

## Project Structure

```
mafqood/
├── src/                    # Source code
│   ├── app/               # PHP application
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   ├── images/            # Image assets
│   └── uploads/           # Uploaded files
├── docker/                # Docker configuration
├── .github/              # GitHub configuration
│   └── workflows/        # GitHub Actions
├── docker-compose.yml    # Docker services
└── README.md            # Documentation
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
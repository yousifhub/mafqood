DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS predictions;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fname VARCHAR(100) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    lname VARCHAR(100) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    email VARCHAR(255) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    pass VARCHAR(255) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    is_admin TINYINT(1) DEFAULT 0 NULL,
    INDEX (email)
);

CREATE TABLE report (
    id INT PRIMARY KEY AUTO_INCREMENT,
    photo VARCHAR(255) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    `child-name` VARCHAR(100) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    age INT NOT NULL,
    gender ENUM('male', 'female', 'other') CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    health VARCHAR(255) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    `report-data` TEXT CHARACTER SET utf16le COLLATE utf16le_general_ci NULL,
    `child-city` VARCHAR(100) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    `reporter-name` VARCHAR(100) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    relevance VARCHAR(255) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    phone CHAR(11) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    `reporter-city` VARCHAR(100) CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    type ENUM('missed', 'found') CHARACTER SET utf16le COLLATE utf16le_general_ci NOT NULL,
    user_id INT NOT NULL,
    `date` DATE NULL
);

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE predictions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    input_data TEXT,
    output_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE predictions MODIFY input_data LONGTEXT;
# URL Shortener PHP

This repository contains a simple URL shortening service written in PHP. The service allows users to shorten long URLs, making them easier to share and manage.

## Project Purpose

This project was developed as a pet project while studying at the institute. The main goal was to learn how to work with MySQL databases, files, and JSON in PHP.
# URL Shortener PHP - Documentation

This document provides an overview of the key files and their functionality within the URL Shortener PHP project.

## File Structure and Functionality

### README.md
Contains general information about the project, including its purpose, features, installation instructions, and usage guidelines.

### set.htaccess
Configuration file for Apache web servers. It includes rewrite rules to handle URL routing, enabling the clean and friendly URLs necessary for the URL shortener to work correctly.

### url-shorter-file-read.php
Handles URL shortening and redirection using file-based storage. This script reads from a file to store and retrieve the original URLs and their shortened versions. It demonstrates how to manage URL mappings without a database.

### url-shorter-mysql.php
Manages URL shortening and redirection using MySQL database storage. This script connects to a MySQL database to store and retrieve the original URLs and their shortened versions. It includes functions to handle database interactions, such as inserting new URL mappings and fetching original URLs based on short codes.

## How It Works

1. **Shortening a URL (MySQL-based):**
   - The user submits a long URL via a form.
   - `url-shorter-mysql.php` generates a unique short code.
   - The script inserts the long URL and its corresponding short code into the MySQL database.
   - The user receives the shortened URL for sharing.

2. **Redirecting to the Original URL (MySQL-based):**
   - When a shortened URL is visited, `url-shorter-mysql.php` retrieves the original URL from the MySQL database using the short code.
   - The user is redirected to the original URL.

3. **Shortening a URL (File-based):**
   - The user submits a long URL via a form.
   - `url-shorter-file-read.php` generates a unique short code.
   - The script saves the long URL and its corresponding short code in a file.
   - The user receives the shortened URL for sharing.

4. **Redirecting to the Original URL (File-based):**
   - When a shortened URL is visited, `url-shorter-file-read.php` retrieves the original URL from the file using the short code.
   - The user is redirected to the original URL.

## Database Schema (MySQL)

The MySQL-based version uses a table with the following structure:

- `id` (INT, Primary Key, Auto Increment): Unique identifier for each URL entry.
- `long_url` (VARCHAR): The original long URL.
- `short_code` (VARCHAR): The generated short code.

## Conclusion

This project serves as a practical example of working with PHP, MySQL, file handling, and JSON. The structure and files are organized to provide a clear and maintainable codebase for a simple URL shortening service.

## Features

- Shorten long URLs into concise, easy-to-share links
- Track usage statistics for shortened URLs
- Simple and intuitive interface
- Easily deployable on any PHP-supported server

## Requirements

- PHP 7.0 or higher
- MySQL or any other compatible database

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/Fulldroper/url-shorter-php.git
   cd url-shorter-php```
2. **Install dependencies:**
  This project does not have any external dependencies beyond PHP and a database.
3. **Configure the database:**
    - Create a new MySQL database.
    - Import the `database.sql` file located in the repository to set up the necessary tables.
    - Update the `config.php file` with your database credentials.
4. **Run the application:**
    - Ensure your PHP server is running.
    - Access the application through your web browser.
## Usage
1. **Shortening a URL:**
    - Navigate to the homepage of the application.
    - Enter the long URL you want to shorten.
    - Click the "Shorten" button.
    - The shortened URL will be displayed and available for copying.
2. **Tracking URL statistics:**
    - Use the provided administrative interface to view statistics on the usage of shortened URLs.
## Contributing
Contributions are welcome! If you have any suggestions or improvements, please fork the repository and create a pull request.
1. Fork the repository
2. Create your feature branch (git checkout -b feature/new-feature)
3. Commit your changes (git commit -am 'Add new feature')
4. Push to the branch (git push origin feature/new-feature)
5. Create a new Pull Request
## License
This project is licensed under the MIT License.

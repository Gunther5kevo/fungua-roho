<?php
// Load the .env file
$dotenv = parse_ini_file('../.env');

// Get the database credentials from the .env file
$host = $dotenv['host'];
$username = $dotenv['username'];
$password = $dotenv['password'];
$database = $dotenv['database'];

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


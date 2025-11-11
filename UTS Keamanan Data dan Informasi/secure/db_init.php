<?php
// Creates a sqlite DB with users table and sample users
$dbfile = __DIR__ . '/app.db';
if (file_exists($dbfile)) {
    echo "DB already exists at $dbfile";
    exit;
}
$db = new PDO('sqlite:' . $dbfile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, password TEXT, bio TEXT);"); 
$db->exec("INSERT INTO users (username,password,bio) VALUES ('alice','password123','Hello I am Alice');");
$db->exec("INSERT INTO users (username,password,bio) VALUES ('bob','hunter2','Bob here');");
echo "DB created at $dbfile";
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Mini DVWA PHP Demo</title></head>
<body>
  <h1>Mini DVWA PHP Demo</h1>
  <p>Choose lab (vulnerable or secure)</p>
  <h2>Vulnerable labs</h2>
  <ul>
    <li><a href="vulnerable/login.php">Login (SQLi)</a></li>
    <li><a href="vulnerable/comments.php">Comments (XSS)</a></li>
    <li><a href="vulnerable/upload.php">Upload (Insecure Upload)</a></li>
    <li><a href="vulnerable/profile.php?id=1">Profile (Broken Access Control)</a></li>
  </ul>
  <h2>Secure labs (requires simple auth)</h2>
  <p><a href="secure/auth_login.php">Login to Secure Labs</a></p>
  <ul>
    <li><a href="secure/login.php">Login (Secure)</a></li>
    <li><a href="secure/comments.php">Comments (Secure)</a></li>
    <li><a href="secure/upload.php">Upload (Secure)</a></li>
    <li><a href="secure/profile.php">Profile (Secure)</a></li>
  </ul>
</body>
</html>

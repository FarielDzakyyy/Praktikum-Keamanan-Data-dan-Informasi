<?php
// Vulnerable login - SQLi via string concatenation
session_start();
$db = new PDO('sqlite:' . __DIR__ . '/app.db');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    // VULNERABLE: direct interpolation
    $q = "SELECT * FROM users WHERE username = '" . $u . "' AND password = '" . $p . "'";
    error_log("Query: " . $q);
    $res = $db->query($q);
    if ($res && $row = $res->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['user_id'] = $row['id'];
        header('Location: /index.php');
        exit;
    } else {
        $err = 'Login failed';
    }
}
?>
<h2>Vulnerable Login (SQL Injection)</h2>
<?php if (!empty($err)) echo '<p style="color:red">'.htmlentities($err).'</p>'; ?>
<form method="post">
  Username: <input name="username"><br>
  Password: <input name="password" type="password"><br>
  <button>Login</button>
</form>
<p>Try payload: ' OR '1'='1</p>

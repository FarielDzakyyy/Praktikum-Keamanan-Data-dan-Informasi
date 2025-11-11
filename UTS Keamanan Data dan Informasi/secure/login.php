<?php
// Secure login - parameterized query, simple password check, sets a UUID token in server sessions
session_start();
$db = new PDO('sqlite:' . __DIR__ . '/app.db');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$u, $p]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        // create token + uuid
        $token = bin2hex(random_bytes(16));
        $uuid = uniqid('', true);
        $_SESSION['token'] = $token;
        $_SESSION['uuid'] = $uuid;
        $_SESSION['user_id'] = $row['id'];
        // store session token server-side (file)
        $sfile = __DIR__ . '/sessions/' . $uuid . '.session';
        if (!is_dir(dirname($sfile))) mkdir(dirname($sfile), 0700, true);
        file_put_contents($sfile, $token);
        header('Location: /secure/login.php');
        exit;
    } else {
        $err = 'Login failed';
    }
}
?>
<h2>Secure Login (parameterized)</h2>
<?php if (!empty($err)) echo '<p style="color:red">'.htmlentities($err).'</p>'; ?>
<form method="post">
  Username: <input name="username"><br>
  Password: <input name="password" type="password"><br>
  <button>Login</button>
</form>
<p>After login, a UUID and token are stored server-side. Access secure pages which check them.</p>

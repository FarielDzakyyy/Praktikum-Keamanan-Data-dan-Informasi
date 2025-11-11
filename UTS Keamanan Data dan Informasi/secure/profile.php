<?php
// Secure profile - checks session token + uuid file before showing profile
session_start();
$db = new PDO('sqlite:' . __DIR__ . '/app.db');
// check session token and uuid
if (empty($_SESSION['uuid']) || empty($_SESSION['token']) || empty($_SESSION['user_id'])) {
    header('Location: /secure/login.php');
    exit;
}
$sfile = __DIR__ . '/sessions/' . $_SESSION['uuid'] . '.session';
if (!file_exists($sfile) || trim(file_get_contents($sfile)) !== $_SESSION['token']) {
    echo 'Invalid session token'; exit;
}
$id = intval($_GET['id'] ?? 0);
if ($id !== intval($_SESSION['user_id'])) {
    http_response_code(403);
    echo 'Forbidden: can only view your own profile';
    exit;
}
$stmt = $db->prepare('SELECT id, username, bio FROM users WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) { echo 'Not found'; exit; }
?>
<h2>Secure Profile (access controlled)</h2>
<p>ID: <?php echo $row['id']; ?></p>
<p>Username: <?php echo htmlentities($row['username']); ?></p>
<p>Bio: <?php echo htmlentities($row['bio']); ?></p>

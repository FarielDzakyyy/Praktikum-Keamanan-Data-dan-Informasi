<?php
// Vulnerable profile - no auth check, anyone can view any user by id param
session_start();
$db = new PDO('sqlite:' . __DIR__ . '/app.db');
$id = $_GET['id'] ?? null;
if (!$id) { echo 'No id'; exit; }
$stmt = $db->query("SELECT id, username, bio FROM users WHERE id = " . $id);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) { echo 'Not found'; exit; }
?>
<h2>Vulnerable Profile</h2>
<p>ID: <?php echo $row['id']; ?></p>
<p>Username: <?php echo htmlentities($row['username']); ?></p>
<p>Bio: <?php echo htmlentities($row['bio']); ?></p>

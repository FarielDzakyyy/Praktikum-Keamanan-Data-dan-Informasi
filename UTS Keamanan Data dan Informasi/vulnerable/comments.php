<?php
// Vulnerable comments - stored XSS, comments stored in file as-is
session_start();
$file = __DIR__ . '/comments.txt';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? 'anon';
    $comment = $_POST['comment'] ?? '';
    $entry = json_encode(['name'=>$name, 'comment'=>$comment]) . PHP_EOL;
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    header('Location: /vulnerable/comments.php');
    exit;
}
$comments = [];
if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $l) $comments[] = json_decode($l, true);
}
?>
<h2>Vulnerable Comments (Stored XSS)</h2>
<form method="post">
  Name: <input name="name"><br>
  Comment:<br><textarea name="comment" rows="4" cols="40"></textarea><br>
  <button>Post</button>
</form>
<h3>Comments</h3>
<ul>
<?php foreach ($comments as $c): ?>
  <li><strong><?php echo $c['name']; ?></strong>: <?php echo $c['comment']; // VULNERABLE: no escaping ?></li>
<?php endforeach; ?>
</ul>

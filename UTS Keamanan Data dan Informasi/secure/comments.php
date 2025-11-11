<?php
// Secure comments - auto-escape output, basic tag stripping
session_start();
$file = __DIR__ . '/comments.txt';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = strip_tags($_POST['name'] ?? 'anon');
    $comment = strip_tags($_POST['comment'] ?? '');
    $entry = json_encode(['name'=>$name, 'comment'=>$comment]) . PHP_EOL;
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    header('Location: /secure/comments.php');
    exit;
}
$comments = [];
if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $l) $comments[] = json_decode($l, true);
}
?>
<h2>Secure Comments (sanitized)</h2>
<form method="post">
  Name: <input name="name"><br>
  Comment:<br><textarea name="comment" rows="4" cols="40"></textarea><br>
  <button>Post</button>
</form>
<h3>Comments</h3>
<ul>
<?php foreach ($comments as $c): ?>
  <li><strong><?php echo htmlentities($c['name']); ?></strong>: <?php echo htmlentities($c['comment']); ?></li>
<?php endforeach; ?>
</ul>

<?php
// Secure upload - whitelist extensions, rename, store outside web root (in this demo folder 'safe_uploads')
session_start();
$updir = __DIR__ . '/safe_uploads/';
if (!is_dir($updir)) mkdir($updir, 0700, true);
$allowed = ['png','jpg','jpeg','gif','txt'];
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $orig = basename($_FILES['file']['name']);
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        $msg = 'Extension not allowed';
    } else {
        $new = bin2hex(random_bytes(8)) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $orig);
        move_uploaded_file($_FILES['file']['tmp_name'], $updir . $new);
        $msg = 'Stored safely as ' . htmlentities($new);
    }
}
$files = array_diff(scandir($updir), array('.', '..'));
?>
<h2>Secure Upload (whitelist + rename)</h2>
<?php if ($msg) echo '<p>'. $msg .'</p>'; ?>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="file"><button>Upload</button>
</form>
<h3>Stored Files</h3><ul>
<?php foreach ($files as $f): ?>
  <li><?php echo htmlentities($f); ?></li>
<?php endforeach; ?>
</ul>

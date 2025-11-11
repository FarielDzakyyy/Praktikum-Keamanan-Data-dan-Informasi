<?php
// Vulnerable upload - saves any file with original name into uploads/
session_start();
$updir = __DIR__ . '/uploads/';
if (!is_dir($updir)) mkdir($updir);
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $fn = basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $updir . $fn);
    $msg = 'Uploaded: ' . htmlentities($fn);
}
$files = array_diff(scandir($updir), array('.', '..'));
?>
<h2>Vulnerable Upload (Insecure)</h2>
<?php if ($msg) echo '<p>'. $msg .'</p>'; ?>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="file"><button>Upload</button>
</form>
<h3>Files</h3><ul>
<?php foreach ($files as $f): ?>
  <li><a href="uploads/<?php echo urlencode($f); ?>"><?php echo htmlentities($f); ?></a></li>
<?php endforeach; ?>
</ul>

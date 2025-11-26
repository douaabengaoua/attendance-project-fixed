<?php
// submit_justification.php - POST: user_id, session_id, reason, file upload 'file'
require 'db_connect.php';
$config = require __DIR__ . '/config.php';
$pdo = getPDO();

$user_id = intval($_POST['user_id'] ?? 0);
$session_id = intval($_POST['session_id'] ?? 0);
$reason = trim($_POST['reason'] ?? '');

if(!$user_id || !$session_id || !$reason) {
  echo json_encode(['success' => false, 'error' => 'Missing fields']);
  exit;
}

// handle file upload
$uploads_dir = rtrim($config['uploads_dir'], '/\') . '/justifications';
if(!is_dir($uploads_dir)) mkdir($uploads_dir, 0777, true);

$file_path = null;
if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
  $tmp = $_FILES['file']['tmp_name'];
  $name = basename($_FILES['file']['name']);
  $target = $uploads_dir . '/' . time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $name);
  if(move_uploaded_file($tmp, $target)) {
    $file_path = $target;
  }
}

$stmt = $pdo->prepare("INSERT INTO justifications (user_id, session_id, reason, file_path, status) VALUES (?, ?, ?, ?, 'pending')");
$stmt->execute([$user_id, $session_id, $reason, $file_path]);
echo json_encode(['success' => true, 'justification_id' => (int)$pdo->lastInsertId()]);

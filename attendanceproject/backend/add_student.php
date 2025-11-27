<?php
// add_student.php - POST: matricule, fullname, group_id
require 'db_connect.php';
$pdo = getPDO();

$matricule = trim($_POST['matricule'] ?? '');
$fullname = trim($_POST['fullname'] ?? '');
$group_id = intval($_POST['group_id'] ?? 0);

if(!$matricule || !$fullname || !$group_id) {
  echo json_encode(['success' => false, 'error' => 'Missing fields']);
  exit;
}

$password_hash = password_hash('student123', PASSWORD_DEFAULT);
try {
  $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password_hash, role_id, matricule, group_id) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$fullname, $matricule, $password_hash, 1, $matricule, $group_id]);
  echo json_encode(['success' => true, 'user_id' => (int)$pdo->lastInsertId()]);
} catch (Exception $e) {
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

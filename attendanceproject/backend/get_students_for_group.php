<?php
// get_students_for_group.php - GET: group_id
require 'db_connect.php';
$pdo = getPDO();
$group_id = intval($_GET['group_id'] ?? 0);
if(!$group_id) {
  echo json_encode([]);
  exit;
}
$stmt = $pdo->prepare("SELECT id, fullname, matricule FROM users WHERE group_id = ? AND role_id = 1");
$stmt->execute([$group_id]);
$rows = $stmt->fetchAll();
echo json_encode($rows);

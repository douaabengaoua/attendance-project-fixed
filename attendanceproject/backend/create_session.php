<?php
// create_session.php - POST: course_id, group_id, prof_id, date (YYYY-MM-DD)
require 'db_connect.php';
$pdo = getPDO();

$course_id = intval($_POST['course_id'] ?? 0);
$group_id = intval($_POST['group_id'] ?? 0);
$opened_by = intval($_POST['prof_id'] ?? 0);
$date = $_POST['date'] ?? date('Y-m-d');

if(!$course_id || !$group_id || !$opened_by) {
  echo json_encode(['success' => false, 'error' => 'Missing parameters']);
  exit;
}

$stmt = $pdo->prepare("INSERT INTO attendance_sessions (course_id, group_id, date, opened_by, status)
                       VALUES (?, ?, ?, ?, 'open')");
$stmt->execute([$course_id, $group_id, $date, $opened_by]);
$session_id = $pdo->lastInsertId();
echo json_encode(['success' => true, 'session_id' => (int)$session_id]);

<?php
// take_attendance.php - POST: session_id, records (JSON array)
require 'db_connect.php';
$pdo = getPDO();

$input = $_POST;
$session_id = intval($input['session_id'] ?? 0);
$records_json = $input['records'] ?? null;
if(!$session_id || !$records_json) {
  echo json_encode(['success' => false, 'error' => 'Missing session_id or records']);
  exit;
}

$records = json_decode($records_json, true);
if(!is_array($records)) {
  echo json_encode(['success' => false, 'error' => 'Invalid records data']);
  exit;
}

try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare("INSERT INTO attendance_records (session_id, user_id, status, note) VALUES (?, ?, ?, ?)");
  foreach($records as $r) {
    $user_id = intval($r['user_id']);
    $status = $r['status'];
    $note = $r['note'] ?? null;
    $stmt->execute([$session_id, $user_id, $status, $note]);
  }
  $pdo->commit();
  echo json_encode(['success' => true]);
} catch (Exception $e) {
  $pdo->rollBack();
  error_log($e->getMessage());
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

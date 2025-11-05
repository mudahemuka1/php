<?php require_once __DIR__ . '/../config.php'; require_login();
$bbid = intval($_POST['bbid'] ?? 0);
if ($bbid) {
  $stmt = $mysqli->prepare('SELECT book_id FROM borrowed_books WHERE id=? AND return_date IS NULL');
  $stmt->bind_param('i', $bbid);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  if ($row) {
    $book_id = intval($row['book_id']);
    $stmt = $mysqli->prepare('UPDATE borrowed_books SET return_date = NOW() WHERE id=?');
    $stmt->bind_param('i', $bbid);
    if ($stmt->execute()) {
      $stmt->close();
      $stmt = $mysqli->prepare('UPDATE books SET available_status=1 WHERE book_id=?');
      $stmt->bind_param('i', $book_id);
      $stmt->execute();
      $stmt->close();
    }
  }
}
header('Location: /catphp/dashboard.php');
exit;

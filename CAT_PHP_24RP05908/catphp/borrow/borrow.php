<?php require_once __DIR__ . '/../config.php'; require_login(); $u = current_user();
$book_id = intval($_POST['book_id'] ?? 0);
if ($book_id) {
  $stmt = $mysqli->prepare('SELECT available_status FROM books WHERE book_id=?');
  $stmt->bind_param('i', $book_id);
  $stmt->execute();
  $available = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  if ($available && intval($available['available_status']) === 1) {
    $stmt = $mysqli->prepare('INSERT INTO borrowed_books (student_id, book_id, borrow_date) VALUES (?,?, NOW())');
    $stmt->bind_param('si', $u['student_id'], $book_id);
    if ($stmt->execute()) {
      $stmt->close();
      $stmt = $mysqli->prepare('UPDATE books SET available_status=0 WHERE book_id=?');
      $stmt->bind_param('i', $book_id);
      $stmt->execute();
      $stmt->close();
    }
  }
}
header('Location: /catphp/dashboard.php');
exit;

<?php require_once __DIR__ . '/../config.php';
$id = intval($_GET['id'] ?? 0);
if ($id) {
  $stmt = $mysqli->prepare('DELETE FROM books WHERE book_id=?');
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();
}
header('Location: /catphp/books/index.php');
exit;

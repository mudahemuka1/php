<?php include __DIR__ . '/../includes/header.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare('SELECT * FROM books WHERE book_id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$book) { header('Location: /catphp/books/index.php'); exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $authors = trim($_POST['authors'] ?? '');
  $category = trim($_POST['category'] ?? '');
  $available = isset($_POST['available_status']) ? 1 : 0;
  if ($title === '' || $authors === '' || $category === '') { $errors[] = 'All fields are required'; }
  if (!$errors) {
    $stmt = $mysqli->prepare('UPDATE books SET title=?, authors=?, category=?, available_status=? WHERE book_id=?');
    $stmt->bind_param('sssii', $title, $authors, $category, $available, $id);
    if ($stmt->execute()) { header('Location: /catphp/books/select.php?id=' . $id); exit; }
    $errors[] = 'Failed to update book: ' . e($stmt->error ?: $mysqli->error);
    $stmt->close();
  }
}
?>
<h1 class="h4 mb-3">Edit Book</h1>
<?php if ($errors): ?><div class="alert alert-danger"><?php echo e(implode(', ', $errors)); ?></div><?php endif; ?>
<form method="post" class="needs-validation" novalidate>
  <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required value="<?php echo e($_POST['title'] ?? $book['title']); ?>"></div>
  <div class="mb-3"><label class="form-label">Authors</label><input class="form-control" name="authors" required value="<?php echo e($_POST['authors'] ?? $book['authors']); ?>"></div>
  <div class="mb-3"><label class="form-label">Category</label><input class="form-control" name="category" required value="<?php echo e($_POST['category'] ?? $book['category']); ?>"></div>
  <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="available_status" id="avail" <?php echo ($book['available_status'] ? 'checked' : ''); ?>><label class="form-check-label" for="avail">Available</label></div>
  <button class="btn btn-primary">Update</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>

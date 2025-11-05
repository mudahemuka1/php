<?php include __DIR__ . '/../includes/header.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $authors = trim($_POST['authors'] ?? '');
  $category = trim($_POST['category'] ?? '');
  $available = isset($_POST['available_status']) ? 1 : 0;
  if ($title === '' || $authors === '' || $category === '') { $errors[] = 'All fields are required'; }
  if (!$errors) {
    // Ensure books table exists (safety net if DB not initialized)
    $mysqli->query("CREATE TABLE IF NOT EXISTS books (
      book_id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(200) NOT NULL,
      authors VARCHAR(200) NOT NULL,
      category VARCHAR(100) NOT NULL,
      available_status TINYINT(1) NOT NULL DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $stmt = $mysqli->prepare('INSERT INTO books (title, authors, category, available_status) VALUES (?,?,?,?)');
    if (!$stmt) {
      $errors[] = 'Failed to prepare statement: ' . e($mysqli->error);
    } else {
      $stmt->bind_param('sssi', $title, $authors, $category, $available);
      if ($stmt->execute()) {
        $newId = $mysqli->insert_id; $stmt->close(); header('Location: /catphp/books/select.php?id=' . $newId); exit;
      }
      $errors[] = 'Failed to add book: ' . e($stmt->error ?: $mysqli->error);
      $stmt->close();
    }
  }
}
?>
<h1 class="h4 mb-3">Add Book</h1>
<?php if ($errors): ?><div class="alert alert-danger"><?php echo e(implode(', ', $errors)); ?></div><?php endif; ?>
<form method="post" class="needs-validation" novalidate>
  <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required value="<?php echo e($_POST['title'] ?? ''); ?>"></div>
  <div class="mb-3"><label class="form-label">Authors</label><input class="form-control" name="authors" required value="<?php echo e($_POST['authors'] ?? ''); ?>"></div>
  <div class="mb-3"><label class="form-label">Category</label><input class="form-control" name="category" required value="<?php echo e($_POST['category'] ?? ''); ?>"></div>
  <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="available_status" id="avail" checked><label class="form-check-label" for="avail">Available</label></div>
  <button class="btn btn-primary">Save</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<?php include __DIR__ . '/../includes/header.php';
$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: /catphp/books/index.php'); exit; }
$stmt = $mysqli->prepare('SELECT * FROM books WHERE book_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$book) { header('Location: /catphp/books/index.php'); exit; }
?>
<h1 class="h4 mb-3">Book Details</h1>
<div class="card shadow-sm mb-3">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6"><strong>Title:</strong> <?php echo e($book['title']); ?></div>
      <div class="col-md-6"><strong>Authors:</strong> <?php echo e($book['authors']); ?></div>
      <div class="col-md-6"><strong>Category:</strong> <?php echo e($book['category']); ?></div>
      <div class="col-md-6"><strong>Status:</strong> <?php echo ($book['available_status'] ? 'Available' : 'Unavailable'); ?></div>
    </div>
  </div>
</div>
<div class="d-flex gap-2">
  <a class="btn btn-secondary" href="/catphp/books/index.php">Back</a>
  <a class="btn btn-primary" href="/catphp/books/edit.php?id=<?php echo e($book['book_id']); ?>">Edit</a>
  <a class="btn btn-danger" href="/catphp/books/delete.php?id=<?php echo e($book['book_id']); ?>" onclick="return confirm('Delete this book?')">Delete</a>
  <?php if (!is_admin()): ?>
    <?php if ($book['available_status']): ?>
      <form method="post" action="/catphp/borrow/borrow.php">
        <input type="hidden" name="book_id" value="<?php echo e($book['book_id']); ?>">
        <button class="btn btn-primary" <?php echo is_logged_in() ? '' : 'disabled'; ?>>Borrow</button>
      </form>
      <?php if (!is_logged_in()): ?><span class="text-muted"> Login to borrow</span><?php endif; ?>
    <?php else: ?>
      <span class="badge bg-secondary align-self-center">Currently Unavailable</span>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

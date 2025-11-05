<?php include __DIR__ . '/../includes/header.php'; $q = trim($_GET['q'] ?? ''); $cat = trim($_GET['category'] ?? '');
$sql = 'SELECT * FROM books WHERE 1';
$params = [];
$types = '';
if ($q !== '') { $sql .= ' AND (title LIKE ? OR authors LIKE ?)'; $like = "%$q%"; $params[] = &$like; $params[] = &$like; $types .= 'ss'; }
if ($cat !== '') { $sql .= ' AND category = ?'; $params[] = &$cat; $types .= 's'; }
$sql .= ' ORDER BY title';
$stmt = $mysqli->prepare($sql);
if ($types !== '') { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$res = $stmt->get_result();
?>
<h1 class="h4 mb-3">Books</h1>
<form class="row g-2 mb-3">
  <div class="col-md-5"><input class="form-control" name="q" placeholder="Search title or authors" value="<?php echo e($q); ?>"></div>
  <div class="col-md-3"><input class="form-control" name="category" placeholder="Category" value="<?php echo e($cat); ?>"></div>
  <div class="col-md-2 d-grid"><button class="btn btn-secondary">Filter</button></div>
  <?php if (is_admin()): ?><div class="col-md-2 d-grid"><a class="btn btn-primary" href="/catphp/books/create.php">Set</a></div><?php endif; ?>
</form>
<div class="table-responsive">
<table class="table table-striped">
  <thead><tr><th>Title</th><th>Authors</th><th>Category</th><th>Status</th><th>Select</th><th>Actions</th></tr></thead>
  <tbody>
  <?php while ($b = $res->fetch_assoc()): ?>
    <tr>
      <td><?php echo e($b['title']); ?></td>
      <td><?php echo e($b['authors']); ?></td>
      <td><?php echo e($b['category']); ?></td>
      <td><?php echo $b['available_status'] ? 'Available' : 'Unavailable'; ?></td>
      <td>
        <a class="btn btn-sm btn-outline-secondary" href="/catphp/books/select.php?id=<?php echo e($b['book_id']); ?>">Select</a>
      </td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="/catphp/books/edit.php?id=<?php echo e($b['book_id']); ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="/catphp/books/delete.php?id=<?php echo e($b['book_id']); ?>" onclick="return confirm('Delete this book?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; $stmt->close(); ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

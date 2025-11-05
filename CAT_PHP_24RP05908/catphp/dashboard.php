<?php include __DIR__ . '/includes/header.php'; require_login(); $u = current_user(); ?>
<h1 class="h4 mb-3">Dashboard</h1>
<div class="row g-4">
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="h5">My Borrowed Books</h2>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead><tr><th>Title</th><th>Borrowed</th><th>Return</th><th></th></tr></thead>
            <tbody>
            <?php
            $stmt = $mysqli->prepare('SELECT bb.id as bbid, b.title, bb.borrow_date, bb.return_date FROM borrowed_books bb JOIN books b ON bb.book_id=b.book_id WHERE bb.student_id = ? ORDER BY bb.borrow_date DESC');
            $stmt->bind_param('s', $u['student_id']);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo e($row['title']); ?></td>
                <td><?php echo e($row['borrow_date']); ?></td>
                <td><?php echo e($row['return_date'] ?: '—'); ?></td>
                <td>
                  <?php if (!$row['return_date']): ?>
                  <form method="post" action="/catphp/borrow/return.php" class="d-inline">
                    <input type="hidden" name="bbid" value="<?php echo e($row['bbid']); ?>">
                    <button class="btn btn-sm btn-success">Return</button>
                  </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; $stmt->close(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="h5">Available Books</h2>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead><tr><th>Title</th><th>Authors</th><th>Category</th><th></th></tr></thead>
            <tbody>
            <?php
            $res = $mysqli->query("SELECT book_id, title, authors, category FROM books WHERE available_status = 1 ORDER BY title");
            while ($b = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo e($b['title']); ?></td>
                <td><?php echo e($b['authors']); ?></td>
                <td><?php echo e($b['category']); ?></td>
                <td>
                  <form method="post" action="/catphp/borrow/borrow.php">
                    <input type="hidden" name="book_id" value="<?php echo e($b['book_id']); ?>">
                    <button class="btn btn-sm btn-primary">Borrow</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

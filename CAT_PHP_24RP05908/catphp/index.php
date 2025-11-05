<?php include __DIR__ . '/includes/header.php'; ?>
<div class="row g-4">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h4">Welcome to RP Karongi Library</h1>
        <p>Search and borrow books online. Register or login to get started.</p>
        <a href="/catphp/books/index.php" class="btn btn-primary">View Books</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="h5">Quick Links</h2>
        <div class="d-grid gap-2">
          <a class="btn btn-outline-primary" href="/catphp/auth/register.php">Register</a>
          <a class="btn btn-outline-secondary" href="/catphp/auth/login.php">Login</a>
          <a class="btn btn-outline-success" href="/catphp/dashboard.php">Dashboard</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

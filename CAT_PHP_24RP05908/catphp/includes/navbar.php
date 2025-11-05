<?php $user = current_user(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="/catphp/index.php">RP Karongi Library</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/catphp/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/catphp/auth/register.php">Register</a></li>
        <li class="nav-item"><a class="nav-link" href="/catphp/auth/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="/catphp/books/index.php">Books</a></li>
        <li class="nav-item"><a class="nav-link" href="/catphp/contact.php">Contact</a></li>
        <?php if ($user): ?>
          <li class="nav-item"><a class="nav-link" href="/catphp/dashboard.php">Dashboard</a></li>
          <?php if (is_admin()): ?>
            <li class="nav-item"><a class="nav-link" href="/catphp/books/create.php">Add Book</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if ($user): ?>
          <li class="nav-item"><span class="navbar-text me-3">Hi, <?php echo e($user['username']); ?></span></li>
          <li class="nav-item"><a class="btn btn-light btn-sm" href="/catphp/auth/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

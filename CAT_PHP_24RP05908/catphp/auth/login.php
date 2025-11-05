<?php require_once __DIR__ . '/../includes/header.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  if ($email === '' || $password === '') { $errors[] = 'Email and Password are required'; }
  if (!$errors) {
    $stmt = $mysqli->prepare('SELECT id, username, email, password_hash, student_id, role FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password_hash'])) {
      $_SESSION['user'] = $user;
      header('Location: /catphp/dashboard.php');
      exit;
    } else {
      $errors[] = 'Wrong email or password';
    }
    $stmt->close();
  }
}
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <h1 class="h4 mb-3">Login</h1>
    <?php if ($errors): ?><div class="alert alert-danger"><?php echo e(implode(', ', $errors)); ?></div><?php endif; ?>
    <form method="post" novalidate class="needs-validation">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?php echo e($_POST['email'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary" type="submit">Login</button>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

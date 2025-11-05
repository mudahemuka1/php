<?php require_once __DIR__ . '/../includes/header.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $student_id = trim($_POST['student_id'] ?? '');
  if ($username === '' || $email === '' || $password === '' || $student_id === '') {
    $errors[] = 'All fields are required';
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Invalid email'; }
  if (!$errors) {
    $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ? OR student_id = ? LIMIT 1');
    $stmt->bind_param('ss', $email, $student_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) { $errors[] = 'Email or Student ID already exists'; }
    $stmt->close();
  }
  if (!$errors) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 'student';
    $stmt = $mysqli->prepare('INSERT INTO users (username, email, password_hash, student_id, role) VALUES (?,?,?,?,?)');
    $stmt->bind_param('sssss', $username, $email, $hash, $student_id, $role);
    if ($stmt->execute()) { header('Location: /catphp/auth/login.php'); exit; }
    $errors[] = 'Registration failed';
    $stmt->close();
  }
}
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h1 class="h4 mb-3">Student Registration</h1>
    <?php if ($errors): ?><div class="alert alert-danger"><?php echo e(implode(', ', $errors)); ?></div><?php endif; ?>
    <form method="post" novalidate class="needs-validation">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="<?php echo e($_POST['username'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?php echo e($_POST['email'] ?? ''); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Student ID</label>
        <input type="text" name="student_id" class="form-control" required value="<?php echo e($_POST['student_id'] ?? ''); ?>">
      </div>
      <button class="btn btn-primary" type="submit">Register</button>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

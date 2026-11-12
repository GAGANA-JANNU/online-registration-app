<?php
// Online Registration Form - server-side processing and validation
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$errors = [];
$data = [
    'full_name' => '', 'email' => '', 'phone' => '',
    'dob' => '', 'gender' => '', 'course' => '',
    'address' => '', 'terms' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $key => $value) {
        $data[$key] = trim($_POST[$key] ?? '');
    }

    if ($data['full_name'] === '') $errors[] = 'Full name is required.';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!preg_match('/^[0-9+\-\s()]{7,20}$/', $data['phone'])) $errors[] = 'Enter a valid phone number.';
    if ($data['dob'] === '') $errors[] = 'Date of birth is required.';
    if (!in_array($data['gender'], ['Female', 'Male', 'Other', 'Prefer not to say'], true)) $errors[] = 'Select a valid gender.';
    if (!in_array($data['course'], ['BCA', 'B.Sc. Computer Science', 'B.Com', 'BBA', 'Other'], true)) $errors[] = 'Select a valid course.';
    if ($data['address'] === '') $errors[] = 'Address is required.';
    if ($data['terms'] !== 'yes') $errors[] = 'You must accept the declaration.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Student Registration</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<header class="site-header">
  <div class="brand-mark">SR</div>
  <div><p class="eyebrow">STUDENT PORTAL</p><h1>Online Registration</h1></div>
</header>
<main class="container">
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$errors): ?>
  <section class="success-card">
    <div class="success-icon">✓</div>
    <p class="eyebrow">SUBMISSION COMPLETE</p>
    <h2>Registration successful!</h2>
    <p class="muted">Your information has been received. Please review the details below.</p>
    <div class="receipt">
      <div class="receipt-heading"><h3>Application Details</h3><span>STUDENT APPLICATION</span></div>
      <dl>
        <div><dt>Full name</dt><dd><?= e($data['full_name']) ?></dd></div>
        <div><dt>Email address</dt><dd><?= e($data['email']) ?></dd></div>
        <div><dt>Phone number</dt><dd><?= e($data['phone']) ?></dd></div>
        <div><dt>Date of birth</dt><dd><?= e($data['dob']) ?></dd></div>
        <div><dt>Gender</dt><dd><?= e($data['gender']) ?></dd></div>
        <div><dt>Course</dt><dd><?= e($data['course']) ?></dd></div>
        <div class="full"><dt>Address</dt><dd><?= nl2br(e($data['address'])) ?></dd></div>
      </dl>
    </div>
    <div class="actions"><button class="button secondary" onclick="window.print()">Print application</button><a class="button" href="index.php">New registration</a></div>
  </section>
<?php else: ?>
  <section class="form-card">
    <div class="form-intro">
      <p class="eyebrow">APPLICATION FORM</p>
      <h2>Start your application</h2>
      <p class="muted">Fill in your details carefully. Fields marked <b>*</b> are required.</p>
    </div>
    <?php if ($errors): ?>
      <div class="error-box" role="alert"><strong>Please correct the following:</strong><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form id="registrationForm" method="POST" action="index.php" novalidate>
      <div class="form-grid">
        <div class="field"><label for="full_name">Full name *</label><input id="full_name" name="full_name" type="text" placeholder="Enter your full name" value="<?= e($data['full_name']) ?>" required></div>
        <div class="field"><label for="email">Email address *</label><input id="email" name="email" type="email" placeholder="name@example.com" value="<?= e($data['email']) ?>" required></div>
        <div class="field"><label for="phone">Phone number *</label><input id="phone" name="phone" type="tel" placeholder="+91 98765 43210" value="<?= e($data['phone']) ?>" required></div>
        <div class="field"><label for="dob">Date of birth *</label><input id="dob" name="dob" type="date" value="<?= e($data['dob']) ?>" required></div>
        <div class="field"><label for="gender">Gender *</label><select id="gender" name="gender" required><option value="">Choose an option</option><?php foreach (['Female','Male','Other','Prefer not to say'] as $v): ?><option <?= $data['gender']===$v?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="course">Course applying for *</label><select id="course" name="course" required><option value="">Select a course</option><?php foreach (['BCA','B.Sc. Computer Science','B.Com','BBA','Other'] as $v): ?><option <?= $data['course']===$v?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?></select></div>
        <div class="field full"><label for="address">Postal address *</label><textarea id="address" name="address" rows="3" placeholder="House number, street, city, state and PIN code" required><?= e($data['address']) ?></textarea></div>
      </div>
      <label class="check-row"><input type="checkbox" name="terms" value="yes" <?= $data['terms']==='yes'?'checked':'' ?> required><span>I confirm that the information provided is correct. *</span></label>
      <p class="form-note">Your information is used only for this demonstration registration workflow.</p>
      <button class="button submit-button" type="submit">Submit application <span>→</span></button>
    </form>
  </section>
<?php endif; ?>
<footer>© <?= date('Y') ?> Student Registration Portal · Demo project</footer>
</main>
<script src="script.js"></script>
</body>
</html>

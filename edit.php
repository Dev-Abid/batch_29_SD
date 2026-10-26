<?php
/**
 * UPDATE: Edit an existing employee by ID
 * Note for Instructor: Validation blocks are intentionally commented out
 * so SQA can test update bugs, and Developers can uncomment them to fix.
 */
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch existing employee record
$sql = "SELECT * FROM employees WHERE id = $id";
$result = mysqli_query($conn, $sql);
$employee = $result ? mysqli_fetch_assoc($result) : null;

if (!$employee) {
    die('Employee not found. <a href="index.php">Go back to list</a>');
}

$errors = [];
$name   = $employee['name'];
$email  = $employee['email'];
$phone  = $employee['phone'];
$role   = $employee['role'];
$salary = $employee['salary'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $role   = trim($_POST['role'] ?? '');
    $salary = trim($_POST['salary'] ?? '');

    // =====================================================================
    // [VALIDATION 1] Required / Empty Fields Check (Commented out for SQA)
    // =====================================================================
    /*
    if (empty($name) || empty($email) || empty($phone) || empty($role) || $salary === '') {
        $errors[] = 'All fields are required and cannot be empty.';
    }
    */

    // =====================================================================
    // [VALIDATION 2] Name Length Boundary Check: 3 to 50 characters
    // =====================================================================
    /*
    if (!empty($name) && (strlen($name) < 3 || strlen($name) > 50)) {
        $errors[] = 'Name must be between 3 and 50 characters long.';
    }
    */

    // =====================================================================
    // [VALIDATION 3] Email Format Validation
    // =====================================================================
    /*
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address (e.g. user@example.com).';
    }
    */

    // =====================================================================
    // [VALIDATION 4] Phone Format Validation (Digits only, 11 digits)
    // =====================================================================
    /*
    if (!empty($phone) && !preg_match('/^[0-9]{11}$/', $phone)) {
        $errors[] = 'Phone number must be exactly 11 digits (numbers only).';
    }
    */

    // =====================================================================
    // [VALIDATION 5] Salary Numeric & Boundary Validation (0 to 500,000)
    // =====================================================================
    /*
    if ($salary !== '' && (!is_numeric($salary) || (float) $salary < 0 || (float) $salary > 500000)) {
        $errors[] = 'Salary must be a positive number between 0 and 500,000.';
    }
    */

    if (empty($errors)) {
        $safeName   = mysqli_real_escape_string($conn, $name);
        $safeEmail  = mysqli_real_escape_string($conn, $email);
        $safePhone  = mysqli_real_escape_string($conn, $phone);
        $safeRole   = mysqli_real_escape_string($conn, $role);
        $safeSalary = (float) $salary;

        $updateSql = "UPDATE employees
                      SET name = '$safeName',
                          email = '$safeEmail',
                          phone = '$safePhone',
                          role = '$safeRole',
                          salary = '$safeSalary'
                      WHERE id = $id";

        if (mysqli_query($conn, $updateSql)) {
            header('Location: index.php?msg=updated');
            exit;
        } else {
            $errors[] = 'Database Error: ' . mysqli_error($conn);
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="page-header">
        <h1>Edit Employee (#<?php echo (int) $employee['id']; ?>)</h1>
        <a href="index.php" class="btn btn-secondary">&larr; Back to List</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo (int) $employee['id']; ?>" method="POST">
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required minlength="3" maxlength="50"> -->
            <span class="hint">Expected: 3 to 50 characters, required.</span>
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required> -->
            <span class="hint">Expected: Valid email format (must contain @ and domain).</span>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required pattern="[0-9]{11}" title="11 digit phone number"> -->
            <span class="hint">Expected: Exactly 11 digits (numbers only).</span>
        </div>

        <div class="form-group">
            <label for="role">Role / Department *</label>
            <select id="role" name="role">
                <option value="">-- Select Role --</option>
                <option value="Software Developer" <?php if ($role === 'Software Developer') echo 'selected'; ?>>Software Developer</option>
                <option value="SQA Engineer" <?php if ($role === 'SQA Engineer') echo 'selected'; ?>>SQA Engineer</option>
                <option value="UI/UX Designer" <?php if ($role === 'UI/UX Designer') echo 'selected'; ?>>UI/UX Designer</option>
                <option value="Project Manager" <?php if ($role === 'Project Manager') echo 'selected'; ?>>Project Manager</option>
            </select>
            <span class="hint">Expected: Must select a valid role.</span>
        </div>

        <div class="form-group">
            <label for="salary">Monthly Salary ($) *</label>
            <input type="number" step="0.01" id="salary" name="salary" value="<?php echo htmlspecialchars($salary); ?>">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="number" step="0.01" min="0" max="500000" id="salary" name="salary" value="<?php echo htmlspecialchars($salary); ?>" required> -->
            <span class="hint">Expected: Positive number between 0 and 500,000.</span>
        </div>

        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

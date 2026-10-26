<?php
/**
 * READ (Single): View a single employee's details by ID
 */
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM employees WHERE id = $id"; // parameter binding is not used here, but casting to int helps prevent SQL injection
$result = mysqli_query($conn, $sql);
$employee = $result ? mysqli_fetch_assoc($result) : null;

if (!$employee) {
    die('Employee not found. <a href="index.php">Go back to list</a>');
}

include __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="page-header">
        <h1>Employee Details (#<?php echo (int) $employee['id']; ?>)</h1>
        <a href="index.php" class="btn btn-secondary">&larr; Back to List</a>
    </div>

    <div class="detail-row">
        <div class="detail-label">ID</div>
        <div class="detail-value"><?php echo (int) $employee['id']; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Full Name</div>
        <div class="detail-value"><?php echo htmlspecialchars($employee['name']); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Email Address</div>
        <div class="detail-value"><?php echo htmlspecialchars($employee['email']); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Phone Number</div>
        <div class="detail-value"><?php echo htmlspecialchars($employee['phone']); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Role</div>
        <div class="detail-value"><span class="badge"><?php echo htmlspecialchars($employee['role']); ?></span></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Monthly Salary</div>
        <div class="detail-value">$<?php echo number_format((float) $employee['salary'], 2); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Created At</div>
        <div class="detail-value"><?php echo htmlspecialchars($employee['created_at']); ?></div>
    </div>

    <div style="margin-top: 20px;">
        <a href="edit.php?id=<?php echo (int) $employee['id']; ?>" class="btn btn-warning">Edit Employee</a>
        <a href="delete.php?id=<?php echo (int) $employee['id']; ?>" class="btn btn-danger">Delete Employee</a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

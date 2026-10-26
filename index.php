<?php
/**
 * READ (All): List all employees from the database
 */
require_once __DIR__ . '/config/db.php';

// Fetch all employees ordered by newest first
$sql = "SELECT * FROM employees ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

include __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="page-header">
        <h1>Employee Directory</h1>
        <a href="create.php" class="btn btn-primary">+ Add New Employee</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['msg'] === 'created') echo 'Employee added successfully!';
            if ($_GET['msg'] === 'updated') echo 'Employee updated successfully!';
            if ($_GET['msg'] === 'deleted') echo 'Employee deleted successfully!';
            ?>
        </div>
    <?php endif; ?>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Salary ($)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo (int) $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><span class="badge"><?php echo htmlspecialchars($row['role']); ?></span></td>
                            <td>$<?php echo number_format((float) $row['salary'], 2); ?></td>
                            <td class="actions">
                                <a href="view.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-info">View</a>
                                <a href="edit.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>

                                <!-- SQA DEMO: Delete runs immediately without confirmation dialog -->
                                <!-- <a href="delete.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a> -->
                                <!-- FIX: Uncomment below and remove line above to require Delete confirmation -->
                                <a href="delete.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No employees found. Click "+ Add New Employee" to create one.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

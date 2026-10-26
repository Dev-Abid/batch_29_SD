<?php
/**
 * DELETE: Remove an employee record by ID
 */
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $sql = "DELETE FROM employees WHERE id = $id";
    mysqli_query($conn, $sql);
}

header('Location: index.php?msg=deleted');
exit;

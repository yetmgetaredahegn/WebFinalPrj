<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// OPTIONAL: Role-based protection
// Usage: define $required_role before including this file

if (isset($required_role)) {
    if ($_SESSION['role'] !== $required_role) {
        // If wrong role, redirect to their correct dashboard
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit();
    }
}
?>
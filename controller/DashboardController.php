<?php
include '../db/db.php';

class DashboardController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getDashboardStats() {
        $stats = [];

        $stats['total_users'] = mysqli_fetch_assoc(
            mysqli_query($this->conn, "SELECT COUNT(*) as count FROM users")
        )['count'];

        $stats['total_books'] = mysqli_fetch_assoc(
            mysqli_query($this->conn, "SELECT COUNT(*) as count FROM books")
        )['count'];

        $stats['active_borrows'] = mysqli_fetch_assoc(
            mysqli_query($this->conn, "SELECT COUNT(*) as count FROM borrow_records WHERE status = 'active'")
        )['count'];

        $stats['pending_fines'] = mysqli_fetch_assoc(
            mysqli_query($this->conn, "SELECT COALESCE(SUM(amount), 0) as total FROM fines WHERE is_paid = 0")
        )['total'];

        return $stats;
    }
}
?>

<?php
include '../db/db.php';

class SettingsController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getSystemSettings() {
        // Placeholder for system settings
        return [
            'site_name' => 'Library Management System',
            'admin_email' => 'admin@library.com',
            'max_borrow_days' => 7,
            'fine_per_day' => 5.00
        ];
    }

    public function updateSettings($data) {
        // Placeholder for updating settings
        return true;
    }

    public function getBranchPolicies($branch_id) {
        $branch_id = (int)$branch_id;
        $query = "SELECT * FROM branch_policies WHERE branch_id = $branch_id";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function updateBranchPolicy($branch_id, $data) {
        $branch_id = (int)$branch_id;
        $max_borrow_days = (int)$data['max_borrow_days'];
        $max_books_per_member = (int)$data['max_books_per_member'];
        $fine_rate = (float)$data['fine_rate_per_day'];
        $max_renewals = (int)$data['max_renewals'];

        $query = "UPDATE branch_policies SET max_borrow_days = $max_borrow_days, 
                  max_books_per_member = $max_books_per_member, 
                  fine_rate_per_day = $fine_rate, 
                  max_renewals = $max_renewals 
                  WHERE branch_id = $branch_id";

        return mysqli_query($this->conn, $query);
    }
}
?>

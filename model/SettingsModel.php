<?php
include '../db/db.php';

class SettingsModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBranchPolicy($branch_id) {
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
                  max_renewals = $max_renewals WHERE branch_id = $branch_id";
        return mysqli_query($this->conn, $query);
    }
}
?>

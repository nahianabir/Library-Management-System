<?php
include '../db/db.php';

class DashboardModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getStats() {
        return [
            'users' => $this->countRecords('users'),
            'books' => $this->countRecords('books'),
            'branches' => $this->countRecords('branches'),
            'active_borrows' => $this->countRecords('borrow_records', "status = 'active'")
        ];
    }

    private function countRecords($table, $condition = null) {
        $query = "SELECT COUNT(*) as count FROM $table";
        if ($condition) {
            $query .= " WHERE $condition";
        }
        $result = mysqli_fetch_assoc(mysqli_query($this->conn, $query));
        return $result['count'] ?? 0;
    }
}
?>

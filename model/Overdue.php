<?php

include_once '../db/database.php';

class Overdue {

    public function overdueAlerts() {

        global $conn;

        $sql = "SELECT *
                FROM borrow_records
                WHERE due_date < CURDATE()
                AND status='active'";

        return mysqli_query($conn, $sql);
    }
}
?>
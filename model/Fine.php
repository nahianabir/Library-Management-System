<?php

include_once '../db/database.php';

class Fine {

    public function fineReports() {

        global $conn;

        $sql = "SELECT users.name,
                fines.amount,
                fines.reason,
                fines.is_paid

                FROM fines

                JOIN users
                ON users.id = fines.member_id";

        return mysqli_query($conn, $sql);
    }
}
?>
<?php

include_once '../db/database.php';

class Member {

    public function memberReports() {

        global $conn;

        $sql = "SELECT

                users.name AS member_name,

                branches.name AS branch_name,

                COUNT(borrow_records.book_id)
                AS total_books

                FROM borrow_records

                JOIN users
                ON borrow_records.member_id =
                users.id

                JOIN branches
                ON borrow_records.branch_id =
                branches.id

                GROUP BY

                users.id,
                branches.id

                ORDER BY total_books DESC";

        return mysqli_query($conn, $sql);
    }
}

?>
<?php

include_once __DIR__ . '/../db/database.php';

class Report {

    public function overdueLoans() {

        global $conn;

        $sql = "SELECT

                borrow_records.*,

                users.name AS member_name,

                books.title AS book_name,

                branches.name AS branch_name

                FROM borrow_records

                JOIN users
                ON borrow_records.member_id =
                users.id

                JOIN books
                ON borrow_records.book_id =
                books.id

                JOIN branches
                ON borrow_records.branch_id =
                branches.id

                WHERE due_date < CURDATE()

                AND status='active'";

        return mysqli_query($conn, $sql);
    }
}

?>
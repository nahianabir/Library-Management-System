<?php

include_once __DIR__ . '/../db/database.php';

class LibrarianActivity {

    public function activityReports() {

        global $conn;

        $sql = "SELECT

                users.name AS librarian_name,

                branches.name AS branch_name,

                COUNT(borrow_records.id)
                AS total_processed

                FROM users

                LEFT JOIN borrow_records
                ON users.id =
                borrow_records.librarian_id

                LEFT JOIN branches
                ON users.branch_id =
                branches.id

                WHERE users.role='librarian'

                GROUP BY

                users.id,
                branches.id

                ORDER BY total_processed DESC";

        return mysqli_query($conn, $sql);
    }
}

?>
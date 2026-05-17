<?php

include_once '../db/database.php';

class Librarian {

    public function librarianActivity() {

        global $conn;

        $sql = "SELECT users.name,
                COUNT(borrow_records.id)
                AS processed

                FROM users

                LEFT JOIN borrow_records
                ON users.id =
                borrow_records.librarian_id

                WHERE users.role='librarian'

                GROUP BY users.id";

        return mysqli_query($conn, $sql);
    }
}
?>
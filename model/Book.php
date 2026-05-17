<?php

include_once '../db/database.php';

class Book {

    public function borrowedBooks() {

        global $conn;

        $sql = "SELECT books.title,
                COUNT(borrow_records.book_id)
                AS total

                FROM borrow_records

                JOIN books
                ON books.id =
                borrow_records.book_id

                GROUP BY borrow_records.book_id

                ORDER BY total DESC";

        return mysqli_query($conn, $sql);
    }
}
?>
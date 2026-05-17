<?php

include_once '../db/database.php';

class Statistics {

    public function branchStatistics() {

        global $conn;

        $sql = "SELECT branches.name,
                COUNT(borrow_records.id)
                AS total_loans

                FROM branches

                LEFT JOIN borrow_records
                ON branches.id =
                borrow_records.branch_id

                GROUP BY branches.id";

        return mysqli_query($conn, $sql);
    }

    public function memberReports() {

        global $conn;

        $sql = "SELECT users.name,
                COUNT(borrow_records.id)
                AS total_borrow

                FROM users

                JOIN borrow_records
                ON users.id =
                borrow_records.member_id

                GROUP BY users.id";

        return mysqli_query($conn, $sql);
    }

    public function mostBorrowedBooks() {

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

    public function monthlyReports() {

        global $conn;

        $sql = "SELECT branch_id,
                COUNT(id)
                AS total_borrows

                FROM borrow_records

                GROUP BY branch_id";

        return mysqli_query($conn, $sql);
    }
}
?>
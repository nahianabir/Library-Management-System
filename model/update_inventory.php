<?php

include_once __DIR__ . '/../db/database.php';

class Inventory {

    public function allInventory() {

        global $conn;

        $sql = "SELECT branch_inventory.id,

                books.id AS book_id,
                books.title,

                branches.id AS branch_id,
                branches.name AS branch_name,

                branch_inventory.total_copies,
                branch_inventory.available_copies

                FROM branch_inventory

                JOIN books
                ON branch_inventory.book_id = books.id

                JOIN branches
                ON branch_inventory.branch_id = branches.id";

        return mysqli_query($conn, $sql);
    }



    public function allBooks() {

        global $conn;

        $sql = "SELECT * FROM books";

        return mysqli_query($conn, $sql);
    }



    public function allBranches() {

        global $conn;

        $sql = "SELECT * FROM branches";

        return mysqli_query($conn, $sql);
    }



    public function updateInventory(

        $book_id,
        $branch_id,
        $total,
        $available

    ) {

        global $conn;

        $sql = "UPDATE branch_inventory

                SET total_copies=?,
                available_copies=?

                WHERE book_id=?
                AND branch_id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "iiii",

            $total,
            $available,
            $book_id,
            $branch_id

        );

        return mysqli_stmt_execute($stmt);
    }
}

?>
<?php

include_once __DIR__ . '/../db/database.php';

class InventoryReport {

    public function allReports() {

        global $conn;

        $sql = "SELECT

                books.title,

                branches.name AS branch_name,

                branch_inventory.total_copies,

                branch_inventory.available_copies

                FROM branch_inventory

                JOIN books
                ON branch_inventory.book_id =
                books.id

                JOIN branches
                ON branch_inventory.branch_id =
                branches.id";

        return mysqli_query($conn, $sql);
    }
}

?>
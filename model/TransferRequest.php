<?php

include_once __DIR__ . '/../db/database.php';

class TransferRequest {

    public function allRequests() {

        global $conn;

        $sql = "SELECT

                inter_branch_requests.*,

                books.title AS book_name,

                users.name AS librarian_name,

                from_branch.name AS from_branch,

                to_branch.name AS to_branch

                FROM inter_branch_requests

                JOIN books
                ON inter_branch_requests.book_id =
                books.id

                JOIN users
                ON inter_branch_requests.requested_by =
                users.id

                JOIN branches AS from_branch
                ON inter_branch_requests.from_branch_id =
                from_branch.id

                JOIN branches AS to_branch
                ON inter_branch_requests.to_branch_id =
                to_branch.id";

        return mysqli_query($conn, $sql);
    }



    public function updateStatus(
        $id,
        $status
    ) {

        global $conn;

        $sql = "UPDATE inter_branch_requests

                SET status=?

                WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "si",

            $status,
            $id

        );

        return mysqli_stmt_execute($stmt);
    }
}

?>
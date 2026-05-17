<?php

include_once __DIR__ . '/../db/database.php';

class LibrarianAssign {

    public function allLibrarians() {

        global $conn;

        $sql = "SELECT users.*,
                branches.name AS branch_name

                FROM users

                LEFT JOIN branches
                ON users.branch_id =
                branches.id

                WHERE role='librarian'";

        return mysqli_query($conn, $sql);
    }



    public function allBranches() {

        global $conn;

        $sql = "SELECT * FROM branches";

        return mysqli_query($conn, $sql);
    }



    public function assignBranch(

        $user_id,
        $branch_id

    ) {

        global $conn;

        $sql = "UPDATE users

                SET branch_id=?

                WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "ii",

            $branch_id,
            $user_id

        );

        return mysqli_stmt_execute($stmt);
    }
}

?>
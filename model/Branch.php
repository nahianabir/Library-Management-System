<?php

include_once '../db/database.php';

class Branch {

    public function getBranches() {

        global $conn;

        $sql = "SELECT branches.*,
                users.name AS manager_name

                FROM branches

                LEFT JOIN users
                ON branches.manager_id = users.id";

        return mysqli_query($conn, $sql);
    }



    public function addBranch(
        $name,
        $address,
        $city,
        $phone
    ) {

        global $conn;

        $sql = "INSERT INTO branches
                (
                    name,
                    address,
                    city,
                    phone
                )

                VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "ssss",

            $name,
            $address,
            $city,
            $phone

        );

        return mysqli_stmt_execute($stmt);
    }
}

?>
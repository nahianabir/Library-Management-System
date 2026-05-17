<?php

include_once __DIR__ . '/../db/database.php';

class Policy {

    public function getPolicies() {

        global $conn;

        $sql = "SELECT branch_policies.*,
                branches.name AS branch_name

                FROM branch_policies

                JOIN branches
                ON branch_policies.branch_id =
                branches.id";

        return mysqli_query($conn, $sql);
    }



    public function getBranches() {

        global $conn;

        $sql = "SELECT * FROM branches";

        return mysqli_query($conn, $sql);
    }



    public function addPolicy(

    $branch_id,
    $days,
    $books,
    $fine,
    $renewals

) {

    global $conn;

    
    $checkSql = "SELECT *
                 FROM branch_policies
                 WHERE branch_id=?";

    $checkStmt =
    mysqli_prepare($conn, $checkSql);

    mysqli_stmt_bind_param(

        $checkStmt,
        "i",
        $branch_id

    );

    mysqli_stmt_execute($checkStmt);

    $result =
    mysqli_stmt_get_result($checkStmt);



    
    if(mysqli_num_rows($result) > 0) {

        $sql = "UPDATE branch_policies

                SET

                max_borrow_days=?,
                max_books_per_member=?,
                fine_rate_per_day=?,
                max_renewals=?

                WHERE branch_id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "iidii",

            $days,
            $books,
            $fine,
            $renewals,
            $branch_id

        );

    }

    
    else {

        $sql = "INSERT INTO branch_policies

                (
                    branch_id,
                    max_borrow_days,
                    max_books_per_member,
                    fine_rate_per_day,
                    max_renewals
                )

                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "iiidi",

            $branch_id,
            $days,
            $books,
            $fine,
            $renewals

        );
    }

    return mysqli_stmt_execute($stmt);
}
}
?>
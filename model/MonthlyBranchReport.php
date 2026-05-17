<?php

include_once __DIR__ . '/../db/database.php';

class MonthlyBranchReport {

    public function reports() {

        global $conn;

        $sql = "SELECT

                branches.name AS branch_name,

                COUNT(
                    DISTINCT borrow_records.id
                ) AS total_borrows,

                COUNT(
                    DISTINCT CASE
                    WHEN borrow_records.status='returned'
                    THEN borrow_records.id
                    END
                ) AS total_returns,

                IFNULL(
                    SUM(fines.amount),
                    0
                ) AS fines_collected,

                COUNT(
                    DISTINCT CASE
                    WHEN users.role='member'
                    THEN users.id
                    END
                ) AS new_members

                FROM branches

                LEFT JOIN borrow_records
                ON branches.id =
                borrow_records.branch_id

                LEFT JOIN fines
                ON branches.id =
                fines.branch_id

                LEFT JOIN users
                ON branches.id =
                users.branch_id

                GROUP BY branches.id";

        return mysqli_query($conn, $sql);
    }
}

?>
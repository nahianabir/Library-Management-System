<?php

include_once __DIR__ . '/../db/database.php';

class BranchStatistics {

    public function branchStats() {

        global $conn;

        $sql = "SELECT

                branches.name AS branch_name,

                COUNT(
                    CASE
                    WHEN borrow_records.status='active'
                    THEN borrow_records.id
                    END
                ) AS active_loans,

                COUNT(
                    CASE
                    WHEN borrow_records.due_date < CURDATE()

                    AND borrow_records.status='active'

                    THEN borrow_records.id
                    END
                ) AS overdue_loans,

                IFNULL(

                    SUM(

                        CASE
                        WHEN fines.is_paid = 0
                        THEN fines.amount
                        ELSE 0
                        END

                    ),

                    0

                ) AS outstanding_fines

                FROM branches

                LEFT JOIN borrow_records
                ON branches.id =
                borrow_records.branch_id

                LEFT JOIN fines
                ON borrow_records.id =
                fines.borrow_record_id

                GROUP BY branches.id";

        return mysqli_query($conn, $sql);
    }
}

?>
<?php
include_once __DIR__ . '/../db/database.php';

class User {

    public function login($email, $password) {

        global $conn;

        $sql = "SELECT * FROM users
                WHERE email=?
                AND password_hash=?
                AND role='branch_manager'";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $email, $password);

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}
?>
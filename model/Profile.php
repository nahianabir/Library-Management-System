<?php

include_once __DIR__ . '/../db/database.php';

class Profile {

    public function getProfile($id) {

        global $conn;

        $sql = "SELECT *
                FROM users
                WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }



    public function updateProfile(

        $id,
        $name,
        $email,
        $phone,
        $profile_pic

    ) {

        global $conn;

        $sql = "UPDATE users

                SET

                name=?,
                email=?,
                phone=?,
                profile_pic=?

                WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(

            $stmt,
            "ssssi",

            $name,
            $email,
            $phone,
            $profile_pic,
            $id

        );

        return mysqli_stmt_execute($stmt);
    }



    public function allBranches() {

        global $conn;

        $sql = "SELECT *
                FROM branches";

        return mysqli_query($conn, $sql);
    }
}

?>
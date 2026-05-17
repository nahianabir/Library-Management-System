<?php

include_once '../../db/database.php';

class Announcement {

    public function addAnnouncement(
        $title,
        $body
    ) {

        global $conn;

        $sql = "INSERT INTO announcements
                (title, body, author_id)
                VALUES (?, ?, 1)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $title,
            $body
        );

        return mysqli_stmt_execute($stmt);
    }

    public function allAnnouncements() {

        global $conn;

        $sql = "SELECT * FROM announcements
                ORDER BY id DESC";

        return mysqli_query($conn, $sql);
    }
}
?>
<?php

include_once '../db/database.php';

class PlatformAnnouncement {

    public function allAnnouncements() {

        global $conn;

        $sql = "SELECT *
                FROM announcements
                ORDER BY id DESC";

        return mysqli_query($conn, $sql);
    }
}
?>
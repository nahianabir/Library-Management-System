<?php

include_once '../../model/PlatformAnnouncement.php';

class PlatformAnnouncementController {

    public function announcements() {

        $announcement =
        new PlatformAnnouncement();

        return $announcement
        ->allAnnouncements();
    }
}
?>
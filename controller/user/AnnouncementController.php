<?php

include_once '../../model/Announcement.php';

class AnnouncementController {

    public function createAnnouncement() {

        if(isset($_POST['post_announcement'])) {

            $title = $_POST['title'];
            $body = $_POST['body'];

            $announcement = new Announcement();

            $announcement->addAnnouncement(
                $title,
                $body
            );

            header(
                "Location: ../../view/platform_announcements.php"
            );
        }
    }
}

$announcement = new AnnouncementController();

$announcement->createAnnouncement();

?>
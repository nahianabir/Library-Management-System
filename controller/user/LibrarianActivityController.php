<?php

include_once __DIR__ . '/../../model/LibrarianActivity.php';

class LibrarianActivityController {

    public function reports() {

        $activity = new LibrarianActivity();

        return $activity->activityReports();
    }
}

?>
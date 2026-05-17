<?php

include_once '../../model/Overdue.php';

class OverdueController {

    public function overdueData() {

        $overdue = new Overdue();

        return $overdue->overdueAlerts();
    }
}
?>
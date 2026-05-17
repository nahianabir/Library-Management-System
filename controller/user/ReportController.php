<?php

include_once '../../model/Report.php';

class ReportController {

    public function overdueReport() {

        $report = new Report();

        return $report->overdueLoans();
    }
}

$report = new ReportController();

$report->overdueReport();

?>
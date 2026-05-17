<?php

include_once __DIR__ . '/../../model/MonthlyBranchReport.php';

class MonthlyBranchReportController {

    public function allReports() {

        $report = new MonthlyBranchReport();

        return $report->reports();
    }
}

?>
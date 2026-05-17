<?php

include_once __DIR__ . '/../../model/BranchStatistics.php';

class BranchStatisticsController {

    public function statistics() {

        $stats = new BranchStatistics();

        return $stats->branchStats();
    }
}

?>
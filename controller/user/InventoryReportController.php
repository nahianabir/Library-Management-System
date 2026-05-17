<?php

include_once __DIR__ . '/../../model/InventoryReport.php';

class InventoryReportController {

    public function reports() {

        $inventory =
        new InventoryReport();

        return $inventory->allReports();
    }
}

?>
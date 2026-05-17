<?php

include_once '../../model/Fine.php';

class FineController {

    public function allFines() {

        $fine = new Fine();

        return $fine->fineReports();
    }
}
?>
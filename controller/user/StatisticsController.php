<?php

include_once '../../model/Statistics.php';

class StatisticsController {

    public function branchStats() {

        $stats = new Statistics();

        return $stats->branchStatistics();
    }

    public function memberStats() {

        $stats = new Statistics();

        return $stats->memberReports();
    }

    public function borrowedBooks() {

        $stats = new Statistics();

        return $stats->mostBorrowedBooks();
    }

    public function monthlyStats() {

        $stats = new Statistics();

        return $stats->monthlyReports();
    }
}
?>
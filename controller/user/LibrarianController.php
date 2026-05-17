<?php

include_once '../../model/Librarian.php';

class LibrarianController {

    public function activities() {

        $librarian = new Librarian();

        return $librarian->librarianActivity();
    }
}
?>
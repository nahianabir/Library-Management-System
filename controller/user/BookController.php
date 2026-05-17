<?php

include_once '../../model/Book.php';

class BookController {

    public function books() {

        $book = new Book();

        return $book->borrowedBooks();
    }
}
?>
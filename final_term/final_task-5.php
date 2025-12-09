<?php

class Book {
    
    private $title;
    private $author;
    private $year;

   
    public function __construct($title, $author, $year) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
    }

    
    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Year: {$this->year}";
    }

    
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setYear($year) {
        $this->year = $year;
    }
}


$book = new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925);


echo $book->getDetails() . "<br><br>";


$book->setTitle("1984");
$book->setAuthor("George Orwell");
$book->setYear(1949);


echo $book->getDetails();

?>
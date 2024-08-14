<?php
Class Book{

    public $bookId;
    public $title;

    public $description;

    public $categoryId;

    public $price;

    public $createdAt;

    public $updatedAt;

    public $sale;

    public $stock;

    public $hotItem;

    public $authors;

    public function __construct($id, $title, $description, $categoryId, $price, $createdAt, $updatedAt, $sale,$stock,$authors, $hotItem) {
        $this->bookId = $id;
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->sale = $sale;
        $this->stock = $stock;
        $this->authors = $authors;
        $this->hotItem = $hotItem;
    }
}

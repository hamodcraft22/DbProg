<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
include 'User.php';
/**
 * Description of Article
 *
 * @author ADMIN
 */
class Article extends User{
    //put your code here
    private $articleID;
    private $header;
    private $title;
    private $date;
    private $published;
    private $thumbnail;
    private $rating;
    private $rates;
    
    public function __construct($articleID, $header, $title, $date, $published, $thumbnail, $rating, $rates, $UserID) {
        parent::__construct($userID);
        $this->articleID = $articleID;
        $this->header = $header;
        $this->title = $title;
        $this->date = $date;
        $this->published = $published;
        $this->thumbnail = $thumbnail;
        $this->rating = $rating;
        $this->rates = $rates;
    }
    public function getArticleID() {
        return $this->articleID;
    }

    public function getHeader() {
        return $this->header;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPublished() {
        return $this->published;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getRates() {
        return $this->rates;
    }

    public function setArticleID($articleID): void {
        $this->articleID = $articleID;
    }

    public function setHeader($header): void {
        $this->header = $header;
    }

    public function setTitle($title): void {
        $this->title = $title;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function setPublished($published): void {
        $this->published = $published;
    }

    public function setThumbnail($thumbnail): void {
        $this->thumbnail = $thumbnail;
    }

    public function setRating($rating): void {
        $this->rating = $rating;
    }

    public function setRates($rates): void {
        $this->rates = $rates;
    }


}

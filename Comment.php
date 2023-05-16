<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Comment
 *
 * @author ADMIN
 */
include 'Article.php';
class Comment extends Article{
    //put your code here
    private $commentID;
    private $commentTitle;
    private $commentBody;
    
    public function __construct($commentID, $commentTitle, $commentBody, $articleID, $UserID) {
        parent::__construct($articleID, $UserID);
        $this->commentID = $commentID;
        $this->commentTitle = $commentTitle;
        $this->commentBody = $commentBody;
    }
    public function getCommentID() {
        return $this->commentID;
    }

    public function getCommentTitle() {
        return $this->commentTitle;
    }

    public function getCommentBody() {
        return $this->commentBody;
    }

    public function setCommentID($commentID): void {
        $this->commentID = $commentID;
    }

    public function setCommentTitle($commentTitle): void {
        $this->commentTitle = $commentTitle;
    }

    public function setCommentBody($commentBody): void {
        $this->commentBody = $commentBody;
    }


}

<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ArticleDocument
 *
 * @author ADMIN
 */
include 'Article.php';
class ArticleDocument extends Article{
    //put your code here
    private $documentID;
    private $documentName;
    private $documentPath;
    private $documentType;
    
    public function __construct($documentID, $documentName, $documentPath, $documentType, $articleID) {
        parent:: __construct($articleID);
        $this->documentID = $documentID;
        $this->documentName = $documentName;
        $this->documentPath = $documentPath;
        $this->documentType = $documentType;
    }
    public function getDocumentID() {
        return $this->documentID;
    }

    public function getDocumentName() {
        return $this->documentName;
    }

    public function getDocumentPath() {
        return $this->documentPath;
    }

    public function getDocumentType() {
        return $this->documentType;
    }

    public function setDocumentID($documentID): void {
        $this->documentID = $documentID;
    }

    public function setDocumentName($documentName): void {
        $this->documentName = $documentName;
    }

    public function setDocumentPath($documentPath): void {
        $this->documentPath = $documentPath;
    }

    public function setDocumentType($documentType): void {
        $this->documentType = $documentType;
    }


}

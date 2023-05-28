<?php

class artiDocument
{
    private $documentID;
    private $documentName;
    private $documentPath;
    private $documentType;
    private $articleID;

    public function __construct()
    {
        $this->documentID = null;
        $this->documentName = null;
        $this->documentPath = null;
        $this->documentType = null;
        $this->articleID = null;
    }

    public function getDocumentID()
    {
        return $this->documentID;
    }

    public function getDocumentName()
    {
        return $this->documentName;
    }

    public function getDocumentPath()
    {
        return $this->documentPath;
    }

    public function getDocumentType()
    {
        return $this->documentType;
    }

    public function getArticleID()
    {
        return $this->articleID;
    }

    public function setDocumentID($documentID)
    {
        $this->documentID = $documentID;
    }

    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;
    }

    public function setDocumentPath($documentPath)
    {
        $this->documentPath = $documentPath;
    }

    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;
    }

    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
    }
    
    public function initDocument($documentID, $documentName, $documentPath, $documentType, $articleID)
    {
        $this->documentID = $documentID;
        $this->documentName = $documentName;
        $this->documentPath = $documentPath;
        $this->documentType = $documentType;
        $this->articleID = $articleID;
    }
    
    public function initDwithID()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_document where documentID = ' . $this->getDocumentID() . ';';
            $data = $db->singleFetch($q);
            $this->initDocument($data->documentID, $data->documentName, $data->documentPath, $data->documentType, $data->articleID);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    public function saveDocument()
    {
        try {
            $db = Database::getInstance();
            $q = 'insert into dbProj_document (documentName, documentPath, documentType, articleID) values ("'.$this->getDocumentName().'" ,"'.$this->getDocumentPath().'" ,"'.$this->getDocumentType().'" ,'.$this->getArticleID().' )';
            $data = $db->querySql($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    public function updateDocument()
    {
        try {
            $db = Database::getInstance();
            $q = 'update dbProj_document set documentName = "'.$this->getDocumentName().'", documentPath = "'.$this->getDocumentPath().'", documentType = "'.$this->getDocumentType().'" where documentID = '.$this->getDocumentID().';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    public function deleteDoc()
    {
        try {
            $db = Database::getInstance();
            $q = 'delete from dbProj_document where documentID = '.$this->getDocumentID().';';
            $data = $db->querySql($q);
            unlink($this->getDocumentPath());
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function getAllDocument()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_document ';
            
            if ($this->getArticleID() != null)
            {
                $q .= 'where articleID =' . $this->getArticleID();
            }
            echo $q;
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
}

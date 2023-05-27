<?php

class Comment
{

    private $commentID;
    private $commentTitle;
    private $commentBody;
    private $commentDate;
    private $statusID;
    private $userID;
    private $articleID;

    public function __construct()
    {
        $this->commentID = null;
        $this->commentTitle = null;
        $this->commentBody = null;
        $this->commentDate = null;
        $this->statusID = 2;
        $this->userID = null;
        $this->articleID = null;
    }

    public function getCommentID()
    {
        return $this->commentID;
    }

    public function getCommentTitle()
    {
        return $this->commentTitle;
    }

    public function getCommentBody()
    {
        return $this->commentBody;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getArticleID()
    {
        return $this->articleID;
    }
    
    public function getStatusID()
    {
        return $this->statusID;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }

        
    public function setStatusID($statusID)
    {
        $this->statusID = $statusID;
    }

    
    public function setCommentID($commentID)
    {
        $this->commentID = $commentID;
    }

    public function setCommentTitle($commentTitle)
    {
        $this->commentTitle = $commentTitle;
    }

    public function setCommentBody($commentBody)
    {
        $this->commentBody = $commentBody;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
    }

    function getUserFullName()
    {
        try {
            $db = Database::getInstance();
            $q = 'select fullname from dbProj_user where userID = ' . $this->getUserID() . ';';
            $data = $db->singleFetch($q);
            return $data->fullname;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }

    public function initComment($commentID, $commentTitle, $commentBody, $commentDate, $statusID, $userID, $articleID)
    {
        $this->commentID = $commentID;
        $this->commentTitle = $commentTitle;
        $this->commentBody = $commentBody;
        $this->commentDate = $commentDate;
        $this->statusID = $statusID;
        $this->userID = $userID;
        $this->articleID = $articleID;
    }

    public function initCwithID()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_comment where commentID = ' . $this->getCommentID() . ';';
            $data = $db->singleFetch($q);
            $this->initComment($data->commentID, $data->commentTitle, $data->commentBody, $data->commentDate, $data->statusID, $data->userID, $data->articleID);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    public function saveCom()
    {
        try {
            $db = Database::getInstance();
            $q = 'insert into dbProj_comment (commentTitle, commentBody, statusID, userID, articleID) values ("'.$this->getCommentTitle().'", "'.$this->getCommentBody().'", '.$this->getStatusID().', '.$this->getUserID().', '.$this->getArticleID().')';
            $data = $db->querySql($q);
            if ($data != null)
            {
                return $data;
            }
            else
            {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    public function deleteCom()
    {
        try {
            $db = Database::getInstance();
            $q = 'update dbProj_comment set statusID=4 where commentID = '.$this->getCommentID().';';
            $data = $db->querySql($q);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    public function adminDeleteCom()
    {
        try {
            $db = Database::getInstance();
            $q = 'update dbProj_comment set statusID=5 where commentID = '.$this->getCommentID().';';
            $data = $db->querySql($q);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    function getAllComms()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_comment ';

            if ($this->getArticleID() != null)
            {
                $q .= 'where articleID = ' . $this->getArticleID();
            }

            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

}

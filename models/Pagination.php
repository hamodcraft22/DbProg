
<?php

// custome pageination 
class Pagination
{

    // total records in table
    public $total_records;
    // limit of items per page
    private $limit;
    // total number of pages needed
    private $total_pages;
    // first and back links
    private $firstBack;
    // next and last links
    private $nextLast;
    // where are we among all pages?
    private $where;

    public function __construct()
    {
        
    }
    
    public function getTotal_records()
    {
        return $this->total_records;
    }

    public function getTotal_pages()
    {
        return $this->total_pages;
    }

    public function getFirstBack()
    {
        return $this->firstBack;
    }

    public function getNextLast()
    {
        return $this->nextLast;
    }

    public function getWhere()
    {
        return $this->where;
    }
    
    public function getLimit()
    {
        return $this->limit;
    }

    public function setTotal_records($total_records)
    {
        $this->total_records = $total_records;
    }

    public function setTotal_pages($total_pages)
    {
        $this->total_pages = $total_pages;
    }

    public function setFirstBack($firstBack)
    {
        $this->firstBack = $firstBack;
    }

    public function setNextLast($nextLast)
    {
        $this->nextLast = $nextLast;
    }

    public function setWhere($where)
    {
        $this->where = $where;
    }

    
    // determines the total number of records in table (count of passed data)
    public function totalRecords($data)
    {
        $this->setTotal_records(count($data));
    }

    // sets limit and number of pages
    public function setLimit($limit)
    {
        $this->limit = $limit;

        // determines how many pages there will be
        if (($this->total_records) != 0)
        {
            $this->total_pages = ceil($this->total_records / $this->limit);
        }
    }

    // find out the starting point for each page 
    public function startIndex()
    {
        $startingIndex = (($this->where)-1) * ($this->limit);
        return $startingIndex;
    }

    // get first and back links
    public function firstBack()
    {
        return $this->firstBack;
    }

    // get next and last links
    public function nextLast()
    {
        return $this->nextLast;
    }

    // get where we are among pages
    public function where()
    {
        return $this->where;
    }

}

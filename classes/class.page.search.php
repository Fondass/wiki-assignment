<?php

/* 
 * usage: search page that creates a search class and hands it 
 * paramters, then calls to it.
 * 
 * author: Ian de Jong
 */


class SearchPage extends Wiki
{

    public $search;
    protected $user;
    protected $db;
    
    public function __construct($db, $user)
    {
        $this->db = $db;
        $this->user = $user;
        $this->search = new Search();
    }
        
    public function bodyContent()
    {
        $this->search->searchBox($this->db, 'title');
    }
}

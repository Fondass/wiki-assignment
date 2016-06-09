<?php

require_once('classes/class.search.php');


class SearchPage extends Wiki
{
    var $tags = array();   
    var $search;
    var $user;
    var $db;
    var $title;
    
    public function __construct($db, $user)
    {
        $this->db = $db;
        $this->user = $user;
        $this->search = new Search();
    }
        
    public function bodyContent()
    {
        $this->search->searchBoxNameTag($this->db);
    }
}

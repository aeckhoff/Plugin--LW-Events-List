<?php

namespace LwEventsList\Model\DataHandler;

class QueryHandler
{
    
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getAllActualEvents($targetid)
    {
        $this->db->setStatement("SELECT * FROM t:lw_items WHERE itemtype = :itemtype AND page_id = :targetid AND ( :date <= free_date OR :date <= opt7text ) ORDER BY free_date ASC ");
        $this->db->bindParameter("targetid", "i", $targetid);
        $this->db->bindParameter("itemtype", "s", "lwevent");
        $this->db->bindParameter("date", "i", date("Ymd"));

        return $this->db->pselect();
    }
    
    public function getAllArchivedEvents($targetid)
    {
        $this->db->setStatement('SELECT * FROM t:lw_items WHERE itemtype = :itemtype AND page_id = :targetid AND :date > free_date AND :date > opt7text ORDER BY free_date DESC ');
        $this->db->bindParameter("targetid", "i", $targetid);
        $this->db->bindParameter("itemtype", "s", "lwevent");
        $this->db->bindParameter("date", "i", date("Ymd"));
        
        return $this->db->pselect();
    }
}
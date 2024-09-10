<?php
class AFP
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAFPs()
    {
        $this->db->query('SELECT * FROM afp where status = 1');
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

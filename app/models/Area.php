<?php

class Area
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAreas() {
        $this->db->query('SELECT * FROM hr_surgepays.areas where status=1;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

<?php

class Bill
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBillsTo() {
        $this->db->query('SELECT * FROM hr_surgepays.bills where status=1;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

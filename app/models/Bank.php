<?php
class Bank
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBanks()
    {
        $this->db->query('SELECT * FROM hr_surgepays.banks where status = 1');
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

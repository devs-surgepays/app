<?php

class Position
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPositions()
    {
        $this->db->query('SELECT * FROM hr_surgepays.positions where status=1 order by positionName asc');
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getPositionsEnglish()
    {
        $this->db->query('SELECT * FROM hr_surgepays.positions where status=1 and positionNameEnglish is not null order by positionNameEnglish asc;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

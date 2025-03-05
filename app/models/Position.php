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

    public function getPositionsGroupBy(){
        $this->db->query('SELECT MAX(positionName) , positionName FROM positions where status=1 GROUP BY positionName;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getPositionById($positionId) {
        $this->db->query('SELECT * FROM hr_surgepays.positions where positionId=:positionId;');
        $this->db->bind(':positionId', $positionId);
        $result = $this->db->resultSetFetch();
        return $result;
    }
}

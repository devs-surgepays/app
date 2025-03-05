<?php

class Department
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDeparments() {
        $this->db->query('SELECT * FROM hr_surgepays.departments where status=1;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getDepartmentById($departmentId) {
        $this->db->query('SELECT * FROM hr_surgepays.departments where departmentId=:departmentId;');
        $this->db->bind(':departmentId', $departmentId);
        $result = $this->db->resultSetFetch();
        return $result;
    }
}

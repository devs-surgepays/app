<?php

class MedicalHistory {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMedicalConditionsByEmployeeId($employeeId){
        $this->db->query('SELECT * FROM hr_surgepays.medical_history where employeeId=:employeeId and status=1;');
        $this->db->bind(':employeeId', $employeeId);
        $result = $this->db->resultSetFetch();
        return $result;
    }

    public function addMedicalConditions($data){
        $this->db->insertQuery('hr_surgepays.medical_history', $data);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }

    public function updateMedicalConditions($data)
    {
        $this->db->updateQuery("hr_surgepays.medical_history", $data, "medicalHistoryId=:medicalHistoryId");
    }
}


?>
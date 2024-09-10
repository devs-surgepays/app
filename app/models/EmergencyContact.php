<?php

class EmergencyContact
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getEmergencyContacts($employeeId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.emergency_contacts
        inner join relationships on relationships.relationshipId = emergency_contacts.relationshipId
        where employeeId=:employeeId and emergency_contacts.status=1');
        $this->db->bind(":employeeId", $employeeId);
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function saveEmergContact($dataFields)
    {
        $this->db->insertQuery('hr_surgepays.emergency_contacts', $dataFields);
        $lastInsert = $this->db->lastinsertedId();
        return $lastInsert;
    }

    public function updateEmergeContact($dataFields)
    {
        $this->db->updateQuery('hr_surgepays.emergency_contacts', $dataFields, 'emergencyContactId=:emergencyContactId');
    }

    public function getInfoEmergencyContactId($id)
    {
        $this->db->query('SELECT * FROM hr_surgepays.emergency_contacts where emergencyContactId = :emergencyContactId;');
        $this->db->bind(":emergencyContactId", $id);
        $result = $this->db->resultSetFetch();
        return $result;
    }
}

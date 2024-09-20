<?php

class FinancialDependent
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getFinancialDependents($employeeId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.financial_dependents
        inner join relationships on relationships.relationshipId = financial_dependents.relationshipId
        where employeeId=:employeeId and financial_dependents.status=1');
        $this->db->bind(":employeeId", $employeeId);
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getInfofinancialDependentId($id){
        $this->db->query('SELECT * FROM hr_surgepays.financial_dependents where financialDependentId = :financialDependentId;');
        $this->db->bind(":financialDependentId", $id);
        $result = $this->db->resultSetFetch();
        return $result;
    }


    public function saveFinancialDependent($dataFields)
    {
        $this->db->insertQuery('hr_surgepays.financial_dependents', $dataFields);
        $lastInsert = $this->db->lastinsertedId();
        return $lastInsert;
    }

    public function updateFinancialDependent($dataFields){
        $this->db->updateQuery('hr_surgepays.financial_dependents', $dataFields, 'financialDependentId=:financialDependentId');

    }
}

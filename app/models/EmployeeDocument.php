<?php
class EmployeeDocument
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function saveEmployeeDocument($data)
    {
        $data = [
            'employeeId' => $data['employeeId'],
            'documentTypeId' => $data['documentTypeId'],
            'document' => $data['document']
        ];
        $this->db->insertQuery('hr_surgepays.employee_documents', $data);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }

    public function getEmployeDocument($employeeId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employee_documents ed inner join documents_type dt on dt.documentTypeId =  ed.documentTypeId WHERE ed.employeeId = :employeeId AND ed.status = 1;');
        $this->db->bind(':employeeId', $employeeId);
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function removedEmployeeDocument($employeeId, $documentTypeId)
    {
        $data = [
            'employeeId' => $employeeId,
            'documentTypeId' => $documentTypeId,
            'status' => 0,
        ];
        $this->db->updateQuery('hr_surgepays.employee_documents', $data, 'employeeId=:employeeId and documentTypeId=:documentTypeId');
    }

    public function updateEmployeeDocument($dataFields)
    {
        $this->db->updateQuery('hr_surgepays.employee_documents', $dataFields, 'employeeDocumentId=:employeeDocumentId');
    }

    public function getTypesDocuments() {
        $this->db->query('SELECT * FROM hr_surgepays.documents_type where status=1 and folderName is not null;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }
    public function getInfoDocumentTypeById($documentTypeId) {
        $this->db->query('SELECT * FROM hr_surgepays.documents_type where documentTypeId = :documentTypeId and status=1');
        $this->db->bind(':documentTypeId', $documentTypeId);
        $result = $this->db->resultSetFetch();
        return $result;
    }
}

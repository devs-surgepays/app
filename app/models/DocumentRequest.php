<?php
class DocumentRequest
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function saveDocumentRequest($data)
    {
        $this->db->insertQuery('hr_surgepays.employee_documents_requests', $data);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }

    public function getDocumentsRequestsByEmployeeId($employeeId)
    {
        $this->db->query('SELECT * FROM employee_documents_requests WHERE employeeId = :employeeId AND active = 1 ORDER BY createdAt DESC');
        $this->db->bind(':employeeId', $employeeId);
        return $this->db->resultSet();
    }

    public function getDocumentsRequests($filters)
    {
        $this->db->query('SELECT edr.*, e.employeeId, e.firstName, e.firstLastName, e.badge FROM employee_documents_requests edr INNER JOIN employees e ON edr.employeeId = e.employeeId 
        WHERE edr.active = 1
        ' . (!empty($filters['requestId']) ? ' AND edr.employeeDocumentsRequestsId = :requestId' : '') . '
        ' . (!empty($filters['documentType']) ? ' AND edr.documentType = :type ' : '') . '
        ' . (!empty($filters['employeeName']) ? ' AND (e.firstName LIKE :employeeName OR e.firstLastName LIKE :employeeName) ' : '') . '
        ' . (!empty($filters['status']) ? ' AND edr.status = :status ' : '') . '
        ' . (!empty($filters['startDate']) ? ' AND DATE(edr.createdAt) >= :startDate ' : '') . '
        ' . (!empty($filters['endDate']) ? ' AND DATE(edr.createdAt) <= :endDate ' : '') . '
        ORDER BY edr.createdAt DESC');
        
        if (!empty($filters['requestId'])) {
            $this->db->bind(':requestId', $filters['requestId']);
        }
        if (!empty($filters['documentType'])) {
            $this->db->bind(':type', $filters['documentType']);
        }
        if (!empty($filters['employeeName'])) {
            $this->db->bind(':employeeName', '%' . $filters['employeeName'] . '%');
        }
        if (!empty($filters['status'])) {
            $this->db->bind(':status', $filters['status']);
        }
        if (!empty($filters['startDate'])) {
            $this->db->bind(':startDate', $filters['startDate']);
        }
        if (!empty($filters['endDate'])) {
            $this->db->bind(':endDate', $filters['endDate']);
        }

        return $this->db->resultSet();
    }

    public function markAsPrinted($requestId)
    {
        try {
            $data = [
                'employeeDocumentsRequestsId' => $requestId,
                'status' => 2
            ];
            $this->db->updateQuery("hr_surgepays.employee_documents_requests", $data, "employeeDocumentsRequestsId=:employeeDocumentsRequestsId");
            // $this->db->query('UPDATE employee_documents_requests SET status = 2 WHERE employeeDocumentsRequestsId = :requestId');
            // $this->db->bind(':requestId', $requestId);
            // $this->db->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to mark document request as printed: " . $e->getMessage());
        }
    }
}

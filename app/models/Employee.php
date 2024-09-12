<?php
class Employee
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getEmployees()
    {
        $this->db->query('SELECT * FROM
            hr_surgepays.employees e order by createdAt asc;');
        $result = $this->db->resultSet();

        return $result;
    }
    public function countRegisterEmployee($searchQuery)
    {
        $query = '';

        if (!empty($searchQuery)) $query = "where " . $searchQuery;

        $this->db->query('SELECT COUNT(*) AS numrows  FROM hr_surgepays.employees e ' . $query);
        $result = $this->db->resultSetFetch();
        return $result;
    }
    public function readRegisters($offset, $per_page, $searchQuery, $orderby)
    {
        $query = '';
        if (!empty($searchQuery)) $query = "where " . $searchQuery . ' ';

        $this->db->query("SELECT *, e.status as statusEmployee FROM hr_surgepays.employees e 
        INNER JOIN departments d ON d.departmentId = e.departmentId
        INNER JOIN positions p ON p.positionId = e.positionId 
        " . $query . " ORDER BY $orderby limit $offset,$per_page;");
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getTotalEmployeeActive()
    {
        $this->db->query("SELECT count(*) as 'TotalEmployeeActive' FROM hr_surgepays.employees where status=1;");
        $result = $this->db->resultSetFetch();
        return $result['TotalEmployeeActive'];
    }
    public function getTotalEmployee()
    {
        $this->db->query("SELECT count(*) as 'TotalEmployee' FROM hr_surgepays.employees");
        $result = $this->db->resultSetFetch();
        return $result['TotalEmployee'];
    }

    public function getTotalEmployeeCustomerServices()
    {
        $this->db->query("SELECT count(*) as 'totalCustomer' FROM hr_surgepays.employees where status=1 and positionId in (2,52,53,54,64);");
        $result = $this->db->resultSetFetch();
        return $result['totalCustomer'];
    }

    public function getTotalEmployeeHiredToday()
    {
        $this->db->query("SELECT count(*) as 'hiredToday' FROM hr_surgepays.employees where DATE(createdAt) = CURDATE();");
        $result = $this->db->resultSetFetch();
        return $result['hiredToday'];
    }

    public function createBadgeEmployee()
    {
        $this->db->query('SELECT badge FROM hr_surgepays.employees order by badge desc limit 1;');
        $result = $this->db->resultSetFetch();
        $newBadge = $result['badge'] + 1;
        return $newBadge;
    }

    public function createEmployee($dataSave)
    {
        $dataEmployee = [
            'badge' => $dataSave['badge'],
            'firstName' => $dataSave['firstName'],
            'secondName' => $dataSave['secondName'],
            'thirdName' => $dataSave['thirdName'],
            'firstLastName' => $dataSave['firstLastName'],
            'secondLastName' => $dataSave['secondLastName'],
            'thirdLastName' => $dataSave['thirdLastName'],
            'personalEmail' => $dataSave['personalEmail'],
            'contactPhone' => $dataSave['contactPhone'],
            'dob' => $dataSave['dob'],
            'hiredDate' => $dataSave['hiredDate'],

            'address' => $dataSave['address'],
            'stateId' => $dataSave['stateId'],
            'cityId' => $dataSave['cityId'],
            'districtId' => $dataSave['districtId'],
            'genderId' => $dataSave['genderId'],
            'corporateEmail' => $dataSave['corporateEmail'],
            'positionId' => $dataSave['positionId'],
            'departmentId' => $dataSave['departmentId'],
            'areaId' => $dataSave['areaId'],
            'superiorId' => $dataSave['superiorId'],
            'documentNumber' => $dataSave['documentNumber'],
            'documentTypeId' => 1,
            'documentExpDate' => $dataSave['documentExpDate'],
            'documentExpedDate' => $dataSave['documentExpedDate'],
            'documentExpedPlace' => $dataSave['documentExpedPlace'],
            'afpTypeId' => $dataSave['afpTypeId'],
            'afpNumber' => $dataSave['afpNumber'],
            'ssn' => $dataSave['ssn'],
            'bankId' => $dataSave['bankId'],
            'bankAccount' => $dataSave['bankAccount'],
            'children' => $dataSave['children'],
            'maritalStatus' => $dataSave['maritalStatus'],
            'educationLevel' => $dataSave['educationLevel'],
            'career' => $dataSave['career'],
            'contractType' => $dataSave['contractType'],
            'workHours' => $dataSave['workHours'],
            'salary' => $dataSave['salary'],
            'billTo' => $dataSave['billTo'],
            'thirdName' => $dataSave['thirdName'],
            'thirdLastName' => $dataSave['thirdLastName'],
            'birthMunicipality' => $dataSave['birthMunicipality'],
            'birthDeparment' => $dataSave['birthDeparment'],
            'homePhone' => $dataSave['homePhone'],
            'nationality' => $dataSave['nationality'],
            'contractsigning' => $dataSave['contractsigning'],
            'signingContractHeadset' => $dataSave['signingContractHeadset'],
            'signingConfidentialityAgreement' => $dataSave['signingConfidentialityAgreement'],
            'bonus' => $dataSave['bonus'],
        ];
        $this->db->insertQuery('hr_surgepays.employees', $dataEmployee);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }

    public function updatedEmployee($data)
    {
        $this->db->updateQuery("hr_surgepays.employees", $data, "employeeId=:employeeId");
    }

    public function getEmployeeByBadge($badge)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employees where badge=:badge;');
        $this->db->bind(':badge', $badge);
        $result = $this->db->resultSetFetch();

        return $result;
    }

    public function getStates()
    {
        $this->db->query('SELECT * FROM hr_surgepays.states;');
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getCitiesByStatesId($stateId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.cities where stateId = :stateId');
        $this->db->bind(':stateId', $stateId);
        $result = $this->db->resultSetAssoc();
        return $result;
    }
    public function getDistrictByCityId($cityId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.districts where cityId = :cityId');
        $this->db->bind(':cityId', $cityId);
        $result = $this->db->resultSetAssoc();
        return $result;
    }
    public function getEmployeeDetails($idEmployee)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employees AS em  WHERE em.employeeId = :employeeId;');
        $this->db->bind(':employeeId', $idEmployee);
        $result = $this->db->resultSetFetch();
        return $result;
    }
    public function getEmployeeDetailsByBadge($badge)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employees AS em  WHERE em.badge = :badge;');
        $this->db->bind(':badge', $badge);
        $result = $this->db->resultSetFetch();
        return $result;
    }

    public function getEmployeeByDeparment()
    {
        $this->db->query("SELECT 
            de.name AS departmentName,
            COUNT(em.employeeId) AS totalEmployees
        FROM
            hr_surgepays.employees em
            INNER JOIN departments de ON em.departmentId = de.departmentId
        WHERE
            em.status = 1
        GROUP BY
            de.name");
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getNamePhoto($idEmployee)
    {
        $this->db->query('SELECT photo FROM employees where employeeId=:employeeId');
        $this->db->bind('employeeId', $idEmployee);
        $re = $this->db->resultSetFetch();
        return $re['photo'];
    }

    public function getEmployeesByStatus($status)
    {

        $query = "SELECT 
                    e.badge as Badge,
                    e.firstName as 'First Name',
                    e.secondName as 'Second Name',
                    e.thirdName as 'Third Name',
                    e.firstLastName as 'First Last Name',
                    e.secondLastName as 'Second Last Name',
                    e.thirdLastName as 'Third Last Name',
                    e.personalEmail as 'Personal Email',
                    e.contactPhone as 'Contact Phone',
                    e.dob as 'DOB',
                    e.address as 'Address',
                    s.stateName as 'State',
                    c.cityName as 'City',
                    d.districtName as 'District',
                    CASE
                        WHEN e.genderId = 0 THEN 'M'
                        WHEN e.genderId = 1 THEN 'F'
                        WHEN e.genderId = 2 THEN 'Other'
                        ELSE 'Unknown'
                    END AS 'Gender',
                    e.corporateEmail as 'Corporate Email',
                    p.positionName as 'Position',
                    CONCAT(ee.firstName, ' ', ee.firstLastName) AS 'Superior',
                    de.name AS 'Department',
                    e.documentNumber as 'Document Number'
                FROM
                    employees e
                        LEFT JOIN
                    states s ON s.stateId = e.stateId
                        LEFT JOIN
                    cities c ON c.cityId = e.cityId
                        INNER JOIN
                    departments de ON de.departmentId = e.departmentId
                        LEFT JOIN
                    districts d ON d.districtId = e.districtId
                        INNER JOIN
                    users u ON u.userId = e.superiorId
                        INNER JOIN
                    employees ee ON ee.employeeId = u.employeeId
                        INNER JOIN
                    positions p ON p.positionId = e.positionId";

        if ($status != 2) {
            $query .= " WHERE e.status=:status";
            $this->db->query($query);
            $this->db->bind('status', $status);
        } else {
            $this->db->query($query);
        }

        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

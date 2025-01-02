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
        $showEmWhere = '';
        $withWhere = true;
        if (!empty($searchQuery)) {
            $query = "where " . $searchQuery;
            $withWhere = false;
        }
        $showEmWhere = getPLEmployeeTable($withWhere);

        if (!getPLShowInactiveEmployee()) {
            $showEmWhere .= (!empty($query) or !empty($showEmWhere)) ? ' and em.status=1 ' : ' where em.status=1 ';
        }
        $this->db->query('SELECT COUNT(*) AS numrows  FROM hr_surgepays.employees em INNER JOIN positions p ON p.positionId = em.positionId ' . $query . $showEmWhere );
        $result = $this->db->resultSetFetch();
        return $result;
    }
    public function readRegisters($offset, $per_page, $searchQuery, $orderby)
    {
        $query = '';
        $showEmWhere = '';
        $withWhere = true;
        if (!empty($searchQuery)) {
            $query = "where " . $searchQuery . ' ';
            $withWhere = false;
        }

        $showEmWhere = getPLEmployeeTable($withWhere);

        if (!getPLShowInactiveEmployee()) {
            $showEmWhere .= (!empty($query) or !empty($showEmWhere)) ? ' and em.status=1 ' : ' where em.status=1 ';
        }
        
        $this->db->query("SELECT *, em.status as statusEmployee,
        concat_ws(' ', em.firstName, em.secondName,em.thirdName,em.firstLastName,em.secondLastName ) as 'fullName',
        DATE_FORMAT(hiredDate, '%M %e, %Y') AS formattedHiredDate
        FROM hr_surgepays.employees em 
        INNER JOIN departments d ON d.departmentId = em.departmentId
        INNER JOIN positions p ON p.positionId = em.positionId 
        " . $query . " $showEmWhere ORDER BY $orderby limit $offset,$per_page;");
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getTotalEmployeeActive($idBillTo = 1)
    {
        $showEmWhere = getPLEmployeeTable(false);
        $this->db->query("SELECT count(*) as 'TotalEmployeeActive' FROM hr_surgepays.employees em where em.status=1 and em.billTo = $idBillTo $showEmWhere;");
        $result = $this->db->resultSetFetch();
        return $result['TotalEmployeeActive'];
    }

    public function getTotalEmployeeCustomerServices($idBillTo = 1)
    {
        $showEmWhere = getPLEmployeeTable(false);

        $this->db->query("SELECT count(*) as 'totalCustomer' FROM hr_surgepays.employees em
        inner join positions p on em.positionId = p.positionId
        where em.status=1 and positionName like '%AGENTE DE SERVICIO AL CLIENTE%' and em.billTo = $idBillTo $showEmWhere");
        $result = $this->db->resultSetFetch();
        return $result['totalCustomer'];
    }

    public function getTotalEmployeeHiredToday($idBillTo = 1)
    {
        $this->db->query("SELECT count(*) as 'hiredToday' FROM hr_surgepays.employees where DATE(createdAt) = CURDATE() and employees.billTo = $idBillTo;");
        $result = $this->db->resultSetFetch();
        return $result['hiredToday'];
    }

    public function createBadgeEmployee($billTo)
    {
        $this->db->query('SELECT badge FROM hr_surgepays.employees where billTo=:billTo order by badge desc limit 1;');
        $this->db->bind(':billTo', $billTo);
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
            'documentTypeId' => $dataSave['documentTypeId'],
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
        $showEmWhere = getPLEmployeeTable(false);

        // If the user has no permissions to view another billTo, add the standar (billTo=1)
        if (!getPLAnotherBillTo()) $showEmWhere .= ' and em.billTo=1 '; // surgepays
        
        $this->db->query('SELECT *  FROM hr_surgepays.employees AS em  WHERE em.badge = :badge ' . $showEmWhere . '');
        $this->db->bind(':badge', $badge);
        $result = $this->db->resultSetFetch();
        return $result;
    }
    public function getEmployeeReadByBadge($badge)
    {
        $showEmWhere = getPLEmployeeTable(false);

        if (!getPLShowInactiveEmployee()) $showEmWhere .= ' and em.status = 1 '; 
        if (!getPLAnotherBillTo()) $showEmWhere .= ' and em.billTo=1 '; // surgepays

        $this->db->query('SELECT
            em.employeeId as employeeId,
            em.badge as badge,
            em.photo,
            em.personalEmail,
            concat_ws(" ",em.firstName,em.secondName,em.thirdName,em.firstLastName,em.secondLastName,em.thirdLastName) as fullname,
            em.contactPhone AS contactPhone,
            em.homePhone AS homePhone,
            IF (em.status=1, "Activo","Inactivo") as status,
            de.name AS departamentName,
            ar.areaName as areaName,
            p.positionName as positionName,
            em.corporateEmail,
            em.hiredDate as hiredDate,
            em.hiredDateOld as hiredDateOld,
            em.contractType as contractType,
            em.workHours as workHours,
            IF (em.bonus=1, "Yes","No") as bonus
            FROM
            employees em
                LEFT JOIN
            departments de ON de.departmentId = em.departmentId
                LEFT JOIN
            positions p ON p.positionId = em.positionId 
                LEFT JOIN
            areas ar ON ar.areaId = em.areaId 
            where  em.badge = :badge '. $showEmWhere . '');
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

    public function getEmployeesByStatus($status,$idBillTo)
    {
        $where = '';
        $statusWhere = '';
        $showEmWhere = getPLEmployeeTable(true);

        if (getPLShowInactiveEmployee()) { // Puede ver inactivo?
            if ($status == 0) {
                $statusWhere = " em.status = 0 ";
            } else if ($status >= 2) {
                $statusWhere = '';
            } else {
                $statusWhere = " em.status = 1 ";
            }
        } else {
            $statusWhere = " em.status = 1 ";
        }

        // union
        if (!empty($showEmWhere)) {
            if (!empty($statusWhere))  $where = $showEmWhere . " and " . $statusWhere;
            else $where = $showEmWhere;
        } else {
            if (!empty($statusWhere)) $where = " where " . $statusWhere;
        }
        $fields = '';

        if (getPLFullEmployeeInfo()) {
            // All fields bd
            $fields = "SELECT 
                    em.badge as BADGE,
                    concat_ws(' ',em.firstName,em.secondName,em.thirdName,em.firstLastName,em.secondLastName,em.thirdLastName) as NOMBRE,
                    em.firstName as 'PRIMER NOMBRE',
                    em.secondName as 'SEGUNDO NOMBRE',
                    em.thirdName as 'TERCER NOMBRE',
                    em.firstLastName as 'PRIMER APELLIDO',
                    em.secondLastName as 'SEGUNDO APELLIDO',
                    em.thirdLastName as 'APELLIDO DE CASADA',
                    CASE
                        WHEN em.genderId = 0 THEN 'M'
                        WHEN em.genderId = 1 THEN 'F'
                        WHEN em.genderId = 2 THEN 'Other'
                        ELSE 'Unknown'
                    END AS 'SEXO',
                    IF (em.status=1, 'Activo','Inactivo') as 'STATUS',
                    em.hiredDate as 'FECHA DE INGRESO SURGEPAYS',
                    em.hiredDateOld as 'FECHA DE CONTRATACION',
                    p.positionName as 'CARGO',
                    de.name AS 'DEPARTAMENTO',
                    ar.areaName as 'AREA',
                    bi.billName as 'BILL TO',
                    em.dob as 'FECHA DE NACIMIENTO',
                    em.contractType as 'TIPO DE CONTRATO',
                    IF (em.bonus=1, 'Yes','No') as 'BONO',
                    em.workHours as 'HORAS CONTRATADAS',
                    em.shift as 'TURNO',
                    em.endDate as 'FECHA DE BAJA',
                    em.reasonTermination as 'RAZON DE BAJA',
                    TIMESTAMPDIFF(YEAR, em.dob, CURDATE()) AS EDAD,
                    dt.name AS 'TIPO DE DOCUMENTO',
                    em.documentNumber as 'NUMERO DE DOCUMENTO',
                    em.nationality as 'NACIONALIDAD',
                    em.documentExpedPlace AS 'LUGAR DE EXPEDICION DUI',
                    em.documentExpedDate AS 'FECHA DE EXPEDICION DUI',
                    em.documentExpDate AS 'FECHA DE EXPIRACION DUI',
                    em.birthDeparment AS 'DEPARTAMENTO DE NACIMIENTO',
                    em.address AS 'DOMICILIO DUI',
                    concat_ws(', ', s.stateName, c.cityName, d.districtName) AS 'RESIDENCIA DUI',
                    em.career AS 'PROFESION',
                    em.maritalStatus AS 'ESTADO CIVIL',
                    IF(em.documentTypeId = 1, em.documentNumber, '') AS 'NIT',
                    af.name AS 'AFP',
                    em.afpNumber AS 'NUP',
                    em.ssn AS 'ISSS',
                    em.spouseName AS 'NOMBRE CONYUGUE',
                    em.homePhone AS 'TELEFONO DE CASA',
                    em.contactPhone AS 'TELEFONO CELULAR',
                    em.personalEmail as 'EMAIL',";
            if (getPLSalary())  $fields .= "em.salary AS 'SALARIO',";
            $fields .= "em.bankAccount  AS 'CUENTA DEL BANCO'
                    FROM
                    employees em
                        LEFT JOIN
                    states s ON s.stateId = em.stateId
                        LEFT JOIN
                    cities c ON c.cityId = em.cityId
                        LEFT JOIN
                    departments de ON de.departmentId = em.departmentId
                        LEFT JOIN
                    districts d ON d.districtId = em.districtId
                        LEFT JOIN
                    users u ON u.userId = em.superiorId
                        LEFT JOIN
                    positions p ON p.positionId = em.positionId 
                        LEFT JOIN
                    areas ar ON ar.areaId = em.areaId 
                        LEFT JOIN
                    bills bi ON bi.billToId = em.billTo 
                        LEFT JOIN
                    documents_type dt ON dt.documentTypeId = em.documentTypeId 
                        LEFT JOIN
                    afp af ON af.afpId = em.afpTypeId ";
        } else {
            $fields = "SELECT
            em.employeeId as employeeId,
            em.badge as badge,
            concat_ws(' ',em.firstName,em.secondName,em.thirdName,em.firstLastName,em.secondLastName,em.thirdLastName) as fullname,
            em.contactPhone AS contactPhone,
            em.homePhone AS homePhone,
            IF (em.status=1, 'Activo','Inactivo') as status,
            de.name AS departamentName,
            ar.areaName as areaName,
            p.positionName as positionName,
            em.corporateEmail,
            em.hiredDate as hiredDate,
            em.hiredDateOld as hiredDateOld,
            em.contractType as contractType,
            em.workHours as workHours,
            IF (em.bonus=1, 'Yes','No') as bonus
            FROM
            employees em
                LEFT JOIN
            departments de ON de.departmentId = em.departmentId
                LEFT JOIN
            positions p ON p.positionId = em.positionId 
                LEFT JOIN
            areas ar ON ar.areaId = em.areaId ";
        }

        $where .= (!empty($where)) ? ' and em.billTo= '.$idBillTo : ' where em.billTo='.$idBillTo; 
        

        $query = $fields . $where;

        $this->db->query($query);
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getNameAndBadgeByIdEmp($employeeId)
    {
        $this->db->query('SELECT badge,firstName,firstLastName FROM hr_surgepays.employees where employeeId=:employeeId;');
        $this->db->bind('employeeId', $employeeId);
        $re = $this->db->resultSetFetch();
        return $re;
    }

    public function BirthdaysOfTheMonth()
    {
        $this->db->query("SELECT 
            employeeId,
            DATE_FORMAT(dob, '%M %e') AS formDOB ,
            dob,
            badge,
            photo,
            firstName,
            firstLastName
        FROM
            hr_surgepays.employees
        WHERE
            status=1 and billTo=1 and MONTH(dob) = MONTH(CURDATE()) order by DAY(dob) asc;");
        $re = $this->db->resultSetAssoc();
        return $re;
    }

    public function getSalarioEmployee($employeeId){
        $this->db->query('SELECT salary FROM hr_surgepays.employees where employeeId=:employeeId;');
        $this->db->bind('employeeId', $employeeId);
        $re = $this->db->resultSetFetch();
        return $re['salary'];
    }
}

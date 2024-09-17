<?php
class EmployeeSchedule
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getSchedulesEmployee($employeeId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employee_schedules where employeeId=:employeeId and status=1 order by createdAt desc;');
        $this->db->bind(':employeeId', $employeeId);
        $result = $this->db->resultSetFetch();

        return $result;
    }

    public function saveEmployeeSchedule($data)
    {
        $this->db->insertQuery('hr_surgepays.employee_schedules', $data);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }
    public function getEmployeeWorkingToday($dayToday)
    {
        $this->db->query("SELECT 
                            em.employeeId, 
                            em.badge, 
                            em.firstName,
                            concat_ws(' ', firstName, secondName,thirdName,firstLastName,secondLastName ) as 'fullName',
                            em.firstLastName, 
                            es.$dayToday, 
                            es.createdAt,
                            de.name as 'deparmentName',
                            po.positionName
                        FROM 
                            hr_surgepays.employee_schedules es
                        INNER JOIN employees em ON em.employeeId = es.employeeId
                        INNER JOIN departments de ON em.departmentId = de.departmentId
                         INNER JOIN positions po ON em.positionId = po.positionId
                        WHERE 
                            es.status = 1 
                            AND es.$dayToday != '-OFF-' 
                            AND es.createdAt = (
                                SELECT MAX(es2.createdAt)
                                FROM hr_surgepays.employee_schedules es2
                                WHERE es2.employeeId = es.employeeId 
                                AND es2.status = 1 
                                AND es2.$dayToday != '-OFF-'
                            );");
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

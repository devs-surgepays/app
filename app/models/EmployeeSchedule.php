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

    public function getLastEmployeeSchedule($employeeId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employee_schedules where employeeId=:employeeId and status=1 order by createdAt desc LIMIT 1;');
        $this->db->bind(':employeeId', $employeeId);
        $result = $this->db->single();

        return $result;
    }

    public function getEmployeeSchedulebyId($scheduleId)
    {
        $this->db->query('SELECT * FROM hr_surgepays.employee_schedules where scheduleId=:scheduleId;');
        $this->db->bind(':scheduleId', $scheduleId);
        $result = $this->db->single();

        return $result;
    }

    public function updateOldSchedules($currentScheduleId,$employeId)
    {
        $this->db->query('UPDATE hr_surgepays.employee_schedules SET status=0 where scheduleId !=:scheduleId and employeeId=:employeId;');
        $this->db->bind(':scheduleId',$currentScheduleId);
        $this->db->bind(':employeId', $employeId);
        $this->db->execute();
        //$result = $this->db->single();

        //return $result;
    }

    public function saveEmployeeSchedule($data)
    {
        $this->db->insertQuery('hr_surgepays.employee_schedules', $data);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }

    public function editEmployeeSchedule($data)
    {
        $this->db->updateQuery('hr_surgepays.employee_schedules', $data,"scheduleId=:scheduleId");
        //$lastInsertId = $this->db->lastinsertedId();
        //return $lastInsertId;
    }

    public function getEmployeeWorkingToday($dayToday)
    {
        $showEmWhere = getPLEmployeeTable(false);
        
        $this->db->query("SELECT 
                            em.employeeId, 
                            em.badge, 
                            em.firstName,
                            concat_ws(' ', firstName, secondName,thirdName,firstLastName,secondLastName ) as 'fullName',
                            em.firstLastName, 
                            es.$dayToday, 
                            es.createdAt,
                            de.name as 'deparmentName',
                            ar.areaName as 'areaName',
                            po.positionName
                        FROM 
                            hr_surgepays.employee_schedules es
                        INNER JOIN employees em ON em.employeeId = es.employeeId
                        INNER JOIN departments de ON em.departmentId = de.departmentId
                        INNER JOIN positions po ON em.positionId = po.positionId
                        INNER JOIN areas ar ON ar.areaId = em.areaId
                        WHERE 
                            es.status = 1 
                            AND es.$dayToday != '-OFF-' 
                            AND es.createdAt = (
                                SELECT MAX(es2.createdAt)
                                FROM hr_surgepays.employee_schedules es2
                                WHERE es2.employeeId = es.employeeId 
                                AND es2.status = 1 
                                AND es2.$dayToday != '-OFF-') $showEmWhere ;");
        $result = $this->db->resultSetAssoc();
        return $result;
   
   }
}

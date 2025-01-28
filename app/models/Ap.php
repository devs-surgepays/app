<?php

class Ap {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllApTypes(){
        $this->db->query("SELECT * FROM hr_surgepays.ap_types;");
        $row = $this->db->resultSetAssoc();
        return $row;
    }

    public function getSingleLeave($leaveId){
        //$this->db->query("SELECT * FROM hr_surgepays.ap_details WHERE apDetailsId=:leaveId;");
        $this->db->query("SELECT ap.*,
(select if (ap.aprovedByM>0, CONCAT(COALESCE(eu.firstName, ''), ' ', COALESCE(eu.firstLastName, '')),NULL ) as 'fullname' 
from users as us left JOIN employees eu ON us.employeeId = eu.employeeId where us.userId = ap.byMUser) as 'M',
(select if (ap.aprovedByHR>0, CONCAT(COALESCE(eu.firstName, ''), ' ', COALESCE(eu.firstLastName, '')),NULL ) as 'fullname' 
from users as us left JOIN employees eu ON us.employeeId = eu.employeeId where us.userId = ap.byHRUser) as 'HR',
(select if (ap.aprovedByWf>0, CONCAT(COALESCE(eu.firstName, ''), ' ', COALESCE(eu.firstLastName, '')),NULL ) as 'fullname' 
from users as us left JOIN employees eu ON us.employeeId = eu.employeeId where us.userId = ap.byWfUSer) as 'WF',
(select if (ap.aprovedBySup>0, CONCAT(COALESCE(eu.firstName, ''), ' ', COALESCE(eu.firstLastName, '')),NULL ) as 'fullname' 
from users as us left JOIN employees eu ON us.employeeId = eu.employeeId where us.userId = ap.bySupUser) as 'SS'
FROM hr_surgepays.ap_details ap WHERE apDetailsId=:leaveId");
        $this->db->bind(":leaveId",$leaveId);
		$row = $this->db->single();
		return $row;
    }

    public function insertLeave($data){
        $response = $this->db->insertQuery("hr_surgepays.ap_details",$data);
        return $response;
        }

    public function updateLeave($data){
        $response = $this->db->updateQuery("hr_surgepays.ap_details",$data,"apDetailsId=:apDetailsId");
        return $response;
    }

    public function searchEmployeeByBadge($badge){
        $showEmWhere = getPLEmployeeTable(false);
        $this->db->query("SELECT em.employeeId,CONCAT(COALESCE(em.firstName, ''), ' ', COALESCE(em.secondName, ''), ' ', COALESCE(em.firstLastName, ''), ' ', COALESCE(em.secondLastName, '')) AS fullname,p.positionName,d.name as departmentName,p.positionId,d.departmentId 
        FROM hr_surgepays.employees em
            JOIN hr_surgepays.positions p ON p.positionId = em.positionId
            JOIN hr_surgepays.departments d ON d.departmentId = em.departmentId
            WHERE em.badge =:badge $showEmWhere");
        $this->db->bind(":badge",$badge);
        $row = $this->db->single();
        //print_r($row);
        if($row){
            $row['msg']="success";
        }else{
            $row['msg']="error";
        }
        return $row;
    }

    public function getEmployeeName($userId){
        $this->db->query("SELECT u.username,CONCAT(COALESCE(em.firstName, ''), ' ', COALESCE(em.firstLastName, '')) AS fullname
        FROM hr_surgepays.users u 
        JOIN hr_surgepays.employees em ON u.employeeId = em.employeeId
        WHERE u.userId =:userId ");
        $this->db->bind(":userId",$userId);
        $row = $this->db->single();
        //print_r($row);
        if($row){
            $row['msg']="success";
        }else{
            $row= ['msg' => "error"];
        }
        return $row;
    }
	
	public function getAttritions($reasonType){
		$this->db->query("SELECT * FROM hr_surgepays.attrition_reasons where reasonType = :reasonType");
		$this->db->bind(":reasonType",$reasonType);
		$row = $this->db->resultSetAssoc();
		return $row;
	}

    public function getAttritionsResons($idReason){
		$this->db->query("SELECT * FROM hr_surgepays.attrition_reasons where attritionReasonId =:idReason");
		$this->db->bind(":idReason",$idReason);
		$row = $this->db->single();
		return $row;
	}

    public function getAttritionsResonsDetails($idReason){
		$this->db->query("SELECT * FROM hr_surgepays.attrition_reasons_details where attritionReasonDetailId =:idReason");
		$this->db->bind(":idReason",$idReason);
		$row = $this->db->single();
		return $row;
	}
	
	public function getAttritionsDetails($idReason){
		$this->db->query("SELECT * FROM hr_surgepays.attrition_reasons_details where attritionReasonId =:idReason");
		$this->db->bind(":idReason",$idReason);
		$row = $this->db->resultSetAssoc();
		return $row;
	}

    public function getAllReasons($id){
        $this->db->query("SELECT * FROM hr_surgepays.reasons where type=:id;");
        $this->db->bind(":id",$id);
		$row = $this->db->resultSetAssoc();
		return $row;
    }

    public function getDepartments(){
        $this->db->query("SELECT * FROM hr_surgepays.departments;");
		$row = $this->db->resultSetAssoc();
		return $row;
    }

    public function getPositions(){
        $this->db->query("SELECT * FROM hr_surgepays.positions;");
		$row = $this->db->resultSetAssoc();
		return $row;
    }

    public function countRegisters($search){
        $showEmWhere = getPLEmployeeTable(false);
        if ($search!="") {
            $this->db->query("SELECT count(*) as total 
                                FROM hr_surgepays.ap_details a 
                                JOIN hr_surgepays.employees em ON em.badge=a.badge 
                                JOIN hr_surgepays.users u ON u.userId=a.createdBy 
                                JOIN hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId WHERE $search $showEmWhere order by a.apDetailsId asc");
        }else{
            $showEmWhere = getPLEmployeeTable(true);
            $this->db->query("SELECT count(*) as total
                                FROM hr_surgepays.ap_details a
                                JOIN hr_surgepays.employees em ON em.badge=a.badge
                                JOIN hr_surgepays.users u ON u.userId=a.createdBy
                                JOIN hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId $showEmWhere order by a.apDetailsId  asc");
        }




        $this->db->execute();
        $count = $this->db->single();
        return $count['total'];
    }

    public function getData($offset,$per_page,$search,$orderby){
        $showEmWhere = getPLEmployeeTable(false);
        $getApSAA = (getPLSAA()==false)?" AND a.apTypeId not in (11,12)":"";
		$date_now = date('Y-m-d').'%';
		//echo "select firstname,lastname,email_address,email_status,CAST(email_open_datetime AS DATE) as date_opened,delivered,received,unsubscribe from mailCampaigns.contacts  ORDER BY $orderby limit $offset,$per_page;";
		//echo "SELECT a.apDetailsId,concat(em.firstName,' ',em.firstLastName) as fullName,a.badge,date(a.createdAt) as createdAt,u.username,t.name,a.status FROM hr_surgepays.ap_details a JOIN hr_surgepays.employees em ON em.badge=a.badge JOIN hr_surgepays.users u ON u.userId=a.createdBy JOIN hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId WHERE ".$search." ".$showEmWhere."   ORDER BY ".$orderby;

				if ($search!="") {
					$this->db->query("SELECT 
    a.apDetailsId,
    CONCAT(em.firstName, ' ', em.firstLastName) AS fullName,
    a.badge,
    DATE(a.createdAt) AS createdAt,
    u.username,
    t.name,
    a.aprovedByM,
    a.aprovedByHR,
    a.aprovedByWf,
    a.aprovedBySup,
    a.printed
FROM
    hr_surgepays.ap_details a
        JOIN
    hr_surgepays.employees em ON em.badge = a.badge
        JOIN
    hr_surgepays.users u ON u.userId = a.createdBy
        JOIN
    hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId WHERE $search $showEmWhere $getApSAA ORDER BY $orderby  limit $offset,$per_page;");
					
				}else{
                    $showEmWhere = getPLEmployeeTable(true);
					$this->db->query("SELECT 
    a.apDetailsId,
    CONCAT(em.firstName, ' ', em.firstLastName) AS fullName,
    a.badge,
    DATE(a.createdAt) AS createdAt,
    u.username,
    t.name,
    a.aprovedByM,
    a.aprovedByHR,
    a.aprovedByWf,
    a.aprovedBySup,
    a.printed
FROM
    hr_surgepays.ap_details a
        JOIN
    hr_surgepays.employees em ON em.badge = a.badge
        JOIN
    hr_surgepays.users u ON u.userId = a.createdBy
        JOIN
    hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId $showEmWhere $getApSAA  ORDER BY $orderby limit $offset,$per_page;");
					
				}				
			
		$this->db->execute('Read');
	$getOrders = $this->db->resultSet();
	return $getOrders;
	}

    public function getLeavesByemployee($badge){
        $this->db->query("SELECT ap.apDetailsId,ap.createdAt, apt.name FROM hr_surgepays.ap_details  as ap
        inner join ap_types as apt on apt.apTypeId = ap.apTypeId
        where ap.apTypeId in (1,2,5) and ap.badge=:badge order by ap.createdAt desc");
         $this->db->bind(":badge",$badge);
        $row = $this->db->resultSetAssoc();
		return $row;
    }
}
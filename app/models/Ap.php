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
        $this->db->query("SELECT * FROM hr_surgepays.ap_details WHERE apDetailsId=:leaveId;");
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
        $this->db->query("SELECT e.employeeId,CONCAT(COALESCE(e.firstName, ''), ' ', COALESCE(e.secondName, ''), ' ', COALESCE(e.firstLastName, ''), ' ', COALESCE(e.secondLastName, '')) AS fullname,p.positionName,d.name as departmentName,p.positionId,d.departmentId FROM hr_surgepays.employees e
            JOIN hr_surgepays.positions p ON p.positionId = e.positionId
            JOIN hr_surgepays.departments d ON d.departmentId = e.departmentId
            WHERE e.badge =:badge");
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

        if ($search!="") {
            $this->db->query("SELECT count(*) as total 
                                FROM hr_surgepays.ap_details a 
                                JOIN hr_surgepays.employees e ON e.badge=a.badge 
                                JOIN hr_surgepays.users u ON u.userId=a.createdBy 
                                JOIN hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId WHERE $search order by a.apDetailsId asc");
        }else{
            $this->db->query("SELECT count(*) as total
                                FROM hr_surgepays.ap_details a
                                JOIN hr_surgepays.employees e ON e.badge=a.badge
                                JOIN hr_surgepays.users u ON u.userId=a.createdBy
                                JOIN hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId order by a.apDetailsId  asc");
        }




        $this->db->execute();
        $count = $this->db->single();
        return $count['total'];
    }

    public function getData($offset,$per_page,$search,$orderby){
		$date_now = date('Y-m-d').'%';
		//echo "select firstname,lastname,email_address,email_status,CAST(email_open_datetime AS DATE) as date_opened,delivered,received,unsubscribe from mailCampaigns.contacts  ORDER BY $orderby limit $offset,$per_page;";
		//echo "SELECT a.apDetailsId,concat(e.firstName,' ',e.firstLastName) as fullName,a.badge,date(a.createdAt) as createdAt,u.username,t.name,a.status FROM hr_surgepays.ap_details a JOIN hr_surgepays.employees e ON e.badge=a.badge JOIN hr_surgepays.users u ON u.userId=a.createdBy JOIN hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId WHERE ".$search."   ORDER BY ".$orderby;

				if ($search!="") {
					$this->db->query("SELECT 
    a.apDetailsId,
    CONCAT(e.firstName, ' ', e.firstLastName) AS fullName,
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
    hr_surgepays.employees e ON e.badge = a.badge
        JOIN
    hr_surgepays.users u ON u.userId = a.createdBy
        JOIN
    hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId WHERE $search   ORDER BY $orderby  limit $offset,$per_page;");
					
				}else{
					$this->db->query("SELECT 
    a.apDetailsId,
    CONCAT(e.firstName, ' ', e.firstLastName) AS fullName,
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
    hr_surgepays.employees e ON e.badge = a.badge
        JOIN
    hr_surgepays.users u ON u.userId = a.createdBy
        JOIN
    hr_surgepays.ap_types t ON t.apTypeId = a.apTypeId ORDER BY $orderby limit $offset,$per_page;");
					
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
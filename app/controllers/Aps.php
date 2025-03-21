<?php
   error_reporting(E_ALL);
   ini_set("display_errors", 1);
class Aps extends Controller
{
    public $apModel;
    public $employeeScheduleModel;
    public $employeeModel;
    public $departmentModel;
    public $positionModel;

    public function __construct()
    {
		if(!isLoggedIn()){
            redirect('auth/login');
        }
        $this->apModel = $this->model('Ap');
        $this->employeeScheduleModel = $this->model('EmployeeSchedule');
        $this->employeeModel = $this->model('Employee');
        $this->departmentModel = $this->model('Department');
        $this->positionModel = $this->model('Position');
    }

    public function index(){
       
        $data['apTypes'] = $this->apModel->getAllApTypes();
        $this->view('ap/index', $data);
    }

    public function getLeave($leaveId){
        $data=$this->apModel->getSingleLeave($leaveId);

        echo json_encode($data);
    }

    public function getSingleLeave($leaveId){
        $data=$this->apModel->getSingleLeave($leaveId);

        return $data;
    }
	
	public function saveAP(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
             //print_r($_POST);
             //exit();
            $action=$_POST['Action'];
            $comments = (isset($_POST['addComments']))?trim($_POST['addComments']):"";
            $data=[
                "apTypeId" => $_POST['addLeaveType'],
                "badge" => $_POST['addbadge'],
                //"employeeId" => $_POST['addEmployeeId'],
                "createdBy" => $_SESSION['userId'],
                "comment"=>$comments
            ];

            switch($data['apTypeId']){
                case 1:
                    $data['reason1']=$_POST["motivo_permiso"];
                    $data['reason2']=$_POST['tiempopermiso'];
                    $data['apDate1']=$_POST["dia1"];
                    $data['reason3']=$_POST["documentosJustificativos"];
                    if($data['reason2']=="Horas"){
                        $data['startTime']=$_POST['hora_inicio'];
                        $data['endTime']=$_POST['hora_final'];
                        
                    }else{
                        $data['apDate2']=$_POST['dia2'];
                    }
                    break;
                case 2:
                    $data['reason1']=$_POST["motivo_permiso"];
                    $data['reason2']=$_POST['tiempopermiso'];
                    $data['apDate1']=$_POST["dia1"];
                    $data['reason3']=$_POST["documentosJustificativos"];
                    if($data['reason2']=="Horas"){
                        $data['startTime']=$_POST['hora_inicio'];
                        $data['endTime']=$_POST['hora_final'];
                    }else{
                        $data['apDate2']=$_POST['dia2'];
                    }
                    
                    break;
                case 3:
                    $data['reason1']="Vacación";
                    $data['apDate1']=$_POST["inicioVacaciones"];
                    $data['apDate2']=$_POST["finVacaciones"];
                    $data['apDate3']=$_POST["fechaPago"];
                    break;
                case 4:
                    $data['currentAccount']=$_POST['currentDepartment'];
                    $data['currentPosition']=$_POST['currentPosition'];
                    $data['newAccount']=$_POST['newDepartment'];
                    $data['newPosition']=$_POST['newPosition'];
                    $data['apDate1']=$_POST['inicioPrueba'];
                    $data['apDate2']=$_POST['finPrueba'];
                    
                    break;
                case 5:
                    $data['apDate1']=$_POST['inicioIncapacidad'];
                    $data['apDate2']=$_POST['finIncapacidad'];
                    $data['reason1']=$_POST['tipoIncapacidad'];
                    if(isset($_POST['prorroga'])){
                        $data['reason2']=($_POST['prorroga']=="Yes")?"Prorroga":"";
                    }
                    break;
                case 6:
                    $data['apDate1'] = date("Y-m-d");
                    $data['reason1']=$_POST['tipoSancion'];
                    if(isset($_POST['septimo'])){
                        $data['reason2']=($_POST['septimo']=="Yes")?"Septimo":"";
                    }

                    if(isset($_POST['fechaAmonestacion'])){
                        $data['apDate3']=$_POST['fechaAmonestacion'];
                    }

                    if(isset($_POST['inicioSuspension'])){
                        $data['apDate1']=$_POST['inicioSuspension'];
                    } 
                    if(isset($_POST['finSuspension'])){
                        $data['apDate2']=$_POST['finSuspension'];
                    }
                    break;
                case 7:
                    $daysOff="";

                    $data['apDate1']=$_POST['inicioHorario'];
                    $data['apDate2']=$_POST['finHorario'];
                    $data['reason1']=$_POST['motivo_horario'];
                    if(isset($_POST['mondayOff'])){
                        $schedule['monday']="-OFF-";
                        $schedule['mondayLunch']="-OFF-";
                        $days="-";
                        $daysOff="MON & ";
                    }else{
                        $schedule['monday']=$_POST['mondayIn']." - ".$_POST['mondayOut'];
                        $schedule['mondayLunch']=$_POST['mondayLunch'];
                        $days="M";
                    }
                    if(isset($_POST['tuesdayOff'])){
                        $schedule['tuesday']="-OFF-";
                        $schedule['tuesdayLunch']="-OFF-";
                        $days.="-";
                        if(strlen($daysOff)>0){
                            $daysOff.="TUE";
                        }else{
                            $daysOff="TUE & ";
                        }
                    }else{
                        $schedule['tuesday']=$_POST['tuesdayIn']." - ".$_POST['tuesdayOut'];
                        $schedule['tuesdayLunch']=$_POST['tuesdayLunch'];
                        $days.="T";
                    }
                    if(isset($_POST['wednesdayOff'])){
                        $schedule['wednesday']="-OFF-";
                        $schedule['wednesdayLunch']="-OFF-";
                        $days.="-";
                        if(strlen($daysOff)>0){
                            $daysOff.="WED";
                        }else{
                            $daysOff="WED & ";
                        }
                    }else{
                        $schedule['wednesday']=$_POST['wednesdayIn']." - ".$_POST['wednesdayOut'];
                        $schedule['wednesdayLunch']=$_POST['wednesdayLunch'];
                        $days.="W";
                    }
                    if(isset($_POST['thursdayOff'])){
                        $schedule['thursday']="-OFF-";
                        $schedule['thursdayLunch']="-OFF-";
                        $days.="-";
                        if(strlen($daysOff)>0){
                            $daysOff.="THU";
                        }else{
                            $daysOff="THU & ";
                        }
                    }else{
                        $schedule['thursday']=$_POST['thursdayIn']." - ".$_POST['thursdayOut'];
                        $schedule['thursdayLunch']=$_POST['thursdayLunch'];
                        $days.="R";
                    }
                    if(isset($_POST['fridayOff'])){
                        $schedule['friday']="-OFF-";
                        $schedule['fridayLunch']="-OFF-";
                        $days.="-";
                        if(strlen($daysOff)>0){
                            $daysOff.="FRI";
                        }else{
                            $daysOff="FRI & ";
                        }
                    }else{
                        $schedule['friday']=$_POST['fridayIn']." - ".$_POST['fridayOut'];
                        $schedule['fridayLunch']=$_POST['fridayLunch'];
                        $days.="F";
                    }
                    if(isset($_POST['saturdayOff'])){
                        $schedule['saturday']="-OFF-";
                        $schedule['saturdayLunch']="-OFF-";
                        $days.="-";
                        if(strlen($daysOff)>0){
                            $daysOff.="SAT";
                        }else{
                            $daysOff="SAT & ";
                        }
                    }else{
                        $schedule['saturday']=$_POST['saturdayIn']." - ".$_POST['saturdayOut'];
                        $schedule['saturdayLunch']=$_POST['saturdayLunch'];
                        $days.="Y";
                    }
                    if(isset($_POST['sundayOff'])){
                        $schedule['sunday']="-OFF-";
                        $schedule['sundayLunch']="-OFF-";
                        $days.="-";
                        if(strlen($daysOff)>0){
                            $daysOff.="SUN";
                        }else{
                            $daysOff="SUN & ";
                        }
                    }else{
                        $schedule['sunday']=$_POST['sundayIn']." - ".$_POST['sundayOut'];
                        $schedule['sundayLunch']=$_POST['sundayLunch'];
                        $days.="S";
                    }
                    //$data['reasonId']=$_POST['scheduleId']
                    $schedule['days']=$days;
                    $schedule['daysOff']=$daysOff;
                    $schedule['status']=0;
                    $schedule['employeeId']=$_POST['addEmployeeId'];
                    if($action=="Insert"){
                        $data['scheduleId']=$this->employeeScheduleModel->saveEmployeeSchedule($schedule);
                    }else if($action=="Update"){
                        $schedule['scheduleId']=$_POST['scheduleId'];
                        $this->employeeScheduleModel->editEmployeeSchedule($schedule);
                    }
                    
                    break;
                case 8:
                    $data['apDate1']=$_POST['fechaSolicitud'];
                    $data['apDate2']=$_POST['diaAsignado'];
                    $data['apDate3']=$_POST['diaSolicitado'];
                    $data['reason1']=$_POST['motivo_cambio'];
                    break;
                case 9:
                    $data['apDate1']=$_POST['inicioAusencia'];
                    $data['apDate2']=$_POST['finAusencia'];
                    break;
                case 10:
                    $data['apDate1']=$_POST['fechaOt'];
                    $data['startTime']=$_POST['inicioOt'];
                    $data['endTime']=$_POST['finOt'];
                    break;
                case 11:
                    $data['withdrawalType']=$_POST['tipoRetiro'];
                    $data['attritionsId1']=$_POST['attritions'];
                    $attrition = $this->apModel->getAttritionsResons($data['attritionsId1']);
                    $data['reason1']=$attrition['name'];
                    
                    if(isset($_POST['reasonsDetails'])){
                        $data['attritionsId2']=$_POST['reasonsDetails'];
                        $reasonsDetails = $this->apModel->getAttritionsResonsDetails($data['attritionsId2']);
                        $data['reason2']=$reasonsDetails['name'];
                        
                    }
                    $data['apDate1']=$_POST['fechaRetiro'];
                    break;
                case 12:
                    $data['newSalary']=$_POST['monto'];
                    $data['reason1']="Ajuste Salarial";
                    $data['apDate1']=$_POST['diaEfectivo'];
                    $data['currentPosition']=$_POST['currentPosition'];
                    $data['currentSalary']=$_POST['currentSalary'];

                    $data['currentAccount']=$_POST['currentDepartment'];
                    $data['newAccount']=$_POST['currentDepartment'];
                    
                    if(!empty($_POST['newPosition2'])){
                        
                        $data['newPosition']=$_POST['newPosition2'];
                    }

                    break;               


            }
            if($action=="Insert"){
                $this->apModel->insertLeave($data);
            }else if($action=="Update"){
                $data['apDetailsId']=$_POST['apId'];
                $this->apModel->updateLeave($data);
            }
            
            $data['status']="success";
            $data['message']="your leave has been saved succesfully";
            //print_r($data);
            //print_r($schedule);
            echo json_encode($data);
        }else{
            // Forbidden Access
            http_response_code(403);
            echo "Access forbidden";
        }
	}
	
	public function updateAP(){
		
	}

    public function getReasons($idType){
        $row = $this->apModel->getAllReasons($idType);
        echo json_encode($row);
    }

    public function getDepartments(){
        $row = $this->apModel->getDepartments();
        echo json_encode($row);
    }

    public function getPositions(){
        $row = $this->apModel->getPositions();
        echo json_encode($row);
    }

    public function getEmpName($userId){
        $row = $this->apModel->getEmployeeName($userId);
        echo json_encode($row);
    }

    public function approveAP(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data=[
                "apDetailsId"=>$_POST['id'],
                "status"=>$_POST['status']
            ];
            //Getting permission level
            $permissionLevel = $_SESSION['permissionLevelId'];
            if($permissionLevel&640){
                //128+512
                $data['aprovedByWf']=$data['status'];
                $data['byWfUSer']=$_SESSION['userId'];
            }else if($permissionLevel&16){
                //16
                $data['aprovedByHR']=$data['status'];
                $data['byHRUser']=$_SESSION['userId'];
            }else  if($permissionLevel&96){
                //32+64
                $data['aprovedByM']=$data['status'];
                $data['byMUser']=$_SESSION['userId'];
            }else if($permissionLevel&8){
                //8
                $data['aprovedBySup']=$data['status'];
                $data['bySupUser']=$_SESSION['userId'];
            } 
            //Updating Aproves into apDetails Table
            $this->apModel->updateLeave($data);
            //Getting apDetails
            $apInfo= $this->getSingleLeave($data['apDetailsId']);
            //Getting Employee Info by badge
            $employeeInfo = $this->employeeModel->getEmployeeByBadge($apInfo['badge']);
            //Updating employee Schedule for Schedule Change aprove
            //Verifing if ap Id equal schedule change newSalary
            switch($apInfo['apTypeId']){
                case 7:
                    if($data['status']==1){
                        $schedule['scheduleId']=$apInfo['scheduleId'];
                        $schedule['status']=1;
                        //Turn On last schedule
                        $this->employeeScheduleModel->editEmployeeSchedule($schedule);
                        //Turn Off old schedules
                        $this->employeeScheduleModel->updateOldSchedules($apInfo['scheduleId'],$employeeInfo['employeeId']);
                    }
                    break;
                case 12:
                    //if($data['byHRUser']){
                        if($data['status']==1){
                            $saveData['employeeId']=$employeeInfo['employeeId'];
                            $saveData['salary']=$apInfo['newSalary'];
                            $this->employeeModel->updatedEmployee($saveData);
                        }

                    //}
                    break;
                case 11:
                        //if($data['byHRUser']){
                        if($data['status']==1){
                            $saveData['employeeId']=$employeeInfo['employeeId'];
                            $saveData['status']=0;
                            $saveData['endDate']=$apInfo['apDate1'];
                                $this->employeeModel->updatedEmployee($saveData);
                        }
    
                        //}
                    break;
                    
            }
            // if($apInfo['apTypeId']==7){
            //     //Verifying if status is approve
            //     if($data['status']==1){
            //         $schedule['scheduleId']=$apInfo['scheduleId'];
            //         $schedule['status']=1;
            //         //Turn On last schedule
            //         $this->employeeScheduleModel->editEmployeeSchedule($schedule);
            //         //Turn Off old schedules
            //         $this->employeeScheduleModel->updateOldSchedules($apInfo['scheduleId'],$employeeInfo['employeeId']);
            //     }
            // }
            $data['response']="success";
            $data['message']="you gave approval to this leave";
            echo json_encode($data);
        }else{
            // Forbidden Access
            http_response_code(403);
            echo "Access forbidden";
        }
    }

    public function read(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
    //if($_POST){
        //die('Submit');
        $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $page = (isset($_POST['page']) && !empty($_POST['page']))?$_POST['page']:1;
        $data = [
            'action'=>trim($_POST['action']),
            'arrayCampos'=>$_POST['search'],
            'order_by'=>'a.apDetailsId desc',
            'length'=>$_POST['length'],
            'page'=>$page,
            'per_page'=>'',
            'adjacents'=>'',
            'offset'=>'',
            'offsetToShow'=>'',
            'numrows'=>'',
            'total_pages'=>'',
            'c'=>'',
            'pagination'=>'',
        ];
        //print_r($data);
        //die('Submit');
    }else{
        $data = [
            'action'=>'',
            'arrayCampos'=>'',
            'order_by'=>'a.apDetailsId desc',
            'length'=>10,
            'page'=>1,
            'per_page'=>'',
            'adjacents'=>'',
            'offset'=>'',
            'offsetToShow'=>'',
            'numrows'=>'',
            'total_pages'=>'',
            'c'=>'',
            'pagination'=>'',
            'fields'=>'',
        ];
            }
        
            $camposAscDesc=(isset($_POST['camposAscDesc']))?$_POST['camposAscDesc']:"";
    
        //print_r($data['arrayCampos']);
        $count=0;
        $addWhere="";
        $camposBase=array("fullName","em.badge","bydate","u.username","t.apTypeId","a.aprovedByM","a.aprovedByHR","a.aprovedByWf","a.aprovedBySup","a.printed");
        $fieldSearch=array("em.firstName", "em.secondName", "em.thirdName", "em.firstLastName", "em.secondLastName", "em.thirdLastName");
        $fields = array(
            0=>array("name"=>"fullname","type"=>"multifield","values"=>$fieldSearch),
            1=>array("name"=>"em.badge","type"=>"equal"),
            2=>array("name"=>"bydate","type"=>"range"),
            3=>array("name"=>"u.username","type"=>"like"),
            4=>array("name"=>"t.apTypeId","type"=>"equal"),
            5=>array("name"=>"a.aprovedByM","type"=>"equal"),
            6=>array("name"=>"a.aprovedByHR","type"=>"equal"),
            7=>array("name"=>"a.aprovedByWf","type"=>"equal"),
            8=>array("name"=>"a.aprovedBySup","type"=>"equal")
        );
        if($data['arrayCampos']){
            for($index=0;$index<sizeof($data['arrayCampos']);$index++){
                $count += (isset($data['arrayCampos'][$index]) && $data['arrayCampos'][$index]!=='')?1:0;
                //$count += (isset($arrayFields[5]) && $arrayFields[5] !== '')?1:0;
                
                    if(!empty($data['arrayCampos'][$index])){
                        if($fields[$index]['name']=="fullname"){//$index==0
                            if(strlen($data['arrayCampos'][$index])>0){
                                $addWhere .= $this->build_search_query($data['arrayCampos'][$index],$fields[$index]['values']);//$fieldSearch
                            }
                        }else if($fields[$index]['name']=="bydate"){
                            list($start,$end) = explode('-', $data['arrayCampos'][$index]);
                            $startDate=date("Y-m-d",strtotime(trim($start)));
                            $endDate=date("Y-m-d",strtotime(trim($end)));
                            if($count<=1){
                                $addWhere.="date(a.createdAt)>='".$startDate."' and date(a.createdAt)<='".$endDate."'";
                            }else{
                                $addWhere.=" AND (date(a.createdAt)>='".$startDate."' and date(a.createdAt)<='".$endDate."')";
                            }
                        }else if($fields[$index]['type']=="equal"){
                            if($count>1){
                                $addWhere.=" and ".$camposBase[$index]." = ".$data['arrayCampos'][$index];
                            }else{
                                $addWhere.=" ".$camposBase[$index]." = ".$data['arrayCampos'][$index];  
                            }
                        }else{
                            if($count>1){
                                $addWhere.=" and ".$camposBase[$index]." LIKE '%".$data['arrayCampos'][$index]."%'";
                            }else{
                                $addWhere.=" ".$camposBase[$index]." LIKE '%".$data['arrayCampos'][$index]."%'";    
                            }
                        }

                    }
                }

        }else{
            $addWhere="";
        }
        
        //$status  = $this->getOrderStatus();
        
        $consultaBusqueda = "";
        $contarCuantasBusquedas = 0;
    
        $per_page = $data['length']; //la cantidad de registros que desea mostrar
        $adjacents  = 2; //brecha entre páginas después de varios adyacentes
        $offset = ($data['page'] - 1) * $per_page;
        $offsetnumeroMostrar = ($data['page']-1) * $per_page + 1;
        $numrows = $this->apModel->countRegisters($addWhere);
        $total_pages = ceil($numrows/$per_page);
        $reload = 'index.php';
        $data['per_page']=$per_page;
        $data['adjacents']=$adjacents;
        $data['offset']=$offset;
        $data['offsetToShow'] = $offsetnumeroMostrar;
        $data['numrows']=$numrows;
        $data['total_pages']=$total_pages;
        $paginate = paginateRead($reload,$data['page'] , $total_pages, $adjacents, $data['arrayCampos'],$data['length'],$camposAscDesc);
        $data['pagination']=$paginate;
        //$per_page = 30; //la cantidad de registros que desea mostrar
        
        $getOrders = $this->apModel->getData($data['offset'],$data['per_page'],$addWhere,$data['order_by']);

        $data['fields']=($getOrders)?$getOrders:0;
        //print_r($data);
        echo json_encode($data);
        //return $getOrders;
        
        //$this->view('dashboard/index',$data);
    //header('Content-type: application/json; charset=utf-8');
        
    }

    public function paginate($reload, $page, $tpages, $adjacents,$ArrayCampos,$example_length,$camposAscDesc) {

		//$ArrayCampos="";
			$ArrayCampos = json_encode($ArrayCampos);
			$camposAscDesc = json_encode($camposAscDesc);
			//print("<pre>".print_r($ArrayCampos,true)."</pre>");
			//$camposAscDesc="";
		
			$prevlabel = "&lsaquo;";
			$nextlabel = "&rsaquo;";
			$out = '<ul class="pagination">';
			 
			// previous label
		
			if($page==1) {
				$out.= "<li class='page-item disabled'><span><a class='page-link'>$prevlabel</a></span></li>";
			} else if($page==2) {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>$prevlabel</a></li>";
			}else {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".($page-1).",$ArrayCampos,$example_length,$camposAscDesc)'>$prevlabel</a></li>";
		
			}
			
			// first label
			if($page>($adjacents+1)) {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>1</a></li>";
			}
			// interval
			if($page>($adjacents+2)) {
				$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
			}
		
			// pages
		
			$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
			$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
			for($i=$pmin; $i<=$pmax; $i++) {
				if($i==$page) {
					$out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
				}else if($i==1) {
					$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>$i</a></li>";
				}else {
					$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".$i.",$ArrayCampos,$example_length,$camposAscDesc)'>$i</a></li>";
				}
			}
		
			// interval
		
			if($page<($tpages-$adjacents-1)) {
				$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
			}
		
			// last
		
			if($page<($tpages-$adjacents)) {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load($tpages,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>$tpages</a></li>";
			}
		
			// next
		
			if($page<$tpages) {
				$out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='load(".($page+1).",$ArrayCampos,$example_length,$camposAscDesc)'>$nextlabel</a></span></li>";
			}else {
				$out.= "<li class='page-item disabled'><span><a class='page-link'>$nextlabel</a></span></li>";
			}
			
			$out.= "</ul>";
			return $out;
		}

        function build_search_query($search_terms, $fieldsArray)
        {
            $terms = explode(' ', $search_terms);
            $conditions = array();
            $term_conditions = [];

            foreach ($terms as $term) {

                for ($i = 0; $i < count($fieldsArray); $i++)
                    array_push($term_conditions, "" . $fieldsArray[$i] . " LIKE '%" . addslashes($term) . "%'"); // create the query for each field Ex. firstName LIKE '%test%'

                $conditions[] = "(" . implode(" OR ", $term_conditions) . ")";
            }

            return implode(" AND ", $conditions);
        }

        public function getApTypes(){
           $row = $this->apModel->getAllApTypes();
           print_r($row);
        }

        public function getEmployeeInfo($badge=null){
            if($badge){
                $row = $this->apModel->searchEmployeeByBadge($badge);
            }else{
                $row = ["msg"=>"error"];
            }
            
            //print_r($row);
            echo json_encode($row);
        }
	
		public function getAttritionReasons(){
			//print_r($_POST);
			//exit();
			if($_SERVER['REQUEST_METHOD']=='POST'){
        		$_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$step = $_POST['step'];

				if($step=="reasonType"){
					$reasonType = $_POST['reasonType'];
					$row = $this->apModel->getAttritions($reasonType);
					//print_r($row);

				}else if($step=="reasonsDetail"){
					$idReason = $_POST['id_reasonType'];
					$row = $this->apModel->getAttritionsDetails($idReason);
				}

				echo json_encode($row);
			}
		}

    public function getLastSchedule($employeeId){
        $row = $this->employeeScheduleModel->getLastEmployeeSchedule($employeeId);
        echo json_encode($row);
    }

    public function getEmployeeSchedule($id,$type){
        if($type=="Last"){
            $row = $this->employeeScheduleModel->getLastEmployeeSchedule($id);
        }else if($type=="Edit"){
            $row = $this->employeeScheduleModel->getEmployeeSchedulebyId($id);
        }
        echo json_encode($row);
    }

    public function downloadPDF() {

        $leaveId = $_POST["leaveId"];
        $leaveTypeName = $_POST["leaveType"];

        $leave = $this->getSingleLeave($leaveId);
        if(!$leave) {
            echo json_encode(0);
            exit();
        }

        $this->getDocumentByType($leave, $leaveTypeName);
       
    }

    protected function getDocumentByType($leave, $leaveTypeName) {

        $apTypeId = $leave["apTypeId"];

        if($apTypeId == 1 || $apTypeId == 2 || $apTypeId == 3 || $apTypeId == 5) {
            $this->solicitudLicenciaTemplate($leave, $leaveTypeName);
        } else if($apTypeId == 4 || $apTypeId == 11 || $apTypeId == 12) {
            $this->movimientosTemplate($leave, $leaveTypeName);
        } else if ($apTypeId == 6 || $apTypeId == 9) {
            $this->amonestacionesTemplate($leave, $leaveTypeName);
        } else {
            throw new Exception("Error Processing PDF", 1);
        }

    }

    private function solicitudLicenciaTemplate($leave, $leaveTypeName) {

        $employee = $this->employeeModel->getEmployeeReadByBadge($leave["badge"]);

        $datee = new DateTime($leave["createdAt"]);
        
        $pdf_data["url"] = URLROOT."/public/documents/APs/solicitudLicencias.pdf";

        $pdf_data["info"] = [
            [
                't' => ucwords(strtolower(html_entity_decode($employee["fullname"]))),
                'd' => ['x' => 190, 'y' => 630, 'size' => 10]// 'color' => [0, 0.53, 0.71]
            ],
            [
                't' => ucwords(strtolower(html_entity_decode($employee["positionName"]))),
                'd' => ['x' => 120, 'y' => 610, 'size' => 10]
            ],
            [
                't' => $leave["badge"],
                'd' => ['x' => 175, 'y' => 590, 'size' => 10]
            ],
            [
                't' => html_entity_decode($leaveTypeName),
                'd' => ['x' => 129, 'y' => 457, 'size' => 10]
            ]            
        ];

        $locale = 'es_SV';

        $date = DateTime::createFromFormat('d/m/Y', $datee->format('d/m/Y'));

        $formatter = new IntlDateFormatter(
            $locale,
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/El_Salvador',
            IntlDateFormatter::GREGORIAN
        );

        $pdf_data["info"][] = [
            't' => $formatter->format($date),
            'd' => ['x' => 355, 'y' => 647, 'size' => 10]
        ];

        $motivoComment = $leave['reason1'].' - '.$leave["comment"]; 


        if(strlen($motivoComment) > 0) {
            if(strlen($motivoComment) > 68) {
                $firstComment = substr($motivoComment, 0, 68);
                $secondComment = substr($motivoComment, 68);

                $pdf_data["info"][] = [
                    't' => html_entity_decode($firstComment),
                    'd' => ['x' => 215, 'y' => 350, 'size' => 10, 'lineHeight' => 14, 'maxWidth' => 450]
                ];
        
                $pdf_data["info"][] = [
                    't' => html_entity_decode($secondComment),
                    'd' => ['x' => 88, 'y' => 325, 'size' => 10, 'lineHeight' => 14, 'maxWidth' => 430]
                ];

            } else {
                $pdf_data["info"][] = [
                    't' => html_entity_decode($motivoComment),
                    'd' => ['x' => 215, 'y' => 350, 'size' => 10, 'lineHeight' => 14, 'maxWidth' => 315]
                ];
            }
        }

        if (!empty($leave["reason3"])) {
            $pdf_data["info"][] = [
                't' => $leave["reason3"],
                'd' => ['x' => 255, 'y' => 240, 'size' => 10, 'lineHeight' => 14, 'maxWidth' => 300]
            ];
        }

        if($leave["apTypeId"] == 2) {
            // con goce
            $pdf_data["info"][] = [
                't' => 'X',
                'd' => ['x' => 316, 'y' => 210, 'size' => 12]
            ];
        } else if($leave["apTypeId"] == 1) {
            $pdf_data["info"][] = [
                't' => 'X',
                'd' => ['x' => 126, 'y' => 210, 'size' => 12]
            ];
        }

        if($leave["reason2"] != "Horas") {

            $apDate1 = new DateTime($leave["apDate1"]);
            $apDate2 = new DateTime($leave["apDate2"]);

            if ($leave["apTypeId"]==3) { // Solicitud de Vacaciones

                $paymentDate = new DateTime($leave["apDate3"]);

                $pdf_data["info"][] = [
                    't' => "Fecha de pago: __________",
                    'd' => ['x' => 420, 'y' => 550, 'size' => 9]
                ];
    
                $pdf_data["info"][] = [
                    't' => $paymentDate->format('d/m/Y'),
                    'd' => ['x' => 484, 'y' => 550, 'size' => 10]
                ];
            }

            $totalDays = $this->getTotalDays($apDate1,$apDate2);

            $pdf_data["info"][] = [
                't' => $apDate1->format('d/m/Y'),
                'd' => ['x' => 165, 'y' => 550, 'size' => 10]
            ];

            $pdf_data["info"][] = [
                't' => '-',
                'd' => ['x' => 222, 'y' => 550, 'size' => 10]
            ];

            $pdf_data["info"][] = [
                't' => $apDate2->format('d/m/Y'),
                'd' => ['x' => 233, 'y' => 550, 'size' => 10]
            ];

            $pdf_data["info"][] = [
                't' => strval($totalDays),
                'd' => ['x' => 360, 'y' => 550, 'size' => 10]
            ];

            
        } else {
            $apDate1 = new DateTime($leave["apDate1"]);
            $explodedStartTime = explode(":", $leave["startTime"]);
            $explodedEndTime = explode(":", $leave["endTime"]);
            $startTime = $explodedStartTime[0].":".$explodedStartTime[1];
            $endTime = $explodedEndTime[0].":".$explodedEndTime[1];

            $totalTime = $this->getTotalTime($startTime, $endTime);

            $pdf_data["info"][] = [
                't' => $apDate1->format('d/m/Y'),
                'd' => ['x' => 166, 'y' => 510, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => $startTime,
                'd' => ['x' => 250, 'y' => 510, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => $endTime,
                'd' => ['x' => 308, 'y' => 510, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => $totalTime[0],
                'd' => ['x' => 375, 'y' => 510, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => $totalTime[1],
                'd' => ['x' => 400, 'y' => 510, 'size' => 9]
            ];
        }

        //approved by

        if(($leave["HR"] != NULL && $leave["HR"] != "") || ($leave["M"] != NULL && $leave["M"] != "") || ($leave["SS"] != NULL && $leave["SS"] != "") || ($leave["WF"] != NULL && $leave["WF"] != "")) {
            
            $pdf_data["info"][] = [
                't' => "Aprobado por:",
                'd' => ['x' => 90, 'y' => 65, 'size' => 10]
            ];

            if($leave["HR"] != NULL && $leave["HR"] != "") {

                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["HR"]))),
                    'd' => ['x' => 90, 'y' => 52, 'size' => 9]
                ];

            }
    
            if($leave["M"] != NULL && $leave["M"] != "") {

                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["M"]))),
                    'd' => ['x' => 90, 'y' => 40, 'size' => 9]
                ];
            }
    
            if($leave["SS"] != NULL && $leave["SS"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["SS"]))),
                    'd' => ['x' => 90, 'y' => 28, 'size' => 9]
                ];
            }
    
            if($leave["WF"] != NULL && $leave["WF"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["WF"]))),
                    'd' => ['x' => 90, 'y' => 17, 'size' => 9]
                ];
            }
        }

        $pdf_data["info"][] = [
            't' => "Testigos:",
            'd' => ['x' => 336, 'y' => 55, 'size' => 10]
        ];

        $pdf_data["info"][] = [
            't' => "Nombre _________________",
            'd' => ['x' => 336, 'y' => 35, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "DUI ___________",
            'd' => ['x' => 460, 'y' => 35, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "Nombre _________________",
            'd' => ['x' => 336, 'y' => 15, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "DUI ___________",
            'd' => ['x' => 460, 'y' => 15, 'size' => 9]
        ];

        echo json_encode($pdf_data);

    }

    private function movimientosTemplate($leave, $leaveTypeName) {

        $employee = $this->employeeModel->getEmployeeReadByBadge($leave["badge"]);

        $created_date = new DateTime($leave["createdAt"]);
        $apDate = new DateTime($leave["apDate1"]);

        $apDate = new DateTime($leave["apDate1"]);
        
        // $pdf_data["url"] = URLROOT."/public/documents/APs/movimientos.pdf";
        $pdf_data["url"] = URLROOT."/public/documents/APs/movimientos2.pdf";

        $pdf_data["info"] = [
            [
                't' => ucwords(strtolower(html_entity_decode($employee["fullname"]))),
                'd' => ['x' => 112, 'y' => 606, 'size' => 9, 'lineHeight' => 9, 'maxWidth' => 135]
            ],
            [
                't' => strval($leave["badge"]),
                'd' => ['x' => 110, 'y' => 586, 'size' => 10]
            ],
            [
                't' => $created_date->format('d/m/Y'),
                'd' => ['x' => 110, 'y' => 626, 'size' => 10]
            ],
            [
                't' => $apDate->format('d/m/Y'),
                'd' => ['x' => 305, 'y' => 606, 'size' => 10]
            ],
 
        ];

        if($leave["apTypeId"] == 11) { // Retiros de Personal

            if($employee["hiredDateOld"] != NULL && $employee["hiredDateOld"] != "") {
                $hiredDate = new DateTime($employee["hiredDateOld"]);
            } else {
                $hiredDate = new DateTime($employee["hiredDate"]);
            }    

            $pdf_data["info"][] = [
                't' => $hiredDate->format('d/m/Y'),
                'd' => ['x' => 170, 'y' => 320, 'size' => 9]
            ];
            if($leave["withdrawalType"] == "Involuntary") {
                $withdrawalType = "Involuntario";
            } else if($leave["withdrawalType"] == "Voluntary") {
                $withdrawalType = "Voluntario";
            } else {
                $withdrawalType = "";
            }
            $pdf_data["info"][] = [
                't' => $withdrawalType,
                'd' => ['x' => 170, 'y' => 300, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($employee["positionName"]))),
                'd' => ['x' => 170, 'y' => 282, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => '$ '.strval($employee["salary"]),
                'd' => ['x' => 170, 'y' => 260, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => strval($leave["comment"]),
                'd' => ['x' => 170, 'y' => 241, 'size' => 9]
            ];
            
        } else if($leave["apTypeId"] == 4) { // Traslado o Cambio de Puesto

            $currentPosition = $this->positionModel->getPositionById($leave["currentPosition"]);
            $newPosition = $this->positionModel->getPositionById($leave["newPosition"]);

            $currentAccount = $this->departmentModel->getDepartmentById($leave["currentAccount"]);
            $newAccount = $this->departmentModel->getDepartmentById($leave["newAccount"]);

            $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($currentPosition["positionName"]))),
                    'd' => ['x' => 140, 'y' => 503, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($newPosition["positionName"]))),
                'd' => ['x' => 140, 'y' => 483, 'size' => 9]
            ];

            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($currentAccount["name"]))),
                'd' => ['x' => 200, 'y' => 422, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($newAccount["name"]))),
                'd' => ['x' => 200, 'y' => 403, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => html_entity_decode($leave["comment"]),
                'd' => ['x' => 130, 'y' => 383, 'size' => 9, 'lineHeight' => 14, 'maxWidth' => 420]
            ];

        } else {

            $currentPosition = $this->positionModel->getPositionById($leave["currentPosition"]);

            if($leave["newPosition"] != NULL && $leave["newPosition"] != "") {
                $newPosition = $this->positionModel->getPositionById($leave["newPosition"]);
                $newPositionName = $newPosition["positionName"];
            } else {
                $newPositionName = "";
            }

            $currentA = '';
            $currentN = '';
            if (!empty($leave["currentAccount"])){
                $currentAccount = $this->departmentModel->getDepartmentById($leave["currentAccount"]);
                $currentA = $currentAccount["name"];
            }
            if (!empty($leave["newAccount"])){
                $newAccount = $this->departmentModel->getDepartmentById($leave["newAccount"]);
                $currentN = $newAccount["name"];
            }



            $raise = ($leave["newSalary"] - $leave["currentSalary"]);

            $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($currentPosition["positionName"]))),
                    'd' => ['x' => 140, 'y' => 503, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($newPositionName))),
                'd' => ['x' => 140, 'y' => 483, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => '$ '.strval($leave["currentSalary"]),
                'd' => ['x' => 138, 'y' => 462, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => '$ '.strval($leave["newSalary"]),
                'd' => ['x' => 139, 'y' => 443, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => '$ '.strval($raise),
                'd' => ['x' => 300, 'y' => 463, 'size' => 9]
            ];

            $pdf_data["info"][] = [
                't' => html_entity_decode($leave["comment"]),
                'd' => ['x' => 130, 'y' => 383, 'size' => 9, 'lineHeight' => 13, 'maxWidth' => 420]
            ];
            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($currentA))),
                'd' => ['x' => 200, 'y' => 422, 'size' => 9]
            ];
            $pdf_data["info"][] = [
                't' => ucwords(strtolower(html_entity_decode($currentN))),
                'd' => ['x' => 200, 'y' => 403, 'size' => 9]
            ];

        }

        //approved by

        if(($leave["HR"] != NULL && $leave["HR"] != "") || ($leave["M"] != NULL && $leave["M"] != "") || ($leave["SS"] != NULL && $leave["SS"] != "") || ($leave["WF"] != NULL && $leave["WF"] != "")) {
            
            $pdf_data["info"][] = [
                't' => "Aprobado por:",
                'd' => ['x' => 90, 'y' => 65, 'size' => 10]
            ];

            if($leave["HR"] != NULL && $leave["HR"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["HR"]))),
                    'd' => ['x' => 90, 'y' => 52, 'size' => 9]
                ];
            }
    
            if($leave["M"] != NULL && $leave["M"] != "") {

                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["M"]))),
                    'd' => ['x' => 90, 'y' => 40, 'size' => 9]
                ];
            }
    
            if($leave["SS"] != NULL && $leave["SS"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["SS"]))),
                    'd' => ['x' => 90, 'y' => 29, 'size' => 9]
                ];
            }
    
            if($leave["WF"] != NULL && $leave["WF"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["WF"]))),
                    'd' => ['x' => 90, 'y' => 18, 'size' => 9]
                ];
            }
        }

        $pdf_data["info"][] = [
            't' => "Testigos:",
            'd' => ['x' => 336, 'y' => 65, 'size' => 10]
        ];

        $pdf_data["info"][] = [
            't' => "Nombre _________________",
            'd' => ['x' => 336, 'y' => 45, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "DUI ___________",
            'd' => ['x' => 460, 'y' => 45, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "Nombre _________________",
            'd' => ['x' => 336, 'y' => 30, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "DUI ___________",
            'd' => ['x' => 460, 'y' => 30, 'size' => 9]
        ];

        echo json_encode($pdf_data);

    }

    private function amonestacionesTemplate($leave, $leaveTypeName) {

        $pdf_data["url"] = URLROOT."/public/documents/APs/amonestaciones.pdf";

        $employee = $this->employeeModel->getEmployeeReadByBadge($leave["badge"]);

        $initialDateSuspencion = '';
        if (!empty($leave["apDate1"])) {
            $apDate1 = new DateTime($leave["apDate1"]);
            $initialDateSuspencion = $apDate1->format('d/m/Y');
        }
        $finDateSuspension = '';
        if (!empty($leave["apDate2"])) {
            $apDate2 = new DateTime($leave["apDate2"]);
            $finDateSuspension = $apDate2->format('d/m/Y');
        }

        $fechaAmonestacion = '';
        if (!empty($leave["apDate3"])) {
            $apDate3 = new DateTime($leave["apDate3"]);
            $fechaAmonestacion = $apDate3->format('d/m/Y');
        }else{ 
            $fechaAmonestacion = $initialDateSuspencion;
        }

        $pdf_data["info"] = [
            [
                't' => ucwords(strtolower(html_entity_decode($employee["fullname"]))),
                'd' => ['x' => 110, 'y' => 656, 'size' => 11]
            ],
            [
                't' => strval($leave["badge"]),
                'd' => ['x' => 178, 'y' => 640, 'size' => 11]
            ],
            [
                't' => $fechaAmonestacion,
                'd' => ['x' => 98, 'y' => 623, 'size' => 11]
            ],
            [
                't' => $leaveTypeName,
                'd' => ['x' => 105, 'y' => 589, 'size' => 11]
            ],
            [
                't' => html_entity_decode($leave["comment"]),
                'd' => ['x' => 85, 'y' => 530, 'size' => 11, 'lineHeight' => 13, 'maxWidth' => 430]
            ],
        ];

        
        if ($leave['apTypeId'] == 6) { // Sanciones Disciplinarias

            $pdf_data["info"][] = [ // Verbal-Escrita-Suspension
                't' => $leave["reason1"],
                'd' => ['x' => 190, 'y' => 605, 'size' => 11]
            ];

            if ($leave["reason1"] == 'Suspension' ) {

                $pdf_data["info"][] = [
                    't' => "Fecha de Suspensión: ",
                    'd' => ['x' => 400  , 'y' => 620, 'size' => 11]
                ];
                $pdf_data["info"][] = [
                    't' => 'Inicio: ' . $initialDateSuspencion,
                    'd' => ['x' => 400  , 'y' => 605, 'size' => 11]
                ];
                $pdf_data["info"][] = [
                    't' => 'Fin: ' . $finDateSuspension,
                    'd' => ['x' => 400  , 'y' => 590, 'size' => 11]
                ];
            }
        }
        
        $pdf_data["info"][] = [
            't' => date('d/m/Y'),
            'd' => ['x' => 205, 'y' => 237, 'size' => 8.5]
        ];

        //approved by

        if(($leave["HR"] != NULL && $leave["HR"] != "") || ($leave["M"] != NULL && $leave["M"] != "") || ($leave["SS"] != NULL && $leave["SS"] != "") || ($leave["WF"] != NULL && $leave["WF"] != "")) {
            
            $pdf_data["info"][] = [
                't' => "Aprobado por:",
                'd' => ['x' => 90, 'y' => 65, 'size' => 10]
            ];

            if($leave["HR"] != NULL && $leave["HR"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["HR"]))),
                    'd' => ['x' => 90, 'y' => 52, 'size' => 9]
                ];
            }
    
            if($leave["M"] != NULL && $leave["M"] != "") {

                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["M"]))),
                    'd' => ['x' => 90, 'y' => 40, 'size' => 9]
                ];
            }
    
            if($leave["SS"] != NULL && $leave["SS"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["SS"]))),
                    'd' => ['x' => 90, 'y' => 29, 'size' => 9]
                ];
            }
    
            if($leave["WF"] != NULL && $leave["WF"] != "") {
                $pdf_data["info"][] = [
                    't' => ucwords(strtolower(html_entity_decode($leave["WF"]))),
                    'd' => ['x' => 90, 'y' => 18, 'size' => 9]
                ];
            }
        }

        $pdf_data["info"][] = [
            't' => "Testigos:",
            'd' => ['x' => 336, 'y' => 65, 'size' => 10]
        ];

        $pdf_data["info"][] = [
            't' => "Nombre _________________",
            'd' => ['x' => 336, 'y' => 45, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "DUI ___________",
            'd' => ['x' => 460, 'y' => 45, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "Nombre _________________",
            'd' => ['x' => 336, 'y' => 30, 'size' => 9]
        ];

        $pdf_data["info"][] = [
            't' => "DUI ___________",
            'd' => ['x' => 460, 'y' => 30, 'size' => 9]
        ];

        echo json_encode($pdf_data);

    }

    private function getTotalTime($startTime, $endTime)
    {
        $startHour = new DateTime($startTime);
        $endHour = new DateTime($endTime);

        $totalTime = $startHour->diff($endHour);

        $totalHours = strval($totalTime->h);
        $totalMinutes = strval($totalTime->i);

        $total = [$totalHours, $totalMinutes];
        return $total;
    }

    private function getTotalDays($apDate1, $apDate2)
    {
        $totalDays = $apDate1->diff($apDate2);

        return $totalDays->days + 1;
    }
}
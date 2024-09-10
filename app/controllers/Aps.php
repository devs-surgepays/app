<?php
class Aps extends Controller
{
    public $apModel = "";

    public function __construct()
    {
		if(!isLoggedIn()){
            redirect('auth/login');
        }
        $this->apModel = $this->model('Ap');
    }

    public function index(){
        $data['apTypes'] = $this->apModel->getAllApTypes();
        $this->view('ap/index', $data);
    }
	
	public function saveAP(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            // print_r($_POST);
            // exit();
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
                    $data['apDate1']=$_POST["dia1"];
                    if($_POST['tiempopermiso']=="Horas"){
                        $data['startTime']=$_POST['hora_inicio'];
                        $data['endTime']=$_POST['hora_final'];
                    }else{
                        $data['apDate2']=$_POST['dia2'];
                    }
                    break;
                case 2:
                    $data['reason1']=$_POST["motivo_permiso"];
                    $data['apDate1']=$_POST["dia1"];
                    if($_POST['tiempopermiso']=="Horas"){
                        $data['startTime']=$_POST['hora_inicio'];
                        $data['endTime']=$_POST['hora_final'];
                    }else{
                        $data['apDate2']=$_POST['dia2'];
                    }
                    
                    break;
                case 3:
                    $data['reason1']="Vacation";
                    $data['apDate1']=$_POST["inicioVacaciones"];
                    $data['apDate2']=$_POST["finVacaciones"];
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
                    $data['reason1']=$_POST['tipoSancion'];
                    if(isset($_POST['septimo'])){
                        $data['reason2']=($_POST['septimo']=="Yes")?"Septimo":"";
                    }
                    if(isset($_POST['inicioSuspension'])){
                        $data['apDate1']=$_POST['inicioSuspension'];
                    } 
                    if(isset($_POST['finSuspension'])){
                        $data['apDate2']=$_POST['finSuspension'];
                    }
                    break;
                case 7:
                    $data['apDate1']=$_POST['inicioHorario'];
                    $data['apDate2']=$_POST['finHorario'];
                    $data['reason1']=$_POST['motivo_horario'];
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
                    $attrition = $this->apModel->getAttritionsResons($_POST['attritions']);
                    $reasonsDetails = $this->apModel->getAttritionsResonsDetails($_POST['reasonsDetails']);
                    $data['reason1']=$attrition['name'];
                    $data['reason2']=$reasonsDetails['name'];
                    $data['apDate1']=$_POST['fechaRetiro'];
                    break;
                case 12:
                    $data['newSalary']=$_POST['monto'];
                    $data['apDate1']=$_POST['diaEfectivo'];
                    if(isset($_POST['newPosition2'])){
                        $data['currentPosition']=$_POST['currentPosition'];
                    $data['newPosition']=$_POST['newPosition2'];
                    }
                    break;               


            }
            $this->apModel->insertLeave($data);
            $data['status']="success";
            $data['message']="your leave has been saved succesfully";
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

    public function read(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
    //if($_POST){
        //die('Submit');
        $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $page = (isset($_POST['page']) && !empty($_POST['page']))?$_POST['page']:1;
        $data = [
            'action'=>trim($_POST['action']),
            'arrayCampos'=>$_POST['search'],
            'order_by'=>'a.apDetailsId asc',
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
            'order_by'=>'a.apDetailsId asc',
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
        $camposBase=array("apDetailsId","fullName","badge","createdAt","username","name","status");
        if($data['arrayCampos']){
            for($index=0;$index<sizeof($data['arrayCampos']);$index++){
                $count += ($data['arrayCampos'][$index]!='')?1:0;
                
                    if(!empty($data['arrayCampos'][$index])){

                            if($count<=1){
                                $addWhere.=" ".$camposBase[$index]." LIKE '%".$data['arrayCampos'][$index]."%'";
                            }else{
                                $addWhere.=" and ".$camposBase[$index]." LIKE '%".$data['arrayCampos'][$index]."%'";
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

        $data['fields']=$getOrders;
    
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

        public function getApTypes(){
           $row = $this->apModel->getAllApTypes();
           print_r($row);
        }

        public function getEmployeeInfo($badge){
            $row = $this->apModel->searchEmployeeByBadge($badge);
            //print_r($row);
            echo json_encode($row);
        }
	
		public function getAttritionReasons(){
			//print_r($_POST);
			//exit();
			if($_SERVER['REQUEST_METHOD']=='POST'){
        		$_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
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
}
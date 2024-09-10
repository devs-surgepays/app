<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
class Employees extends Controller
{
    private $departmentModel = '';
    private $positionModel = '';
    private $employeeModel = '';
    private $bankModel = '';
    private $afpModel = '';
    private $employeeDocumentModel = '';
    private $activityLogModel = '';
    private $employeeScheduleModel = '';
    private $emergencyContactsModel = '';
    private $relationshipModel = '';
    private $usersModel = '';
    private $areaModel = '';
    private $billModel = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auths/index');
        }

        $this->departmentModel = $this->model('Department');
        $this->positionModel = $this->model('Position');
        $this->employeeModel = $this->model('Employee');
        $this->bankModel = $this->model('Bank');
        $this->afpModel = $this->model('AFP');
        $this->employeeDocumentModel = $this->model('EmployeeDocument');
        $this->activityLogModel = $this->model('ActivityLog');
        $this->employeeScheduleModel = $this->model('EmployeeSchedule');
        $this->emergencyContactsModel = $this->model('EmergencyContact');
        $this->relationshipModel = $this->model('Relationship');
        $this->usersModel = $this->model('User');
        $this->areaModel = $this->model('Area');
        $this->billModel = $this->model('bill');
    }

    public function index()
    {
        $data = [];
        $data['departments'] = $this->departmentModel->getDeparments();
        $data['positions'] = $this->positionModel->getPositions();
        $data['status'] = array(array('statusId' => '1', 'statusName' => 'Active'), array('statusId' => '00', 'statusName' => 'Inactive'));
        $this->view('employees/index', $data);
    }

    public function create()
    {
        $data = [];

        $data['states'] = $this->employeeModel->getStates();
        $data['departments'] = $this->departmentModel->getDeparments();
        $data['positions'] = $this->positionModel->getPositions();
        $data['banks'] = $this->bankModel->getBanks();
        $data['afps'] = $this->afpModel->getAFPs();
        $data['superiors'] = $this->usersModel->getSuperiors();
        $data['areas'] = $this->areaModel->getAreas();
        $data['bills'] = $this->billModel->getBillsTo();
        $this->view('employees/create', $data);
    }

    public function createEmpProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            try {
                $returnMessage = ['status' => false, 'message' => '', 'fieldError' => array()];
                $data = [
                    'firstName' => ucfirst(strtolower($_POST['firstName'])),
                    'secondName' => ucfirst(strtolower($_POST['secondName'])),
                    'thirdName' => (isset($_POST['thirdName']) && $_POST['thirdName'] != NULL) ? ucfirst(strtolower($_POST['thirdName'])) : null,
                    'firstLastName' => ucfirst(strtolower($_POST['firstLastName'])),
                    'secondLastName' => ucfirst(strtolower($_POST['secondLastName'])),
                    'thirdLastName' => (isset($_POST['thirdLastName']) && $_POST['thirdLastName'] != NULL) ? ucfirst(strtolower($_POST['thirdLastName'])) : null,
                    'contactPhone' => preg_replace('/[^0-9]/', '', $_POST['contactPhone']),
                    'personalEmail' => trim($_POST['personalEmail']),
                    'dob' => $_POST['dob'],
                    'genderId' => $_POST['genderId'],
                    'documentNumber' => $_POST['documentNumber'],
                    'documentExpDate' => $_POST['documentExpDate'],
                    'documentExpedDate' => $_POST['documentExpedDate'],
                    'documentExpedPlace' => $_POST['documentExpedPlace'],
                    'ssn' => trim($_POST['ssn']),
                    'stateId' => $_POST['stateId'],
                    'cityId' => $_POST['cityId'],
                    'districtId' => $_POST['districtId'],
                    'address' => trim($_POST['address']),
                    'maritalStatus' => trim($_POST['maritalStatus']),
                    'children' => trim($_POST['children']),
                    'educationLevel' => trim($_POST['educationLevel']),
                    'career' => trim($_POST['career']),
                    'departmentId' => trim($_POST['departmentId']),
                    'areaId' => trim($_POST['areaId']),
                    'superiorId' => trim($_POST['superiorId']),
                    'positionId' => trim($_POST['positionId']),
                    'corporateEmail' => trim($_POST['corporateEmail']),
                    'hiredDate' => trim($_POST['hiredDate']),
                    'contractType' => trim($_POST['contractType']),
                    'workHours' => trim($_POST['workHours']),
                    'bankId' => trim($_POST['bankId']),
                    'bankAccount' => trim($_POST['bankAccount']),
                    'afpTypeId' => trim($_POST['afpTypeId']),
                    'afpNumber' => trim($_POST['afpNumber']),
                    'salary' => trim($_POST['salary']),
                    'billTo' => trim($_POST['billTo']),
                    'thirdName' => trim($_POST['thirdName']),
                    'thirdLastName' => trim($_POST['thirdLastName']),
                    'birthMunicipality' => trim($_POST['birthMunicipality']),
                    'birthDeparment' => trim($_POST['birthDeparment']),
                    'homePhone' => trim($_POST['homePhone']),
                    'nationality' => trim($_POST['nationality']),
                    'contractsigning' => trim($_POST['contractsigning']),
                    'signingContractHeadset' => trim($_POST['signingContractHeadset']),
                    'signingConfidentialityAgreement' => trim($_POST['signingConfidentialityAgreement']),
                    'bonus' => trim($_POST['bonus']),
                    'changedFields' => trim($_POST['changedFields']),
                ];

                // CrateBadge...
                $newBadge = $this->employeeModel->createBadgeEmployee();
                $data['badge'] = $newBadge;

                // save in employee table and add lastIdEmployee in data
                $lastIdEmployee = $this->employeeModel->createEmployee($data);
                $data['lastIdEmployee'] = $lastIdEmployee;

                if (!empty($data['lastIdEmployee'])) {

                    // Save log
                    $alog = json_decode($data['changedFields'], true);
                    $alog['employeeId'] = $data['lastIdEmployee'];
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $lastIdEmployee, 'action' => 'Create', 'page' => 'Employee', 'fields' => json_encode($alog)];
                    $this->activityLogModel->saveActivityLog($dataLog);

                    $returnMessage = ['status' => true, 'message' => '', 'fieldError' => array()];

                    // Documents upload
                    $nameFile = $newBadge . '_' . substr($data['firstName'], 0, 1) . substr($data['firstLastName'], 0, 1).'_'.date('mdyhis');
                    $dataEmployeeDocument['employeeId'] = $data['lastIdEmployee'];
                    $re = $this->uploadSaveFile($_FILES, $data['lastIdEmployee'], $nameFile);
                    //--------------------------------------------------------------------------------
                    $returnMessage = ['status' => true, 'message' => 'The employee has been successfully added. Badge: ' . $newBadge, 'fieldError' => $re['errorFileSave']];
                } else {
                    $returnMessage = ['status' => false, 'message' => 'Error Employee Table', 'fieldError' => array()];
                }

                echo json_encode($returnMessage);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Error ' . $e, 'fieldError' => array()]);
            }
        }
    }

    public function edit($badgeEmployee = '')
    {

        if (!empty($badgeEmployee)) {
            $data = [];            
            $data['employeeInfo'] = $this->employeeModel->getEmployeeDetailsByBadge($badgeEmployee);
            $idEmployee = $data['employeeInfo']['employeeId'];

            if (!empty($idEmployee)) {

                $data['states'] = $this->employeeModel->getStates();
                $data['departments'] = $this->departmentModel->getDeparments();
                $data['positions'] = $this->positionModel->getPositions();
                $data['banks'] = $this->bankModel->getBanks();
                $data['afps'] = $this->afpModel->getAFPs();
                $data['areas'] = $this->areaModel->getAreas();
                $data['bills'] = $this->billModel->getBillsTo();
                
                $data['employeeDocumentsInfo'] = $this->employeeDocumentModel->getEmployeDocument($idEmployee);
                $data['employeeSchedule'] = $this->employeeScheduleModel->getSchedulesEmployee($idEmployee);
                $data['employeeEmergencyContacts'] = $this->emergencyContactsModel->getEmergencyContacts($idEmployee);
                $data['relationship'] = $this->relationshipModel->getRelationshipsEnglish();
                $data['superiors'] = $this->usersModel->getSuperiors();
                
            } else {
                redirect('employees/index');
            }


            $this->view('employees/edit', $data);
        } else {
            redirect('employees/index');
        }
    }

    public function editEmpProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $return = ['status'=>false, 'message'=>'','messageDetails'=>''];
            try {
                $changedFields =  (isset($_POST['changedFields']) && $_POST['changedFields'] != NULL) ? json_decode($_POST['changedFields'],true) : [];
                $employeeId = base64_decode($_POST['employeeId']);
                $badge = base64_decode($_POST['badge']);
                $firstName = $_POST['firstName'];
                $firstLastName = $_POST['firstLastName'];

                if (!empty($changedFields)) {
                    $changedFields['employeeId'] = $employeeId;

                    // Clean fields if there are in array changeField
                    if (isset($changedFields['firstName']) && $changedFields['firstName'] != NULL) $changedFields['firstName'] = ucfirst(strtolower($changedFields['firstName']));
                    if (isset($changedFields['secondName']) && $changedFields['secondName'] != NULL) $changedFields['secondName'] = ucfirst(strtolower($changedFields['secondName']));
                    if (isset($changedFields['thirdName']) && $changedFields['thirdName'] != NULL) $changedFields['thirdName'] = ucfirst(strtolower($changedFields['thirdName']));
                    if (isset($changedFields['firstLastName']) && $changedFields['firstLastName'] != NULL) $changedFields['firstLastName'] = ucfirst(strtolower($changedFields['firstLastName']));
                    if (isset($changedFields['secondLastName']) && $changedFields['secondLastName'] != NULL) $changedFields['secondLastName'] = ucfirst(strtolower($changedFields['secondLastName']));
                    if (isset($changedFields['thirdLastName']) && $changedFields['thirdLastName'] != NULL) $changedFields['thirdLastName'] = ucfirst(strtolower($changedFields['thirdLastName']));
                    if (isset($changedFields['contactPhone']) && $changedFields['contactPhone'] != NULL) $changedFields['contactPhone'] =  preg_replace('/[^0-9]/', '', $_POST['contactPhone']);

                    $this->employeeModel->updatedEmployee($changedFields);
                    // unset($changedFields['employeeId']);
                }

                // removed files
                if (!empty($_POST['antecedentesPenales_delete'])){
                    $this->employeeDocumentModel->removedEmployeeDocument($employeeId,3);
                    $changedFields['antecedentesPenales']= 'removed';
                }
                if (!empty($_POST['solvenciaPNC_delete'])){
                    $this->employeeDocumentModel->removedEmployeeDocument($employeeId,4);
                    $changedFields['solvenciaPNC']= 'removed';
                }
                if (!empty($_POST['expediente_delete'])){
                    $this->employeeDocumentModel->removedEmployeeDocument($employeeId,5);
                    $changedFields['expediente']= 'removed';
                }
                if (!empty($_POST['contract_delete'])){
                    $this->employeeDocumentModel->removedEmployeeDocument($employeeId,6);
                    $changedFields['contract']= 'removed';
                }
                // upload files if there are.
                $nameFile = $badge . '_' . substr($firstName, 0, 1) . substr($firstLastName, 0, 1).'_'.date('mdyhis');
                $re = $this->uploadSaveFile($_FILES, $employeeId, $nameFile); // errorFileSave - changedFields
                $changesFinal = array_merge($changedFields, $re['changedFields']);

                // Add log
                if (!empty($changesFinal)){
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $employeeId, 'action' => 'Edit', 'page' => 'Employee', 'fields' => json_encode($changesFinal)];
                    $this->activityLogModel->saveActivityLog($dataLog);
                    $return['status']=true;
                }else{
                    $return['message']='No changes found!';
                }
            } catch (Exception $e) {
                $return['message']='An unexpected error ocurred. Please try again';
                $return['messageDetails']=$e;
            }

            echo json_encode($return);
        }
    }

    public function getDataRows()
    {

        $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
        $page = (isset($_REQUEST['page']) && $_REQUEST['page'] != NULL) ? $_REQUEST['page'] : '';
        $searchFields = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $_REQUEST['search'] : '';
        $length = (isset($_REQUEST['length']) && $_REQUEST['length'] != NULL) ? $_REQUEST['length'] : '';
        $ascDesc = (isset($_REQUEST['ascDesc']) && $_REQUEST['ascDesc'] != NULL) ? $_REQUEST['ascDesc'] : '';
        $return = array();

        if ($action == 'ajaxDataRows') {

            $orderby = " e.badge desc";
            $countField = 0;
            $searchQuery = '';

            $per_page = $length; // number of records you want to display
            $offset = ($page - 1) * $per_page;
            $offsetnumShow = ($page - 1) * $per_page + 1;


            if (!empty($ascDesc)) {
                if ($ascDesc[0] == "fa fa-sort-up") $orderby = "e.createdAt asc";
                else if ($ascDesc[0] == "fa fa-sort-down") $orderby = "e.createdAt desc";
                // if ($ascDesc[1] == "fas fa-sort-up") $orderby = "date_retained asc";
                // else if ($ascDesc[1] == "fas fa-sort-down") $orderby = "date_retained desc";
            }

            if (!empty($searchFields)) { // Count fields full
                for ($i = 0; $i < count($searchFields); $i++) if ($searchFields[$i] != "") $countField++;
            }

            if ($countField > 0) {
                $fielDB = array(
                    0 => array("badge", 'equal'),
                    1 =>  array('-', 'multiField', array("firstName", "secondName", "thirdName", "firstLastName", "secondLastName", "thirdLastName")),
                    2 =>  array("corporateEmail", 'like'),
                    3 => array("hiredDate", 'date'),
                    4 =>  array("e.departmentId", 'equal'),
                    5 =>  array("e.positionId", 'equal'),
                    6 =>  array("e.status", 'equal'),
                    // 2 =>  array("customer_id", 'equalString'),
                    // 5 =>  array("phone_number", 'phone'),
                );
                $searchQuery = '';
                $op = false;

                for ($i = 0; $i < count($fielDB); $i++) {



                    $fielname = $fielDB[$i][0];
                    $type = $fielDB[$i][1];
                    $value = $searchFields[$i];


                    if (!empty($value)) {

                        if ($op) $searchQuery .= ' and ';

                        if ($type == 'equal') {

                            $op = true;
                            $searchQuery .= " " . $fielname . " = " . $value . "";
                        } else if ($type == 'equalString') {
                            $op = true;
                            $searchQuery .= " " . $fielname . " = '" . $value . "'";
                        } else if ($type == 'multiField') {
                            $op = true;
                            $fieldSearch = $fielDB[$i][2];
                            $searchQuery .= $this->build_search_query($value, $fieldSearch);
                        } else if ($type == 'phone') {
                            $op = true;
                            $searchQuery .= " " . $fielname . " LIKE '%" . preg_replace('([^A-Za-z0-9])', '', $value) . "%'";
                        } else { // like default
                            $searchQuery .= " " . $fielname . " LIKE '%" . $value . "%'";
                            $op = true;
                        }
                    }
                }
            }

            $return['searchQuery'] = $searchQuery;
            $countTotal = $this->employeeModel->countRegisterEmployee($searchQuery);
            $numrows = $countTotal['numrows'];
            $total_pages = ceil($numrows / $per_page);
            $reload = 'index.php';
            $number = 1;
            $c = 0;
            $htmlRows = '';
            $htmlPagination = '';
            $registers = $this->employeeModel->readRegisters($offset, $per_page, $searchQuery, $orderby);

            if (!empty($registers)) {

                for ($i = 0; $i < count($registers); $i++) {
                    $c = $offset + $number;
                    $status = ($registers[$i]['status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';

                    $htmlRows .= '<tr class="dataexp">';
                    $htmlRows .= '<td><i class="fa fa-point"></i>' . $c . '</td>';
                    $htmlRows .= '<td><button class="btn btn-primary btn-border">#' . $registers[$i]['badge'] . '</button> </td>';
                    $htmlRows .= '<td>' . $registers[$i]['firstName'] . ' ' .
                        $registers[$i]['secondName'] . ' ' .
                        $registers[$i]['thirdName'] . ' ' .
                        $registers[$i]['firstLastName'] . ' ' .
                        $registers[$i]['secondLastName'] . ' ' .
                        $registers[$i]['thirdLastName'] . '</td>';

                    $htmlRows .= '<td>' . $registers[$i]['corporateEmail'] . '</td>';
                    $htmlRows .= '<td>' . date('F d, Y', strtotime($registers[$i]['hiredDate'])) . '</td>';
                    $htmlRows .= '<td>' . $registers[$i]['name'] . '</td>';
                    $htmlRows .= '<td>' . $registers[$i]['positionName'] . '</td>';
                    $htmlRows .= '<td>' . $status . '</td>';
                    $htmlRows .= '<td><a href="' . URLROOT . '/employees/edit/' . $registers[$i]['badge'] . '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a></td>';
                    $htmlRows .= '</tr>';
                    $number++;
                }
                $return['rows'] = $htmlRows;
            }

            $htmlShowing = "<p>Showing " . $offsetnumShow .   " to " . $c . " of " . $numrows . "</p>";
            $htmlPagination .= '<nav style="float:right;">';
            $htmlPagination .=  paginateRead($reload, $page, $total_pages, 2, $searchFields, $length, $ascDesc);
            $htmlPagination .= '</nav>';

            $return['showing'] = $htmlShowing;
            $return['pagination'] = $htmlPagination;
        }

        if (empty($return['rows'])) $return['rows'] = '<tr class="text-center"><td colspan="9">No records found</td></tr>';

        echo json_encode($return);
    }

    public function getInfoCard() {
        $data = [];
        $data['TotalEmployeeActive'] = $this->employeeModel->getTotalEmployeeActive();
        $data['TotalEmployee'] = $this->employeeModel->getTotalEmployee();
        $data['CustomerServicesActive'] = $this->employeeModel->getTotalEmployeeCustomerServices();
        $data['HiredToday'] = $this->employeeModel->getTotalEmployeeHiredToday();
        echo json_encode($data);
       
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

    public function uploadSaveFile($FILES, $IdEmployee, $nameFile)
    {
        $errorSave = [];
        $changedFields = [];
        $dataEmployeeDocument['employeeId'] = $IdEmployee;

        // Photo is difference because updated field in the table employeeDetails 
        if (!empty($FILES['photo']['tmp_name'])) {
            $rePhoto = $this->handleFileUpload($FILES['photo'], 'photo', $nameFile . '_photo');
            $dataEmployeeDocument['photo'] = $rePhoto['nameFile'];
            if ($rePhoto['status']){
                $this->employeeModel->updatedEmployee($dataEmployeeDocument);
                $changedFields['photo']= $rePhoto['nameFile'];
            }else $errorSave['Photo'] = $rePhoto['messageError'];
        } else $errorSave['Photo'] = 'Field Empty';


        // antecedentes Penales
        if (!empty($FILES['antecedentesPenales']['tmp_name'])) {

            $reantecedentesPenales = $this->handleFileUpload($FILES['antecedentesPenales'], 'antecedentesPenales', $nameFile . '_antecedentesPenales');
            $dataEmployeeDocument['documentTypeId'] = 3;
            $dataEmployeeDocument['document'] = $reantecedentesPenales['nameFile'];
            if ($reantecedentesPenales['status']) {
                $this->employeeDocumentModel->removedEmployeeDocument($IdEmployee,3);
                $this->employeeDocumentModel->saveEmployeeDocument($dataEmployeeDocument); // Save Documents name
                $changedFields['antecedentesPenales']= $reantecedentesPenales['nameFile'];
            }
            else $errorSave['antecedentesPenales'] = $reantecedentesPenales['messageError'];
        } else $errorSave['antecedentesPenales'] = 'Field Empty';

        // Solvencia PNC
        if (!empty($FILES['solvenciaPNC']['tmp_name'])) {
            $resolvenciaPNC = $this->handleFileUpload($FILES['solvenciaPNC'], 'solvenciaPNC', $nameFile . '_solvenciaPNC');
            $dataEmployeeDocument['documentTypeId'] = 4;
            $dataEmployeeDocument['document'] = $resolvenciaPNC['nameFile'];
            if ($resolvenciaPNC['status']) {
                $this->employeeDocumentModel->removedEmployeeDocument($IdEmployee,4);
                $this->employeeDocumentModel->saveEmployeeDocument($dataEmployeeDocument); // Save Documents name
                $changedFields['solvenciaPNC']= $resolvenciaPNC['nameFile'];
            }
            else $errorSave['solvenciaPNC'] = $resolvenciaPNC['messageError'];
        } else $errorSave['solvenciaPNC'] = 'Field Empty';

        // Expediente
        if (!empty($FILES['expediente']['tmp_name'])) {
            $reexpediente = $this->handleFileUpload($FILES['expediente'], 'expediente', $nameFile . '_expediente');
            $dataEmployeeDocument['documentTypeId'] = 5;
            $dataEmployeeDocument['document'] = $reexpediente['nameFile'];
            if ($reexpediente['status']) {
                $this->employeeDocumentModel->removedEmployeeDocument($IdEmployee,5);
                $this->employeeDocumentModel->saveEmployeeDocument($dataEmployeeDocument); // Save Documents name
                $changedFields['expediente']= $reexpediente['nameFile'];
            }
            else $errorSave['expediente'] = $reexpediente['messageError'];
        } else $errorSave['expediente'] = 'Field Empty';

        // contract
        if (!empty($FILES['contract']['tmp_name'])) {
            $recontract = $this->handleFileUpload($FILES['contract'], 'contract', $nameFile . '_contract');
            $dataEmployeeDocument['documentTypeId'] = 6;
            $dataEmployeeDocument['document'] = $recontract['nameFile'];
            if ($recontract['status']) {
                $this->employeeDocumentModel->removedEmployeeDocument($IdEmployee,6);
                $this->employeeDocumentModel->saveEmployeeDocument($dataEmployeeDocument); // Save Documents name
                $changedFields['contract']= $recontract['nameFile'];
            }
            else $errorSave['contract'] = $recontract['messageError'];
        } else $errorSave['contract'] = 'Field Empty';

        $re = [
            'changedFields' => $changedFields,
            'errorSave'=> $errorSave,
        ];
        return $re;
    }

    // Function to handle file upload
    function handleFileUpload($file, $nameDir, $nameFile, $maxFileSize = 5)
    {

        $maxFileSize = $maxFileSize * 1024 * 1024; // Specify the max file size (e.g., 5MB)
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/surge-hr/public/documents/{$nameDir}/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true); //directory exists
        $re = ['status' => false, 'messageError' => '', 'nameFile' => '',];

        // Create a name for the file
        $customFileName = $nameFile; // or use any logic you prefer
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $targetFilePath = $targetDir . $customFileName . '.' . $fileExtension;
        $nameFinally = $nameFile . '.' . $fileExtension;

        if (in_array($fileExtension,  array("jpg", "png", "jpeg", "pdf"))) {
            // Validate file size
            if ($file["size"] <= $maxFileSize) {

                if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                    $re['status'] = true;
                    $re['nameFile'] = $nameFinally;
                } else {
                    $re['messageError'] = 'Sorry, there was an error uploading your file.';
                }
            } else {
                $re['messageError'] = 'Sorry, your file is too large. Max file size is 5MB.';
            }
        } else {
            $re['messageError'] = 'Sorry, only jpg, png, jpeg, pdf files are allowed.';
        }
        return $re;
    }

    public function getEmployeeByBagde($badge = null){
        $namesEmployee = $this->employeeModel->getEmployeeByBadge($badge);
        echo json_encode($namesEmployee);
    }

    public function getCitiesByStateId($stateId = null)
    {
        $cities = $this->employeeModel->getCitiesByStatesId($stateId);
        echo json_encode($cities);
    }
    public function getDisctrictByCityId($cityId = null)
    {
        $cities = $this->employeeModel->getDistrictByCityId($cityId);
        echo json_encode($cities);
    }
}
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
    private $financialDependentModel = '';

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
        $this->billModel = $this->model('Bill');
        $this->financialDependentModel = $this->model('FinancialDependent');
    }

    public function index()
    {
        $data = [];
        $data['departments'] = $this->departmentModel->getDeparments();
        $data['positions'] = $this->positionModel->getPositionsGroupBy();
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
                    'genderId' => (isset($_POST['genderId']) && $_POST['genderId'] != NULL) ? trim($_POST['genderId']) : Null,
                    'documentTypeId' => intval($_POST['documentTypeId']),
                    'documentNumber' => $_POST['documentNumber'],
                    'documentExpDate' => $_POST['documentExpDate'],
                    'documentExpedDate' => (isset($_POST['documentExpedDate']) && $_POST['documentExpedDate'] != NULL) ? trim($_POST['documentExpedDate']) : Null,
                    'documentExpedPlace' => $_POST['documentExpedPlace'],
                    'ssn' => trim($_POST['ssn']),
                    'stateId' => (isset($_POST['stateId']) && $_POST['stateId'] != NULL) ? trim($_POST['stateId']) : Null,
                    'cityId' => (isset($_POST['cityId']) && $_POST['cityId'] != NULL) ? trim($_POST['cityId']) : Null,
                    'districtId' => (isset($_POST['districtId']) && $_POST['districtId'] != NULL) ? trim($_POST['districtId']) : Null,
                    'address' => trim($_POST['address']),
                    'maritalStatus' => trim($_POST['maritalStatus']),
                    'children' => (isset($_POST['children']) && $_POST['children'] != NULL) ? trim($_POST['children']) : Null,
                    'educationLevel' => trim($_POST['educationLevel']),
                    'career' => trim($_POST['career']),
                    'departmentId' => (isset($_POST['departmentId']) && $_POST['departmentId'] != NULL) ? trim($_POST['departmentId']) : Null,
                    'areaId' => (isset($_POST['areaId']) && $_POST['areaId'] != NULL) ? trim($_POST['areaId']) : Null,
                    'superiorId' => (isset($_POST['superiorId']) && $_POST['superiorId'] != NULL) ? trim($_POST['superiorId']) : Null,
                    'positionId' => (isset($_POST['positionId']) && $_POST['positionId'] != NULL) ? trim($_POST['positionId']) : Null,
                    'corporateEmail' => trim($_POST['corporateEmail']),
                    'hiredDate' => trim($_POST['hiredDate']),
                    'contractType' => (isset($_POST['contractType']) && $_POST['contractType'] != NULL) ? trim($_POST['contractType']) : Null,
                    'workHours' => (isset($_POST['workHours']) && $_POST['workHours'] != NULL) ? trim($_POST['workHours']) : Null,
                    'bankId' => (isset($_POST['bankId']) && $_POST['bankId'] != NULL) ? trim($_POST['bankId']) : Null,
                    'bankAccount' => trim($_POST['bankAccount']),
                    'afpTypeId' => (isset($_POST['afpTypeId']) && $_POST['afpTypeId'] != NULL) ? trim($_POST['afpTypeId']) : Null,
                    'afpNumber' => (isset($_POST['afpNumber']) && $_POST['afpNumber'] != NULL) ? trim($_POST['afpNumber']) : Null,
                    'salary' => trim($_POST['salary']),
                    'billTo' => (isset($_POST['billTo']) && $_POST['billTo'] != NULL) ? trim($_POST['billTo']) : Null,
                    'thirdName' => trim($_POST['thirdName']),
                    'thirdLastName' => trim($_POST['thirdLastName']),
                    'birthMunicipality' => trim($_POST['birthMunicipality']),
                    'birthDeparment' => trim($_POST['birthDeparment']),
                    'homePhone' => trim($_POST['homePhone']),
                    'nationality' => trim($_POST['nationality']),
                    'contractsigning' => (isset($_POST['contractsigning']) && $_POST['contractsigning'] != NULL) ?  trim($_POST['contractsigning']) : Null,
                    'signingContractHeadset' => (isset($_POST['signingContractHeadset']) && $_POST['signingContractHeadset'] != NULL) ?  trim($_POST['signingContractHeadset']) : Null,
                    'signingConfidentialityAgreement' => (isset($_POST['signingConfidentialityAgreement']) && $_POST['signingConfidentialityAgreement'] != NULL) ? trim($_POST['signingConfidentialityAgreement']) : Null,
                    'bonus' => (isset($_POST['bonus']) && $_POST['bonus'] != NULL) ? trim($_POST['bonus']) : Null,
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
                    $nameFile = $newBadge . '_' . substr($data['firstName'], 0, 1) . substr($data['firstLastName'], 0, 1) . '_' . date('mdyhis');
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
                $data['typesDocuments'] = $this->employeeDocumentModel->getTypesDocuments();

                $data['employeeDocumentsInfo'] = $this->employeeDocumentModel->getEmployeDocument($idEmployee);
                $data['employeeSchedule'] = $this->employeeScheduleModel->getSchedulesEmployee($idEmployee);
                $data['employeeEmergencyContacts'] = $this->emergencyContactsModel->getEmergencyContacts($idEmployee);
                $data['relationship'] = $this->relationshipModel->getRelationshipsEnglish();
                $data['superiors'] = $this->usersModel->getSuperiors();
                $data['financialDependents'] = $this->financialDependentModel->getFinancialDependents($idEmployee);


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

            $return = ['status' => false, 'message' => '', 'messageDetails' => ''];
            try {
                $changedFields =  (isset($_POST['changedFields']) && $_POST['changedFields'] != NULL) ? json_decode($_POST['changedFields'], true) : [];
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
                }
                // upload files if there are.
                $nameFile = $badge . '_' . substr($firstName, 0, 1) . substr($firstLastName, 0, 1) . '_' . date('mdyhis');
                $re = $this->uploadSaveFile($_FILES, $employeeId, $nameFile); // errorFileSave - changedFields
                $changesFinal = array_merge($changedFields, $re['changedFields']);
                $return['responseFiles'] = $re;
                $return['FILES'] = $_FILES;

                // Remove the element with the key 'employeeId'
                unset($changesFinal['employeeId']);

                // Add log
                if (!empty($changesFinal)) {
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $employeeId, 'action' => 'Edit', 'page' => 'Employee', 'fields' => json_encode($changesFinal)];
                    $this->activityLogModel->saveActivityLog($dataLog);
                    $return['status'] = true;
                } else {
                    $return['message'] = 'No changes found!';
                }
            } catch (Exception $e) {
                $return['message'] = 'An unexpected error ocurred. Please try again';
                $return['messageDetails'] = $e;
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
                    5 =>  array("p.positionName", 'like'),
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
                    $status = ($registers[$i]['statusEmployee'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';

                    $htmlRows .= '<tr class="dataexp">';
                    $htmlRows .= '<td><i class="fa fa-point"></i>' . $c . '</td>';
                    $htmlRows .= '<td><a href="' . URLROOT . '/employees/edit/' . $registers[$i]['badge'] . '" class="btn btn-primary btn-border">#' . $registers[$i]['badge'] . '</a> </td>';
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

    public function getInfoCard()
    {
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

        if (!empty($FILES['photo']['tmp_name'])) {
            $rePhoto = $this->handleFileUpload($FILES['photo'], 'photo', $nameFile . '_photo');
            $dataEmployeeDocument['photo'] = $rePhoto['nameFile'];

            if ($rePhoto['status']) {

                $this->employeeModel->updatedEmployee($dataEmployeeDocument);
                $changedFields['photo'] = $rePhoto['nameFile'];
            } else $errorSave['Photo'] = $rePhoto['messageError'];
        } else $errorSave['Photo'] = 'Field Empty';

        $re = [
            'changedFields' => $changedFields,
            'errorSave' => $errorSave,
        ];
        return $re;
    }

    // Function to handle file upload
    function handleFileUpload($file, $nameDir, $nameFile, $maxFileSize = 5)
    {
        $maxFileSize = $maxFileSize * 1024 * 1024; // Specify the max file size (e.g., 5MB)
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/app/public/documents/{$nameDir}/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true); //directory exists

        $re = ['status' => false, 'messageError' => '', 'nameFile' => '',];

        // Create a name for the file
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $nameFinally = $nameFile . '.' . $fileExtension;

        $targetFilePath = $targetDir . $nameFinally;
        $re['targetFilePath'] = $targetFilePath;

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

    public function getEmployeeByBagde($badge = null)
    {
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

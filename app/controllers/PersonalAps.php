<?php

class PersonalAps extends Controller
{
    private $employeeModel;
    private $activityLogModel;
    public $apModel;
    public $userModel;
    public $employeeScheduleModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->apModel = $this->model('Ap');
        $this->employeeModel = $this->model('Employee');
        $this->activityLogModel = $this->model('ActivityLog');
        $this->userModel = $this->model('User');
        $this->employeeScheduleModel = $this->model('EmployeeSchedule');

    }

    public function index()
    {
        $data['apTypes'] = $this->apModel->getAllApTypes();
        $employeeData = $this->employeeModel->getEmpInfoByIdEmployee($_SESSION['employeeId']);
        $a = [];
        $a['badge'] = $employeeData['badge'];
        $a['fullName'] = $employeeData['fullname'];
        $a['nameDepartament'] = $employeeData['nameDepartament'];
        $a['positionName'] = $employeeData['positionName'];
        $a['employeeId'] = $_SESSION['employeeId'];
        $data['infoAgent'] = $a;
        $this->view('personalAps/index', $data);
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
            $badge = $this->userModel->getBadgeByUserId($_SESSION['userId']);
            if (!empty($badge)) {

                $orderby = " ap.apDetailsId desc";
                $countField = 0;
                $searchQuery = '';

                $per_page = $length; // number of records you want to display
                $offset = ($page - 1) * $per_page;
                $offsetnumShow = ($page - 1) * $per_page + 1;

                if (!empty($ascDesc)) {
                    // if ($ascDesc[0] == "fa fa-sort-up") $orderby = "ap.createdAt asc";
                    // else if ($ascDesc[0] == "fa fa-sort-down") $orderby = "em.createdAt desc";
                    // if ($ascDesc[1] == "fas fa-sort-up") $orderby = "date_retained asc";
                    // else if ($ascDesc[1] == "fas fa-sort-down") $orderby = "date_retained desc";
                }

                if (!empty($searchFields)) { // Count fields full
                    for ($i = 0; $i < count($searchFields); $i++) if ($searchFields[$i] != "") $countField++;
                }

                if ($countField > 0) {
                    $fielDB = array(
                        0 => array("apDetailsId", 'equal'),
                        1 =>  array("createdAt", 'date'),
                        2 => array("ap.apTypeId", 'equal'),
                        // 3 =>  array("em.departmentId", 'equal'),
                        // 4 =>  array("p.positionName", 'like'),
                        // 5 =>  array("em.status", 'equal'),
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
                                //$searchQuery .= $this->build_search_query($value, $fieldSearch);
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
                $searchQuery .=  (!empty($searchQuery)) ? ' and ( badge=' . $badge . ' )' : 'badge=' . $badge . '';

                $return['searchQuery'] = $searchQuery;
                $countTotal = $this->apModel->countPersonalAPs($searchQuery);
                $numrows = $countTotal['numrows'];
                $total_pages = ceil($numrows / $per_page);
                $registers = $this->apModel->readPersonalAPs($offset, $per_page, $searchQuery, $orderby);

                $return['data'] = $registers;
                $return['offsetnumShow'] = $offsetnumShow;
                $return['offset'] = $offset;
                $return['numrows'] = $numrows;
                $return['pagination'] = paginateRead('index.php', $page, $total_pages, 2, $searchFields, $length, $ascDesc);

                echo json_encode($return);
            }
        }
    }

    public function getRecordAPId()
    {

        $apDetailsId = $_POST['apDetailsId'];
        $badge = $this->userModel->getBadgeByUserId($_SESSION['userId']);
        $returnMessage = ['status' => false, 'message' => '', 'data' => array()];


        if (!empty($apDetailsId) and !empty($badge)) {
            $record = $this->apModel->getAPByBadgeId($apDetailsId, $badge);

            if (!empty($record)) {
                $returnMessage['status'] = true;
                $returnMessage['data'] = $record;

                if (!empty($record['scheduleId'])) {
                    $returnMessage['dataScheduleLast'] = $this->employeeScheduleModel->getEmployeeSchedulebyId($record['scheduleId']);;
                }
            }
        } else {
            $returnMessage['message'] = 'There are fields required.';
        }

        echo json_encode($returnMessage);
    }
}

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Reports extends Controller
{
    private $apModel = '';
    private $employeeModel = '';
    // public $phpspreadsheet = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auths/index');
        }

        $this->apModel = $this->model('Ap');
        $this->employeeModel = $this->model('Employee');

        // $this->phpspreadsheet = new PHPSpreadSheet_Lib();
    }

    public function index()
    {

        if (getPLReports()) {
            $data = [];
            $data['apTypes'] = $this->apModel->getAllApTypes();
            $this->view('reports/index', $data);
        } else {
            redirect(''); // Dashboard
        }
    }

    public function exportEmployeesByStatus()
    {
        $status = $_POST["employee_status"];
        $billTo = $_POST["employee_billTo"];

        // BILL TO
        if (getPLAnotherBillTo()){
            $idBillTo =  (!empty($billTo)) ? $billTo : 1; // surgepays
        }else {
            $idBillTo = 1; // surgepays
        }

        
        // $s = ($status == 2) ? null : $status;
        $employees = $this->employeeModel->getEmployeesByStatus($status,$idBillTo);
        echo json_encode($employees);
    }

    public function exportApsByFilters()
    {
        $dates = $_POST["date_range"];
        $exploded_dates = explode(" - ", $dates);
        $b_date = str_replace("/", "-", $exploded_dates[0]);
        $f_date = str_replace("/", "-", $exploded_dates[1]);

        $filters = [
            "apTypeId" => (isset($_POST["ap_type"]) && $_POST["ap_type"]) ? $_POST["ap_type"] : "",
            "aprovedByHR" => (isset($_POST["ap_approval_option"]) && $_POST["ap_approval_option"]) ? $_POST["ap_approval_option"] : "",
            "b_date" => $b_date,
            "f_date" => $f_date
        ];
        
        $aps = $this->apModel->getApsByFilters($filters);
        echo json_encode($aps);
    }
}

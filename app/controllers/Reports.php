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
}

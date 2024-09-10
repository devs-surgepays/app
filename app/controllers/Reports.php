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
        $data = [];
        $data['apTypes'] = $this->apModel->getAllApTypes();
        $this->view('reports/index', $data);
    }

    public function exportEmployeesByStatus()
    {
        $status = $_POST["employee_status"];
        $employees = $this->employeeModel->getEmployeesByStatus($status);
        echo json_encode($employees);
    }
}

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPROOT . '/libraries/email/vendor/autoload.php';

class DocumentsRequests extends Controller
{
    private $documentRequestModel;
    private $employeeModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->documentRequestModel = $this->model('DocumentRequest');
        $this->employeeModel = $this->model('Employee');
    }

    public function index()
    {
        $data = [];
        $this->view('documents_requests/index', $data);
    }

    public function indexHR()
    {
        $data = [];

        if (getPLRequests()) {
            $this->view('documents_requests/hr', $data);
        } else {
            $this->view('documents_requests/index', $data);
        }
    }

    public function getEmployeeDocumentsRequests()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $employeeId = trim($_POST['employeeId']);
            $requests = $this->documentRequestModel->getDocumentsRequestsByEmployeeId($employeeId);
            echo json_encode($requests);
        }
    }

    public function getDocumentsRequests()
    {
        $filters = $_POST;
        $requests = $this->documentRequestModel->getDocumentsRequests($filters);
        echo json_encode($requests);
    }

    public function saveDocumentRequest($data)
    {
        $requestId = $this->documentRequestModel->saveDocumentRequest($data);
        return $requestId;
    }

    public function getEmployeeInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $employeeId = trim($_POST['employeeId']);
            $employee_row = $this->employeeModel->getNameAndBadgeByIdEmp($employeeId);
            $employee = $this->employeeModel->getEmployeeReadByBadge($employee_row["badge"]);
            echo json_encode($employee);
        }
    }

    public function sendEmailWithAttachment()
    {
        if (!isset($_FILES['document'])) {
            echo json_encode(['success' => false, 'message' => 'No document uploaded']);
            return;
        }

        if(!isset($_POST['employee']) || empty($_POST['employee']) || !isset($_POST['employeeId']) || empty($_POST['employeeId'])) {
            echo json_encode(['success' => false, 'message' => 'Missing employee information']);
            return;
        }

        $tmpFile = $_FILES['document']['tmp_name'];
        $fileName = $_FILES['document']['name'];
  
        $employee = $_POST['employee'];
        $employeeId = $_POST['employeeId'];
        $documentType = $_POST['documentType'];

        $requestId = $this->saveDocumentRequest([
            'employeeId' => $employeeId,
            'documentType' => $documentType
        ]);

        if($requestId === false){
            echo json_encode(['success' => false, 'message' => 'Error saving document request']);
            return;

        }

        $mail = new PHPMailer();

        try {
           
			$mail->isSMTP();
			$mail->Host       = 'smtp.office365.com';  	
			$mail->SMTPAuth   = true;          
            $mail->Username   = 'notifications@surgepays.com';     
            $mail->Password   = 'l7R!w$1K2l';
			$mail->SMTPSecure = 'tls';       
			$mail->Port       = 587; 	
			$mail->CharSet = 'UTF-8';


            $mail->setFrom("notifications@surgepays.com", "HR Surgepays Platform");
            $mail->addAddress("hrdocuments@surgepays.com");
            $mail->addBCC("cnerio@surgepays.com");
            // $mail->addCC("cnerio@surgepays.com");

            $mail->Subject = "Document Request #$requestId";
            $mail->Body = "Generated Document for Employee: $employee" . "\n\n" . "The generated Word document is attached.";

            // Attach received file
            $mail->addAttachment($tmpFile, $fileName);

            if ($mail->send()) {
                echo "Email sent successfully!";
            } else {
                echo "Mail error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function markAsPrinted()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requestId = trim($_POST['requestId']);
            $this->documentRequestModel->markAsPrinted($requestId);
            echo json_encode(['success' => true]);
        }
    }
}

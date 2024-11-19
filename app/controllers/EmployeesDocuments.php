<?php

class EmployeesDocuments extends Controller
{
    private $employeeDocumentModel = '';
    private $employeeModel = '';
    private $activityLogModel = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->employeeDocumentModel = $this->model('EmployeeDocument');
        $this->employeeModel = $this->model('Employee');
        $this->activityLogModel = $this->model('ActivityLog');
    }

    public function removeDocument()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $re = ['status' => false, 'message' => ''];

            // Validation - Permission to remove Employee Info
            if (getPLCreateEditDeleteInfoEmployee()) {

                try {

                    $employeeDocumentId = $_POST['employeeDocumentId'];
                    $nameDir = $_POST['nameDir'];

                    $filePath = $_SERVER['DOCUMENT_ROOT'] . "/app/public/documents/{$nameDir}";

                    $re['filePath'] = $filePath;


                    if (file_exists($filePath)) {

                        if (unlink($filePath)) {

                            $dataUpdate = [
                                'employeeDocumentId' => $employeeDocumentId,
                                'status' => 0,
                            ];
                            $this->employeeDocumentModel->updateEmployeeDocument($dataUpdate);

                            // Remove the element with the key 'employeeDocumentId'
                            unset($dataUpdate['employeeDocumentId']);

                            // save log
                            $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $employeeDocumentId, 'action' => 'Delete', 'page' => 'Emp. Document', 'fields' => json_encode($dataUpdate)];
                            $this->activityLogModel->saveActivityLog($dataLog);

                            $re['status'] = true;
                            $re['message'] = 'The Document has been delete successufully!';
                        } else {
                            $re['message'] = "Error deleting the file.";
                        }
                    } else {
                        $re['message'] = "File does not exist.";
                    }
                } catch (Exception $e) {
                    $re['status'] = false;
                    $re['message'] = 'Error ' . $e;
                }
            } else {
                $re['status'] = false;
                $re['message'] = 'Error: You do not have permission to perform this action.';
            }

            echo json_encode($re);
        }
    }

    public function uploadDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $re = ['status' => false, 'message' => '', 'messageDetails' => ''];

            // Validation - Permission to upload Employee Info
            if (getPLCreateEditDeleteInfoEmployee()) {

                try {

                    $dataPost = [
                        'employeeId' => (isset($_POST['idEmpUpload']) && $_POST['idEmpUpload'] != null) ? base64_decode($_POST['idEmpUpload']) : null,
                        'docType' => (isset($_POST['docType']) && $_POST['docType'] != null) ? $_POST['docType'] : null,
                        'fileData' => (isset($_FILES['files']) && $_FILES['files'] != null) ? $_FILES['files'] : null
                    ];

                    // Create name file
                    $infoDocType = $this->employeeDocumentModel->getInfoDocumentTypeById($dataPost['docType']);
                    $infoEmployee = $this->employeeModel->getNameAndBadgeByIdEmp($dataPost['employeeId']);


                    if (!empty($infoDocType) or !empty($infoEmployee)) {

                        $nameDocument = $dataPost['fileData']['name'][0];
                        $sizeDocument = $dataPost['fileData']['size'][0];
                        $tmp_nameDocument = $dataPost['fileData']['tmp_name'][0];

                        if ($dataPost['docType'] == 9) {
                            $nameDocType = $_POST['nameDocumentOther'];
                        } else {
                            $nameDocType = $infoDocType['name'];
                        }

                        // Get name document
                        $folderName = $infoDocType['folderName'];
                        $nameinter = strtolower(str_replace(' ', '_', $nameDocType));
                        $nameFile = $infoEmployee['badge'] . '_' . substr($infoEmployee['firstName'], 0, 1) . substr($infoEmployee['firstLastName'], 0, 1) . '_' . date('mdyhis');
                        $fileExtension = strtolower(pathinfo($nameDocument, PATHINFO_EXTENSION));
                        $nameFinally = $nameFile . '_' . $nameinter . '.' . $fileExtension;


                        // Get dir and maxFileSize
                        $maxFileSize = 5 * 1024 * 1024; // Specify the max file size (e.g., 5MB)
                        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/app/public/documents/{$folderName}/";
                        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true); //directory exists

                        $targetFile = $targetDir . $nameFinally;
                        $re['nameFile'] = $nameFinally;

                        // Upload file
                        if (in_array($fileExtension,  array("jpg", "png", "jpeg", "pdf"))) {

                            if ($sizeDocument <= $maxFileSize) {
                                if (move_uploaded_file($tmp_nameDocument, $targetFile)) {

                                    $datasave = [
                                        'employeeId' => $dataPost['employeeId'],
                                        'documentTypeId' => $dataPost['docType'],
                                        'document' => $nameFinally
                                    ];

                                    // save in database
                                    $lastInsertId = $this->employeeDocumentModel->saveEmployeeDocument($datasave);

                                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $lastInsertId, 'action' => 'Create', 'page' => 'Emp. Document', 'fields' => json_encode($datasave)];
                                    $this->activityLogModel->saveActivityLog($dataLog);


                                    $re['status'] = true;
                                    $re['message'] = 'The document has been upload successfully.';
                                } else {
                                    $re['message'] = 'Sorry, there was an error uploading your file.';
                                }
                            } else {
                                $re['message'] = 'Sorry, your file is too large. Max file size is 5MB.';
                            }
                        } else {
                            $re['message'] = 'Sorry, only jpg, png, jpeg, pdf files are allowed.';
                        }
                    } else {
                        $re['message'] = 'An unexpected error ocurred. Please try again.[GetInfo]';
                    }
                } catch (Exception $e) {
                    $re['message'] = 'Error: ' . $e;
                }
            } else {
                $re['status'] = false;
                $re['message'] = 'Error: You do not have permission to perform this action.';
            }

            echo json_encode($re);
        }
    }
}

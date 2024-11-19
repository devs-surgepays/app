<?php
class FinancialDependents extends Controller
{
    private $financialDependentModel = '';
    private $activityLogModel = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->financialDependentModel = $this->model('FinancialDependent');
        $this->activityLogModel = $this->model('ActivityLog');
    }

    public function index()
    {
        //
    }

    public function getFinancialDependentId()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $financialDependentId = $_POST['financialDependentId'];
            $infoFinancial = $this->financialDependentModel->getInfofinancialDependentId($financialDependentId);
            echo json_encode($infoFinancial);
        }
    }

    public function addFinancialDependent()
    {
        $return = ['status' => false, 'message' => '', 'messageDetails' => ''];

        // Validation - Permission to add Employee Info
        if (getPLCreateEditDeleteInfoEmployee()) {

            try {
                $datasave = [
                    'employeeId' => (isset($_POST['idEmpDependents']) && $_POST['idEmpDependents'] != null) ? base64_decode($_POST['idEmpDependents']) : null,
                    'fullName' => (isset($_POST['fullNameDependent']) && $_POST['fullNameDependent'] != null) ? $_POST['fullNameDependent'] : null,
                    'relationshipId' => (isset($_POST['relationshipIdDependent']) && $_POST['relationshipIdDependent'] != null) ? $_POST['relationshipIdDependent'] : null,
                    // 'dob' => (isset($_POST['dobdependent']) && $_POST['dobdependent'] != null) ? $_POST['dobdependent'] : null,
                    'address' => (isset($_POST['addressDependet']) && $_POST['addressDependet'] != null) ? $_POST['addressDependet'] : null,
                    'age' => (isset($_POST['ageDependent']) && $_POST['ageDependent'] != null) ? $_POST['ageDependent'] : null,
                ];

                $lastInsert = $this->financialDependentModel->saveFinancialDependent($datasave);

                if (!empty($lastInsert)) {
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $lastInsert, 'action' => 'Create', 'page' => 'Financial Dependent', 'fields' => json_encode($datasave)];
                    $this->activityLogModel->saveActivityLog($dataLog);
                    $return['status'] = true;
                    $return['message'] = 'The record has been created successfully!';
                } else {
                    $return['message'] = 'An unexpected error ocurred. Please try again';
                }
            } catch (Exception $e) {
                $return['message'] = 'Error: ' . $e;
            }
        } else {
            $return['message'] = 'Error: You do not have permission to perform this action.';
        }

        echo json_encode($return);
    }

    public function editFinancialDependent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $return = ['status' => false, 'message' => ''];

            // Validation - Permission to edit Employee Info
            if (getPLCreateEditDeleteInfoEmployee()) {

                try {
                    $financialDependentId = $_POST['financialDependentId_dependentEdit'];

                    if (!empty($financialDependentId)) {

                        $data = [
                            'financialDependentId' => $financialDependentId,
                            'fullName' => $_POST['fullName_dependentEdit'],
                            'relationshipId' => $_POST['relationshipId_dependentEdit'],
                            // 'dob' => $_POST['dob_dependentEdit'],
                            'address' => $_POST['address_dependentEdit'],
                            'age' => $_POST['age_dependentEdit'],
                            'changedFields' => $_POST['changedFields']
                        ];

                        $dataUpdate = [
                            'financialDependentId' => $data['financialDependentId'],
                            'fullName' => $data['fullName'],
                            'relationshipId' => $data['relationshipId'],
                            // 'dob' => $data['dob'],
                            'address' => $data['address'],
                            'age' => $data['age'],
                        ];
                        // clean fields for log
                        $aChangeFields = json_decode($data['changedFields'], true);
                        $modifiedData = [];
                        foreach ($aChangeFields as $key => $value) {
                            $newKey = str_replace('_dependentEdit', '', $key);
                            $modifiedData[$newKey] = $value;
                        }
                        // save info
                        $this->financialDependentModel->updateFinancialDependent($dataUpdate);

                        // save log
                        $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $data['financialDependentId'], 'action' => 'Edit', 'page' => 'Financial Dependent', 'fields' => json_encode($modifiedData)];
                        $this->activityLogModel->saveActivityLog($dataLog);
                        $return['status'] = true;
                        $return['message'] = 'Record has been updated successfully!';
                    } else {
                        $return['message'] = 'An unexpected error ocurred. Please try again.';
                    }
                } catch (Exception $e) {
                    $return['message'] = 'Error: ' . $e;
                }
            } else {
                $return['message'] = 'Error: You do not have permission to perform this action.';
            }



            echo json_encode($return);
        }
    }

    public function removeFinancialDependent()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $re = ['status' => false, 'message' => ''];

            // Validation - Permission to remove Employee Info
            if (getPLCreateEditDeleteInfoEmployee()) {

                try {
                    $financialDependentId = $_POST['idFinancialDependent'];
                    $dataUpdate = [
                        'financialDependentId' => $financialDependentId,
                        'status' => 0,
                    ];
                    $this->financialDependentModel->updateFinancialDependent($dataUpdate);

                    // Remove the element with the key 'financialDependentId'
                    unset($dataUpdate['financialDependentId']);

                    // save log
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $financialDependentId, 'action' => 'Delete', 'page' => 'Financial Dependent', 'fields' => json_encode($dataUpdate)];
                    $this->activityLogModel->saveActivityLog($dataLog);

                    $re['status'] = true;
                    $re['message'] = 'The Financial Dependent has been delete successufully!';
                } catch (Exception $e) {
                    $re['status'] = false;
                    $re['message'] = 'Error ' . $e;
                }
            } else {
                $re['message'] = 'Error: You do not have permission to perform this action.';
            }


            echo json_encode($re);
        }
    }
}

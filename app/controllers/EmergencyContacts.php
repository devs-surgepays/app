<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
class EmergencyContacts extends Controller
{

    private $emergencyContactModel = '';
    private $activityLogModel = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auths/index');
        }

        $this->emergencyContactModel = $this->model('EmergencyContact');
        $this->activityLogModel = $this->model('ActivityLog');
    }

    public function index()
    {
        //
    }
    public function saveEmergContact()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $return = ['status' => false, 'message' => '', 'messageDetails' => ''];
            try {

                $datasave = [
                    'employeeId' => (isset($_POST['idEmpEmergContact']) && $_POST['idEmpEmergContact'] != null) ? base64_decode($_POST['idEmpEmergContact']) : null,
                    'fullName' => (isset($_POST['fullName']) && $_POST['fullName'] != null) ? $_POST['fullName'] : null,
                    'contactPhone' => (isset($_POST['contactPhoneEmerContact']) && $_POST['contactPhoneEmerContact'] != null) ? preg_replace('/[^0-9]/', '', $_POST['contactPhoneEmerContact']) : null,
                    'email' => (isset($_POST['emailEmergContact']) && $_POST['emailEmergContact'] != null) ? $_POST['emailEmergContact'] : null,
                    'relationshipId' => (isset($_POST['relationshipId']) && $_POST['relationshipId'] != null) ? $_POST['relationshipId'] : null,
                ];

                // print('<pre>'.print_r($datasave,true).'</pre>');

                $lastInsert = $this->emergencyContactModel->saveEmergContact($datasave);

                if (!empty($lastInsert)) {
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $lastInsert, 'action' => 'Create', 'page' => 'Emerg. Contacts', 'fields' => json_encode($datasave)];
                    $this->activityLogModel->saveActivityLog($dataLog);
                    $return['status'] = true;
                    $return['message'] = 'The record has been created successfully!';
                } else {
                    $return['message'] = 'An unexpected error ocurred. Please try again';
                }
            } catch (Exception $e) {
                $return['message'] = 'Error: ' . $e;
            }

            echo json_encode($return);
        }
    }

    public function editEmergContact()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $return = ['status' => false, 'message' => ''];

            try {
                $idEmpEmergContact = $_POST['idEmpEmergContact_edit'];

                if (!empty($idEmpEmergContact)) {

                    $data = [
                        'emergencyContactId' => $idEmpEmergContact,
                        'fullName' => $_POST['fullName_edit'],
                        'contactPhone' => preg_replace('/[^0-9]/', '', $_POST['contactPhone_edit']),
                        'relationshipId' => $_POST['relationshipId_edit'],
                        'email' => $_POST['email_edit'],
                        'changedFields' => $_POST['changedFields']
                    ];

                    $dataUpdate = [
                        'emergencyContactId' => $data['emergencyContactId'],
                        'fullName' => $data['fullName'],
                        'contactPhone' => $data['contactPhone'],
                        'relationshipId' => $data['relationshipId'],
                        'email' => $data['email']
                    ];

                    // clean fields for log
                    $aChangeFields = json_decode($data['changedFields'], true);
                    $modifiedData = [];
                    foreach ($aChangeFields as $key => $value) {
                        $newKey = str_replace('_edit', '', $key);
                        $modifiedData[$newKey] = $value;
                    }
                    // save info
                    $this->emergencyContactModel->updateEmergeContact($dataUpdate);

                    // save log
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $data['emergencyContactId'], 'action' => 'Edit', 'page' => 'Emerg. Contacts', 'fields' => json_encode($modifiedData)];
                    $this->activityLogModel->saveActivityLog($dataLog);
                    $return['status']=true;
                    $return['message'] = 'Record has been created successfully!';

                } else {
                    $return['message'] = 'An unexpected error ocurred. Please try again.';
                }
            } catch (Exception $e) {
                $return['message'] = 'Error: '.$e;
            }

            echo json_encode($return);
        }
    }
    public function removeEmergContact()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            try {

                $re = ['status' => false, 'message' => ''];

                $emergencyContactId = $_POST['idEmergencyContact'];

                $dataUpdate = [
                    'emergencyContactId' => $emergencyContactId,
                    'status' => 0,
                ];
                $this->emergencyContactModel->updateEmergeContact($dataUpdate);

                // save log
                $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $emergencyContactId, 'action' => 'Delete', 'page' => 'Emerg. Contacts', 'fields' => json_encode($dataUpdate)];
                $this->activityLogModel->saveActivityLog($dataLog);

                $re['status'] = true;
                $re['message'] = 'The User has been delete successufully!';
            } catch (Exception $e) {
                $re['status'] = false;
                $re['message'] = 'Error ' . $e;
            }

            echo json_encode($re);
        }
    }

    public function getInfoEmergeContactId()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $emergencyContactId = $_POST['emergencyContactId'];

            $infoEmergencyContact = $this->emergencyContactModel->getInfoEmergencyContactId($emergencyContactId);

            echo json_encode($infoEmergencyContact);

            // try {
            //     $returnMessage = ['status' => false, 'message' => ''];


            //     if (!empty($emergencyContactId)) {



            //     } else {
            //         $return['message'] = 'An unexpected error ocurred. Please try again.';
            //     }
            // } catch (Exception $e) {
            //     $return['message'] = 'Error: '.$e;

            // }
        }
    }
}

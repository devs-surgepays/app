<?php
class Users extends Controller
{

    public $userModel = "";
    public $employeeModel = "";
    private $activityLogModel = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->userModel = $this->model('User');
        $this->employeeModel = $this->model('Employee');
        $this->activityLogModel = $this->model('ActivityLog');
    }

    public function index()
    {
        if (getPLUsers()) {
            $data['users'] = $this->userModel->getUsers();
            $data['permissions_levels'] = $this->userModel->getpermissions_levels();
            $this->view('users/index', $data);
        } else {
            redirect(''); // Dashboard
        }
    }

    public function createUserProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $re = ['status' => false, 'message' => ''];

            try {

                $data = [
                    'badge' => $_POST['badge'],
                    'username' => $_POST['username'],
                    'firstName' => $_POST['firstName'],
                    'firstLastName' => $_POST['firstLastName'],
                    'permissionLevelId' => $_POST['permissionLevelId'],
                    'externalPersonal' => @$_POST['externalPersonal'],
                ];

                if (!$this->userModel->userExists($data['username'])) {

                    if ($data['externalPersonal'] == "Yes") {
                        // Persona Externa
                        $employeeId = 0;
                        $firstName = $data['firstName'];
                        $firstLastName = $data['firstLastName'];
                        $permissionLevel = 256;
                    } else {
                        $employeeInfo = $this->employeeModel->getEmployeeByBadge($data['badge']);
                        $employeeId = $employeeInfo['employeeId'];
                        $firstName = null;
                        $firstLastName = null;
                        $permissionLevel = $data['permissionLevelId'];
                    }
                    // Insert
                    $dataUser = [
                        'username' => $data['username'],
                        'password' => password_hash('pass123', PASSWORD_DEFAULT),
                        'employeeId' => $employeeId,
                        'firstName' => $firstName,
                        'firstLastName' => $firstLastName,
                        'permissionLevelId' => $permissionLevel,
                        'token' => md5(uniqid(rand(), true))
                    ];
                    $lastUserId = $this->userModel->createUser($dataUser);
                    //echo "lastUserId " . $lastUserId;

                    // Save log 
                    $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $lastUserId, 'action' => 'Create', 'page' => 'User', 'fields' => json_encode($dataUser)];
                    $this->activityLogModel->saveActivityLog($dataLog);

                    // echo 'done';
                    $re['status'] = true;
                    $re['message'] = 'The User has been create successfully added.';
                } else {
                    $re['status'] = false;
                    $re['message'] = "Email Address Already Exists";
                }
            } catch (Exception $e) {
                $re['status'] = false;
                $re['message'] = "Error: " . $e;
            }

            echo json_encode($re);
        }
    }

    public function GetInformationUser()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_POST['idUser'];
            $userData = $this->userModel->getUserId($userId);

            $dta = [
                'userId' => $userData['userId'],
                'username' => $userData['username'],
                'firstName' => $userData['FirstName'],
                'firstLastName' => $userData['FirstLastName'],
                'permissionLevelId' => $userData['permissionLevelId'],
                'employeeId' => $userData['employeeId'],
                'badge' => $userData['badge'],
            ];
            // Get permission json
            $dta['jsonPermissionLevelId'] = $this->userModel->getpermissionsLevelsId($dta['permissionLevelId']);


            echo json_encode($dta);
        }
    }

    public function editUserProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            try {

                $re = ['status' => false, 'message' => ''];
                $permissions = 0;
                $data = [
                    'userIdEdit' => $_POST['userIdEdit'],
                    'externalPersonal' => @$_POST['externalPersonal_edit'],
                    'firstName' => (isset($_POST['firstName_edit']) && $_POST['firstName_edit'] != NULL) ? ucfirst(strtolower($_POST['firstName_edit'])) : null,
                    'firstLastName' => (isset($_POST['firstLastName_edit']) && $_POST['firstLastName_edit'] != NULL) ? ucfirst(strtolower($_POST['firstLastName_edit'])) : null,
                    'username' => $_POST['username_edit'],
                    'permissionLevelId' => $_POST['permissionLevelId_edit'],
                    'changePasswordCheckbox' => @$_POST['changePasswordCheckbox'],
                    'password' => @$_POST['password'],
                    'changedFields' => $_POST['changedFields'],
                ];


                // get External Personal

                if ($this->userModel->checkExternalPerson($data['userIdEdit'])) {
                    $permissions = 256;
                } else {
                    foreach ($data['permissionLevelId'] as $key => $up) {
                        $permissions += $up;
                    }
                }

                $dataUpdate = [
                    'userId' => $data['userIdEdit'],
                    'username' => $data['username'],
                    'firstName' => $data['firstName'],
                    'firstLastName' => $data['firstLastName'],
                    'permissionLevelId' => $permissions,
                ];

                // clean fields for log
                $aChangeFields = json_decode($data['changedFields'], true);
                $modifiedData = [];
                foreach ($aChangeFields as $key => $value) {
                    $newKey = str_replace('_edit', '', $key);
                    $modifiedData[$newKey] = $value;
                }

                if ($data['changePasswordCheckbox'] == 'Yes') {
                    $dataUpdate['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $dataUpdate['token'] = md5(uniqid(rand(), true));
                    $modifiedData['password'] = $dataUpdate['password']; // encript password log
                }
                $this->userModel->updatedUser($dataUpdate);

                // save log
                $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $data['userIdEdit'], 'action' => 'Edit', 'page' => 'User', 'fields' => json_encode($modifiedData)];
                $this->activityLogModel->saveActivityLog($dataLog);

                $re['status'] = true;
                $re['message'] = 'The User has been updated successufully!';
            } catch (Exception $e) {
                $re['status'] = false;
                $re['message'] = 'Error ' . $e;
            }

            echo json_encode($re);
        }
    }

    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            try {

                $re = ['status' => false, 'message' => ''];

                $idUser = $_POST['idUser'];

                $dataUpdate = [
                    'userId' => $idUser,
                    'status' => 0,
                ];
                $this->userModel->updatedUser($dataUpdate);

                // save log
                $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $idUser, 'action' => 'Delete', 'page' => 'User', 'fields' => json_encode($dataUpdate)];
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
}

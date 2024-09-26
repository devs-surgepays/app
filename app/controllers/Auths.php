<?php
class Auths extends Controller
{
    public $userModel = "";

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => ''
        ];
        $this->view('auth/login', $data);
    }


    public function login()
    {
        //Init Data
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get data from POST
            $data['email'] = trim($_POST['email']);
            $data['password'] = trim($_POST['password']);

            // form empty
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Find email
                if (!$this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Invalid Email ';
                }
            }
            if (empty($data['password']))
                $data['password_err'] = 'Please enter a password';

            if (empty($data['email_err']) && empty($data['password_err'])) {


                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {

                    if ($loggedInUser->firstLogin == 1) {

                        $token = md5(uniqid(rand(), true));
                        $this->userModel->saveToken($loggedInUser->userId, $token); // save token

                        redirect('auths/changePass/' . $token);
                    } else if (!empty($loggedInUser->token)) {
                        redirect('auths/changePass/' . $loggedInUser->token);
                    } else {
                        $this->createUserSession($loggedInUser);
                    }
                } else {
                    $data['password_err'] = 'Password Incorrect.';
                    $this->view('auth/login', $data);
                }
            } else {
                $this->view('auth/login', $data);
            }
        } else {
            $this->view('auth/login', $data);
        }
    }

    function processChangePassword($token = null)
    {
        $data = [
            'pass' => '',
            'passwordConfirmation' => '',
            'password_err' => '',
            'status' => false
        ];


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'pass' => $_POST['password'],
                'passwordConfirmation' => $_POST['passwordConfirmation'],
                'token' => $_POST['token'],
                'password_err' => '',
                'passwordConfirmation_err' => '',
            ];

            if (empty($data['pass'])) {
                $data['password_err'] = 'Please enter password';
            }
            if (empty($data['passwordConfirmation'])) {
                $data['passwordConfirmation_err'] = 'Please enter Confirm Password';
            }

            if (empty($data['password_err']) and empty($data['passwordConfirmation_err'])) {
                if ($data['pass'] != $data['passwordConfirmation']) {
                    $data['passwordConfirmation_err'] = 'The password confirmation does not match.';
                }
            }

            if (empty($data['passwordConfirmation_err'])) {
                if (!empty($data['token'])) {

                    $getUserByToken = $this->userModel->getUserByToken($data['token']); // GET USER BY TOKE

                    if (!empty($getUserByToken)) {
                        $dataUpdate = [
                            'userId' => $getUserByToken['userId'],
                            'token' => null,
                            'firstLogin' => 0,
                            'password' => password_hash($data['pass'], PASSWORD_DEFAULT)
                        ];
                        $this->userModel->updateChangePass($dataUpdate);

                        $data['status'] = true;

                        $getUser = $this->userModel->getUserById($getUserByToken['userId']);
                        $this->createUserSession($getUser, false);
                    } else {
                        redirect('auths/login/tokenInvalid');
                    }
                } else {
                    redirect('auths/login/tokenInvalid');
                }
            }
        }
        echo json_encode($data);
    }

    public function changePass($token = null)
    {
        if (!empty($token)) {

            $getUserByToken = $this->userModel->getUserByToken($token); // GET USER BY TOKE

            if (!empty($getUserByToken)) {
                $data['token'] = $token;
                $this->view('auth/changePassword', $data);
            } else {
                redirect('auths/login/tokenInvalid');
            }
        } else {
            redirect('auths/login/tokenInvalid');
        }
    }


    //setting user section variable
    public function createUserSession($user, $redirect = true)
    {
        $_SESSION['userId'] = $user->userId;
        $_SESSION['username'] = $user->username;
        $_SESSION['employeeId'] = $user->employeeId;
        $names = explode('@', $user->username);
        $name =  (!empty($names)) ? $names[0] : '-';
        $_SESSION['name'] = $name;
        $_SESSION['permissionLevelId'] = $user->permissionLevelId;
        $_SESSION['LAST_ACTIVITY'] = time();

        if ($redirect) redirect('pages/index');
    }

    //logout and destroy user session
    public function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['username']);
        unset($_SESSION['employeeId']);
        session_destroy();
        redirect('auths/login');
    }

    /*  Cada vez que el usuario interactúe con la aplicación (controladores/constructor), se actualizará LAST_ACTIVITY. 
        La función checkSession se llamará cada minuto para verificar la actividad de la sesión.
        Si el usuario deja de usar la aplicación durante más de 30 minutos, se les redirigirá a la página de inicio de sesión.
    */
    public function checkSession()
    {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] >= 3600)) { // 1800 segundos - 30 minutos
            $LAST_ACTIVITY = $_SESSION['LAST_ACTIVITY'];

            session_unset(); // Elimina las variables de sesión
            session_destroy();
            echo json_encode(['session_active' => 'inactivity', 'timeInactivity' => time() - $LAST_ACTIVITY]); // Indicar que la sesión no está activa
            exit();
        }
        echo json_encode(['session_active' => 'active', 'timeInactivity' => time() - $_SESSION['LAST_ACTIVITY']]);
    }
}

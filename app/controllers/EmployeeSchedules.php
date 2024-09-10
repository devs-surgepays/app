<?php

class EmployeeSchedules extends Controller
{
    private $employeeScheduleModel = '';
    private $activityLogModel = '';

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->employeeScheduleModel = $this->model('EmployeeSchedule');
        $this->activityLogModel = $this->model('ActivityLog');
    }

    public function saveschedule()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $return = ['status' => false, 'message' => ''];

            try {

                $mondayFrom = (isset($_POST['mondayFrom']) && $_POST['mondayFrom'] != NULL) ? $_POST['mondayFrom'] : null;
                $mondayTo = (isset($_POST['mondayTo']) && $_POST['mondayTo'] != NULL) ? $_POST['mondayTo'] : null;
                $mondayH = (isset($_POST['mondayH']) && $_POST['mondayH'] != NULL) ? $_POST['mondayH'] : 1;

                $tuesdayFrom = (isset($_POST['tuesdayFrom']) && $_POST['tuesdayFrom'] != NULL) ? $_POST['tuesdayFrom'] : null;
                $tuesdayTo = (isset($_POST['tuesdayTo']) && $_POST['tuesdayTo'] != NULL) ? $_POST['tuesdayTo'] : null;
                $tuesdayH = (isset($_POST['tuesdayH']) && $_POST['tuesdayH'] != NULL) ? $_POST['tuesdayH'] : 1;

                $wednesdayFrom = (isset($_POST['wednesdayFrom']) && $_POST['wednesdayFrom'] != NULL) ? $_POST['wednesdayFrom'] : null;
                $wednesdayTo = (isset($_POST['wednesdayTo']) && $_POST['wednesdayTo'] != NULL) ? $_POST['wednesdayTo'] : null;
                $wednesdayH = (isset($_POST['wednesdayH']) && $_POST['wednesdayH'] != NULL) ? $_POST['wednesdayH'] : 1;

                $thursdayFrom = (isset($_POST['thursdayFrom']) && $_POST['thursdayFrom'] != NULL) ? $_POST['thursdayFrom'] : null;
                $thursdayTo = (isset($_POST['thursdayTo']) && $_POST['thursdayTo'] != NULL) ? $_POST['thursdayTo'] : null;
                $thursdayH = (isset($_POST['thursdayH']) && $_POST['thursdayH'] != NULL) ? $_POST['thursdayH'] : 1;

                $fridayFrom = (isset($_POST['fridayFrom']) && $_POST['fridayFrom'] != NULL) ? $_POST['fridayFrom'] : null;
                $fridayTo = (isset($_POST['fridayTo']) && $_POST['fridayTo'] != NULL) ? $_POST['fridayTo'] : null;
                $fridayH = (isset($_POST['fridayH']) && $_POST['fridayH'] != NULL) ? $_POST['fridayH'] : 1;

                $saturdayFrom = (isset($_POST['saturdayFrom']) && $_POST['saturdayFrom'] != NULL) ? $_POST['saturdayFrom'] : null;
                $saturdayTo = (isset($_POST['saturdayTo']) && $_POST['saturdayTo'] != NULL) ? $_POST['saturdayTo'] : null;
                $saturdayH = (isset($_POST['saturdayH']) && $_POST['saturdayH'] != NULL) ? $_POST['saturdayH'] : 1;

                $sundayFrom = (isset($_POST['sundayFrom']) && $_POST['sundayFrom'] != NULL) ? $_POST['sundayFrom'] : null;
                $sundayTo = (isset($_POST['sundayTo']) && $_POST['sundayTo'] != NULL) ? $_POST['sundayTo'] : null;
                $sundayH = (isset($_POST['sundayH']) && $_POST['sundayH'] != NULL) ? $_POST['sundayH'] : 1;

                // idEmp
                $employeeId  = (isset($_POST['idEmp']) && $_POST['idEmp'] != NULL) ? base64_decode($_POST['idEmp']) : null;

                if (!empty($employeeId)) {

                    $dataSchedule = [
                        'monday' => $monday = $this->checkOFFDay($mondayFrom, $mondayTo),
                        'mondayLunch' => ($monday == '-OFF-') ? '-OFF-' : $mondayH . 'H',

                        'tuesday' => $tuesday = $this->checkOFFDay($tuesdayFrom, $tuesdayTo),
                        'tuesdayLunch' => ($tuesday == '-OFF-') ? '-OFF-' : $tuesdayH . 'H',

                        'wednesday' => $wednesday = $this->checkOFFDay($wednesdayFrom, $wednesdayTo),
                        'wednesdayLunch' => ($wednesday == '-OFF-') ? '-OFF-' : $wednesdayH . 'H',

                        'thursday' => $thursday = $this->checkOFFDay($thursdayFrom, $thursdayTo),
                        'thursdayLunch' => ($thursday == '-OFF-') ? '-OFF-' : $thursdayH . 'H',

                        'friday' => $friday = $this->checkOFFDay($fridayFrom, $fridayTo),
                        'fridayLunch' => ($friday == '-OFF-') ? '-OFF-' : $fridayH . 'H',

                        'saturday' => $saturday = $this->checkOFFDay($saturdayFrom, $saturdayTo),
                        'saturdayLunch' => ($saturday == '-OFF-') ? '-OFF-' : $saturdayH . 'H',

                        'sunday' => $sunday = $this->checkOFFDay($sundayFrom, $sundayTo),
                        'sundayLunch' => ($sunday == '-OFF-') ? '-OFF-' : $sundayH . 'H'
                    ];

                    $daysOFF = $this->getDays($dataSchedule);
                    $dataSchedule['days'] = $daysOFF['days'];
                    $dataSchedule['daysOFF'] = $daysOFF['daysOFF'];

                    $dataSchedule['employeeId'] = $employeeId;
                    $dataSchedule['status'] = 1;

                    $lastScheduleInsertId = $this->employeeScheduleModel->saveEmployeeSchedule($dataSchedule);

                    if (!empty($lastScheduleInsertId)) {
                        // Save log 
                        $dataLog = ['userId' => $_SESSION['userId'], 'registerId' => $lastScheduleInsertId, 'action' => 'Create', 'page' => 'Employee Schedule', 'fields' => json_encode($dataSchedule)];
                        $this->activityLogModel->saveActivityLog($dataLog);

                        $return['status'] = true;
                        $return['message'] = 'The record has been created successfully.';
                    } else {
                        $return['message'] = 'An unexpected error occured. Please try again';
                    }
                } else {
                    $return['message'] = 'An unexpected error occured. Please try again';
                }
            } catch (Exception $e) {
                $return['message'] = 'Error: ' . $e;
            }

            echo json_encode($return);
        }
    }

    public function checkOFFDay($from, $to)
    {
        if (!empty($from) and !empty($to)) {
            return $from . ' - ' . $to;
        } else {
            return '-OFF-';
        }
    }

    public function getDays($dataSchedule)
    {
        $daysOFF = ['days' => '', 'daysOFF' => ''];
        $days  = [
            'monday' => ['M', 'MON'],
            'tuesday' => ['T', 'TUE'],
            'wednesday' => ['W', 'WED'],
            'thursday' => ['R', 'THU'],
            'friday' => ['F', 'FRI'],
            'saturday' => ['Y', 'SAT'],
            'sunday' => ['S', 'SUN']
        ];
        foreach ($dataSchedule as $key => $val) {

            if (array_key_exists($key, $days)) { //No Lunch

                if ($val == '-OFF-') {
                    $daysOFF['days'] .= '-';
                    $daysOFF['daysOFF'] .= $days[$key][1] . ' & ';
                } else {
                    $daysOFF['days'] .= $days[$key][0];
                }
            }
        }

        // Quitar la última " & " de daysOFF
        $daysOFF['daysOFF'] = rtrim($daysOFF['daysOFF'], ' & ');

        return $daysOFF;
    }
}

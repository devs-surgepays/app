<?php
class Pages extends Controller
{

  private $employeeModel = '';
  private $employeeScheduleModel = ''; 
  private $usersModel = ''; 

  public function __construct()
  {

    if (!isLoggedIn()) {
      redirect('auths/login');
    }

    $this->employeeModel = $this->model('Employee');
    $this->employeeScheduleModel = $this->model('EmployeeSchedule');
    $this->usersModel = $this->model('User');
  }

  public function index()
  {
    $dayTodayNum = date('N');
    $daysWeek = [
      '1' => 'monday',
      '2' => 'tuesday',
      '3' => 'wednesday',
      '4' => 'thursday',
      '5' => 'friday',
      '6' => 'saturday',
      '7' => 'sunday'
    ];
    $dayToday = $daysWeek[$dayTodayNum];
    $schedules = $this->employeeScheduleModel->getEmployeeWorkingToday($dayToday);

    for ($i = 0; $i < count($schedules); $i++) {
      $dayHour = $schedules[$i][$dayToday];
      $time = explode('-', $dayHour);
      $clockIn = $time[0];
      $clockOut = $time[1];
      $schedules[$i]['clockIn'] = $clockIn;
      $schedules[$i]['clockOut'] = $clockOut;
    }
    usort($schedules, function ($a, $b) {
      return strcmp($a['clockIn'], $b['clockIn']);
    });

    
    // $groupedByDepartment = [];
    // $groupedByDepartmentCount = [];
    // $employeeByDeparment = $this->employeeModel->getEmployeeByDeparment();
    // foreach ($employeeByDeparment as $department) {
    //   array_push($groupedByDepartment,$department['departmentName']);
    //   array_push($groupedByDepartmentCount,$department['totalEmployees']);
    // }

    // count users
    $countUser = $this->usersModel->getUsersActives();

    $data = [
      'employeeTotal' => $this->employeeModel->getTotalEmployeeActive(),
      'employeeWorkingToday' => $schedules,
      'leavesCreatedToday' => 0,
      'tickets' => 0,
      'BirthdaysOfTheMonth' => $this->employeeModel->BirthdaysOfTheMonth(),
      // 'departmentName' => $groupedByDepartment,
      // 'totalEmployeesDepartment' => $groupedByDepartmentCount,
      'totalUsers' => $countUser
    ];

    $this->view('pages/index', $data);
  }

  public function about()
  {
    $data = [
      'title' => 'About Us',
      'description' => 'App to share posts with other users'
    ];

    $this->view('pages/about', $data);
  }

  public function contact()
  {
    $data = [
      'title' => 'Contact Us',
      'description' => 'You can contact us through this medium',
      'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
      'name' => 'Omonzebaguan Emmanuel',
      'location' => 'Nigeria, Edo State',
      'contact' => '+2348147534847',
      'mail' => 'emmizy2015@gmail.com'
    ];

    $this->view('pages/contact', $data);
  }

  public function testPage()
  {
    $data = [
      'title' => 'Contact Us',
      'description' => 'You can contact us through this medium',
      'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
      'name' => 'Omonzebaguan Emmanuel',
      'location' => 'Nigeria, Edo State',
      'contact' => '+2348147534847',
      'mail' => 'emmizy2015@gmail.com'
    ];

    $this->view('pages/testPage', $data);
  }
}

<?php
class User
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUsers()
    {
        $this->db->query("SELECT u.*, if (u.employeeId>0, CONCAT(COALESCE(e.firstName, ''), ' ', COALESCE(e.firstLastName, '')), CONCAT(COALESCE(u.firstName, ''), ' ', COALESCE(u.firstLastName, '')) ) as 'fullname' FROM hr_surgepays.users u
        left JOIN employees e ON u.employeeId = e.employeeId where u.status=1 order by userId desc;");
        $result = $this->db->resultSetAssoc();
        return $result;
    }
    public function getUserId($userId)
    {
        $this->db->query("SELECT u.*, e.badge,
        IF(u.employeeId > 0,e.firstName,u.firstName) as 'FirstName',
        IF(u.employeeId > 0,e.firstLastName,u.firstLastName) as 'FirstLastName' FROM hr_surgepays.users u
        left JOIN employees e ON u.employeeId = e.employeeId where userId  = :userId;");
        $this->db->bind(':userId', $userId);
        $result = $this->db->resultSetFetch();
        return $result;
    }

    public function getpermissions_levels()
    {
        $this->db->query("SELECT * FROM hr_surgepays.permissions_levels where status=1");
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function getpermissionsLevelsId($permissionLevelId){
        $this->db->query("SELECT * FROM hr_surgepays.permissions_levels where permissionLevelId & :permissionLevelId and status=1");
        $this->db->bind(":permissionLevelId", $permissionLevelId);
        $result = $this->db->resultSetAssoc();
        return $result;
    }

    public function createUser($data)
    {
        $insert = $this->db->insertQuery('hr_surgepays.users', $data);
        return $lastinsertedId = $this->db->lastinsertedId();
    }
    public function updatedUser($data)
    {
        $this->db->updateQuery("hr_surgepays.users", $data, "userId=:userId");
    }


    //register new user
    public function register($data)
    {
        $this->db->query('INSERT INTO users (username, password) VALUES (:username, :password)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //find users by email
    public function findUserByEmail($username)
    {
        $this->db->query('SELECT * FROM users WHERE username = :username and status=1');
        $this->db->bind(':username', $username);

        $row = $this->db->singleObj();

        //check the row 
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        $this->db->query('SELECT *,if (employeeId>0, (SELECT areaId FROM hr_surgepays.employees where employeeId=users.employeeId),0) as areaId FROM users where username = :username ');
        $this->db->bind(':username', $email);

        $row = $this->db->singleObj();

        $hash_password = $row->password;

        if (password_verify($password, $hash_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function getUserById($userId)
    {
        $this->db->query('SELECT *,if (employeeId>0, (SELECT areaId FROM hr_surgepays.employees where employeeId=users.employeeId),0) as areaId FROM users WHERE userId = :userId');
        $this->db->bind(':userId', $userId);
        $row = $this->db->singleObj();
        return $row;
    }

    public function saveToken($id, $token)
    {
        $data = [
            'userId' => $id,
            'token' => $token,
        ];
        $this->db->updateQuery('users', $data, 'userId=:userId');
    }

    public function getUserByToken($token)
    {
        $this->db->query('SELECT * FROM users WHERE token = :token');
        $this->db->bind(':token', $token);
        return $row = $this->db->resultSetFetch();
    }

    public function updateChangePass($data)
    {
        $this->db->updateQuery('users', $data, 'userId=:userId');
    }

    public function getSuperiors(){
        $this->db->query("SELECT u.userId, if (u.employeeId>0, CONCAT(COALESCE(e.firstName, ''), ' ', COALESCE(e.firstLastName, '')), CONCAT(COALESCE(u.firstName, ''), ' ', COALESCE(u.firstLastName, '')) ) as 'fullname' FROM hr_surgepays.users u
        left JOIN employees e ON u.employeeId = e.employeeId where u.status=1 and permissionLevelId & 268 order by userId desc;");
        return $row = $this->db->resultSetAssoc();
    }

    public function getUsersActives(){
        $this->db->query("SELECT count(*) as userCount FROM hr_surgepays.users where status = 1;");
        $result = $this->db->resultSetFetch();
        return $result['userCount'];
    }

    public function checkExternalPerson($userId){
        $this->db->query("SELECT employeeId FROM hr_surgepays.users where userId = :userId;");
        $this->db->bind(':userId', $userId);
        $result = $this->db->resultSetFetch();

        if ($result['employeeId']>0) return false;
        else return true;
    }

    public function userExists($email){
        $this->db->query("SELECT count(*) as 'count' FROM hr_surgepays.users where username = :username;");
        $this->db->bind(':username', $email);
        $result = $this->db->resultSetFetch();

        if ($result['count']>0) return true;
        else return false;
    }
}

<?php
class ActivityLog
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function saveActivityLog($data){
        $data = [
            'userId'=>$data['userId'],
            'action'=>$data['action'],
            'page'=>$data['page'],
            'fields'=>$data['fields'],
            'registerId'=>$data['registerId'],
        ];
        $this->db->insertQuery('hr_surgepays.activity_logs', $data);
        $lastInsertId = $this->db->lastinsertedId();
        return $lastInsertId;
    }
}

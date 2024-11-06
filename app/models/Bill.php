<?php

class Bill
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBillsTo() {

        $bill = (!getPLAnotherBillTo()) ? ' and billToId = 1':'';

        $this->db->query("SELECT * FROM hr_surgepays.bills where status=1 $bill ");
        $result = $this->db->resultSetAssoc();
        return $result;
    }
}

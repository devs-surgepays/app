<?php 


/**
 * PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *

 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailer_Lib
{
    public function __construct(){
       // log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPROOT.'/libraries/email/vendor/autoload.php';
        
        $mail = new PHPMailer;
        return $mail;
    }
}
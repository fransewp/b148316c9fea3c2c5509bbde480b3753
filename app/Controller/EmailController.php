<?php

namespace App\Controller;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController extends BaseController {
    public function __construct(){
		parent::__construct();
        // SET MIDDLEWARE FOR THIS MODULE
        $this->middleware();
    }

    // RETRIEVE ALL EMAIL LOGGER
    public function retrieve(){
        $sql = "SELECT * FROM email_logger";
        $data = [];
        foreach ($this->db->query($sql) as $row) {
            $data[] = array(
                'email_logger_id' => $row['email_logger_id'],
                'email_logger_mail_to' => $row['email_logger_mail_to'],
                'email_logger_mail_subject' => $row['email_logger_mail_subject'],
                'email_logger_mail_body' => $row['email_logger_mail_body'],
                'email_logger_created_at' => $row['email_logger_created_at'],
                'email_logger_sent_at' => $row['email_logger_sent_at']
            );
        }
        $response = ["code"=> 1, 'data' => $data];
        echo json_encode($response);
    }

    // SEND EMAIL LOGIC
    public function create()
    {
        // GET DATA
        $data = json_decode(file_get_contents('php://input'), true);
        $idLogger = $this->saveLoggerEmail($data);
        // CHECK INPUT
        if(!isset($data['mail_to'])) {
            echo json_encode(array('code' => -1, 'message' => 'Please Input Receiver Email')); 
            exit;
        }
        if(!isset($data['mail_subject'])) {
            echo json_encode(array('code' => -1, 'message' => 'Please Input Email Subject')); 
            exit;
        }
        if(!isset($data['mail_body'])) {
            echo json_encode(array('code' => -1, 'message' => 'Please Input Email Body')); 
            exit;
        }

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = $_ENV['API_MAIL_HOST'];
        $mail->SMTPDebug = 2;
        $mail->Port = $_ENV['API_MAIL_PORT'];
        $mail->SMTPAuth = true;
        // SET TIMEOUT 
        $mail->Timeout = 60;
        $mail->SMTPKeepAlive = true; 

        $mail->Username = $_ENV['API_MAIL_USERNAME'];
        $mail->Password = $_ENV['API_MAIL_PASSWORD'];
        $mail->SetFrom($_ENV['API_MAIL_FROM_ADDRESS'], $_ENV['API_MAIL_FROM_NAME']);

        $mail->Subject = $data['mail_subject'];
        $mail->AddAddress($data['mail_to']);
        $mail->MsgHTML($data['mail_body']);

        if($mail->Send()) {
            $this->updateLoggerEmail($idLogger);
            echo json_encode(array('code' => 1, 'message' => 'Email has beed sent succesfully'));
        } else {
            echo json_encode(array('code' => -1, 'message' => 'Failed to send email'));
        }
        exit;
    }

    public function saveLoggerEmail($data){
        $processData = $this->db->prepare('INSERT INTO email_logger(email_logger_mail_to, email_logger_mail_subject, email_logger_mail_body, email_logger_created_at) VALUES (:mail_to, :mail_subject, :mail_body, now())');
        $processData->bindValue(':mail_to', $data['mail_to']);
        $processData->bindValue(':mail_subject', $data['mail_subject']);
        $processData->bindValue(':mail_body', $data['mail_body']);
        if($processData->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    public function updateLoggerEmail($id){
        $processData = $this->db->prepare('UPDATE email_logger SET email_logger_sent_at = now() WHERE email_logger_id = :id');
        $processData->bindValue(':id', $id);
        if($processData->execute()){
            return true;
        }else{
            return false;
        }
    }
}
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

class mailer{
    public function dathang($tieude, $noidung, $maildat){
        try {
            $mail = new PHPMailer(true);
            
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testmail512002@gmail.com';
            $mail->Password = 'hzgdixmqrhyrbjxn';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Thêm cấu hình để hỗ trợ tiếng Việt
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom('testmail512002@gmail.com');
            $mail->addAddress($maildat);

            $mail->isHTML(true);
            $mail->Subject = '=?UTF-8?B?'.base64_encode($tieude).'?='; // Mã hóa tiêu đề
            $mail->Body = $noidung;

            $mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
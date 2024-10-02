<?php
namespace Model;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Email {

    public static function enviarConfirmacion($token, $correo, $user) {
        $html = '<!DOCTYPE html><html lang="es"><head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Email</title> <style> body { font-family:"Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif; } h2 { color: #2C2893; font-size: 48px; font-weight: bold; margin: 10px auto; } p { font-weight: 300; line-height: 1.5; margin: 10px auto; } </style></head><body> <h2>UpTask</h2><hr> <p>Bienvenido a UpTask!<br> Para confirmar tu cuenta y seguir usando UpTask porfavor, ingresa el siguiente token: &raquo; <strong>'.$token.'</strong>.<br> <strong><em>UpTask</em></strong></p></body></html>';

        $email = new PHPMailer();
        try {
            $email->isSMTP();
            $email->Host = $_ENV["EMAIL_HOST"];
            $email->SMTPAuth = true;
            $email->Username = $_ENV["EMAIL_USERNAME"];
            $email->Password = $_ENV["EMAIL_PASSWORD"];
            $email->Port = $_ENV["EMAIL_PORT"];
            
            $email->setFrom($_ENV["EMAIL_USERNAME"], "UpTask");
            $email->addAddress($correo, $user);

            $email->isHTML(true);
            $email->Subject = "Confirmacion Cuenta";
            $email->Body = $html;
            $email->AltBody = "Confirma con el siguiente token: ".$token;

            if($email->send()) {
                return true;
            } else {
                return "$email->ErrorInfo $correo";
            }
        }
        catch(Exception $e) {
            return "Error: $email->ErrorInfo";
        }
    }

    public static function enviarReestablecer($token, $correo) {
        $html = '<!DOCTYPE html><html lang="es"><head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Email</title> <style> body { font-family:"Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif; } h2 { color: #2C2893; font-size: 48px; font-weight: bold; margin: 10px auto; } p { font-weight: 300; line-height: 1.5; margin: 10px auto; } </style></head><body> <h2>UpTask</h2><hr> <p>Bienvenido a UpTask!<br> Para reestablecer la contraseña de tu cuenta y seguir usando UpTask porfavor, ingresa el siguiente token: &raquo; <strong>'.$token.'</strong>.<br> <strong><em>UpTask</em></strong></p></body></html>';

        $email = new PHPMailer();
        try {
            $email->isSMTP();
            $email->Host = $_ENV["EMAIL_HOST"];
            $email->SMTPAuth = true;
            $email->Username = $_ENV["EMAIL_USERNAME"];
            $email->Password = $_ENV["EMAIL_PASSWORD"];
            $email->Port = $_ENV["EMAIL_PORT"];
            
            $email->setFrom($_ENV["EMAIL_USERNAME"], "UpTask");
            $email->addAddress($correo);

            $email->isHTML(true);
            $email->Subject = "Reestablecer Cuenta";
            $email->Body = $html;
            $email->AltBody = "Reestablece con el siguiente token: ".$token;

            if($email->send()) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return "Error: $email->ErrorInfo";
        }
    }
}
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "../BackEnd/DBConnection.php";
require_once "../vendor/autoload.php";
class Mail
{
    private $db;
    public function __construct()
    {

        $this->db = new DBConnection();
        $this->db->connect();
    }
    public function sendForgetPasswordMail($email)
    {

        $token = bin2hex(random_bytes(16));
        $tokenHash = hash("sha256", $token);

        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
        $sql = "UPDATE user_account SET reset_token_hash = '$tokenHash', 
            reset_token_expires_at
             = '$expiry' WHERE Email = '$email'";

        $result = mysqli_query($this->db->getConnection(), $sql);

        if (mysqli_affected_rows($this->db->getConnection()) === 0) {
            echo "<script>alert('The email address not found. Please check and try again.')</script>";
            return;
        }
        if (!$result) {
            die("Error executing query: " . mysqli_error($this->db->getConnection()));
        } else {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = "smtp.gmail.com";
            $mail->Username   = 'ezbus.info@gmail.com';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Password = "iieu nqyf ffnj ougw ";
            $mail->Port       = 465;

            $mail->isHtml(true);

            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Password Reset";
            $mail->Body    = <<<END
                                Click <a href="http://localhost/EzBus/resetPassword.php?token=$token">Here</a>
                                to reset password
                                END;
            try {
                $mail->send();
                echo "<script>alert('Message sent. Please check your inbox')</script>";
            } catch (Exception $e) {
                echo "message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
            $this->db->disconnect();
        }
    }
    public function sendTicket($email,$busNumber)
    {
        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = "smtp.gmail.com";
            $mail->Username = 'ezbus.info@gmail.com';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Password = "iieu nqyf ffnj ougw";
            $mail->Port = 587;
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Ez Bus Ticket for this '$busNumber' Bus";

            //$mail->Body = "";

            // Path to the image
            $imagePath = 'image'; 

            // Add the attachment
            $mail->addAttachment($imagePath);

            // Send the email
            $mail->send();
            echo "<script>alert('Message sent. Please check your inbox')</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    }
}

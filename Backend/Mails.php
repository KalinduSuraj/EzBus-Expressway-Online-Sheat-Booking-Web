<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "./Backend/DBConnection.php"; //!change
require_once "./Backend/QR.php"; //!change
require_once "./vendor/autoload.php"; //!change
class Mails
{
    private $db;
    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function sendTicket($email, $filename)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->Username = 'ezbus.info@gmail.com';
            $mail->Password = "iieu nqyf ffnj ougw ";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom("noreply@gmail.com", "EzBus Ticket");
            $mail->addAddress($email);
            $mail->Subject = "EzBus Ticket";
            $mail->Body = <<<END
                                Please find attached your ticket.
                                END;

            $mail->addAttachment($filename);
            $mail->send();
            echo json_encode(['success' => true, 'message' => "Ticket sent successfully"]);
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    // public function bulkMails()
    // {

    //     $sql = "SELECT ScheduleID FROM bus_schedule WHERE Date = CURDATE() AND Time > ADDTIME(NOW(), '00:59:00') AND Time < ADDTIME(NOW(), '01:06:00');"; //!change

    //     $sql2 = "SELECT PassengerID FROM booking WHERE ScheduleID = 'S001' AND PassengerID IS NOT NULL;";


    //         $mail = new PHPMailer(true);

    //         try {

    //             $mail->isSMTP();
    //             $mail->SMTPAuth = true;

    //             $mail->Host = "smtp.gmail.com";
    //             $mail->Username = 'ezbus.info@gmail.com';
    //             $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //             $mail->Password = "iieu nqyf ffnj ougw ";
    //             $mail->Port = 465;
    //             $mail->setFrom("noreply@example.com", "EzBus Notifications");
    //             $mail->addAddress($email);
    //             $mail->Subject = "Bus Notification: Bus  is leaving soon!";
    //             $mail->Body = "Dear passenger, the bus will start driving soon. Please be ready to board on time.";
    //             $mail->send();
    //         } catch (Exception $e) {
    //             error_log($e->getMessage(), 3, '/Backend/error.log');
    //             echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //         }
    //         $this->db->disconnect();

    // }
    public function bulkMails()
    {
        $conn = $this->db->getConnection();

        try {
            $sql1 = "SELECT ScheduleID FROM bus_schedule WHERE Date = CURDATE() 
            AND Time > ADDTIME(NOW(), '00:59:00') 
            AND Time < ADDTIME(NOW(), '01:06:00');";
            $result1 = mysqli_query($conn, $sql1);

            if (!$result1) {
                throw new Exception("Error executing query: " . mysqli_error($conn));
            }

            while ($schedule = mysqli_fetch_assoc($result1)) {
                $scheduleID = $schedule['ScheduleID'];

                $sql2 = "SELECT PassengerID FROM booking WHERE ScheduleID = '$scheduleID' AND PassengerID IS NOT NULL;";
                $result2 = mysqli_query($conn, $sql2);

                if (!$result2) {
                    throw new Exception("Error executing query: " . mysqli_error($conn));
                }
                while ($passenger = mysqli_fetch_assoc($result2)) {
                    $passengerId = $passenger['PassengerID'];

                    $sql3 = "SELECT Email FROM passengerview WHERE PassengerID='$passengerId'";
                    $result3 = mysqli_query($conn, $sql3);

                    if (!$result3) {
                        throw new Exception("Error executing query: " . mysqli_error($conn));
                    }

                    $passengerData = mysqli_fetch_assoc($result3);
                    $email = $passengerData['Email'];

                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->SMTPAuth = true;
                        $mail->Host = "smtp.gmail.com";
                        $mail->Username = 'ezbus.info@gmail.com';
                        $mail->Password = "iieu nqyf ffnj ougw ";
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;

                        $mail->setFrom("noreply@example.com", "EzBus Notifications");
                        $mail->addAddress($email);
                        $mail->Subject = "Bus Notification: Bus is leaving soon!";
                        $mail->Body = "Dear passenger, the bus will start driving soon. Please be ready to board on time.";

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Mail error for $email: " . $e->getMessage(), 3, '/Backend/error.log');
                    }
                }
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        $this->db->disconnect();
    }



    public function sendOTP($otp, $email)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->Username   = 'ezbus.info@gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Password = "iieu nqyf ffnj ougw ";
        $mail->Port = 587;

        $mail->isHtml(true);
        $mail->setFrom("noreply@gmail.com", "EzBus OTP");
        $mail->addAddress($email);
        $mail->Subject = "OTP Code";
        $mail->Body = <<<END
                            OTP CODE: $otp                        
                        END;
        try {
            $mail->send();
            echo json_encode(['success' => true, 'message' => "OTP sent successfully"]);
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        $this->db->disconnect();
    }

    public function sendMail($text, $email)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->Username   = 'ezbus.info@gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Password = "iieu nqyf ffnj ougw ";
        $mail->Port = 587;

        $mail->isHtml(true);
        $mail->setFrom("noreply@gmail.com", "Ez Bus");
        $mail->addAddress($email);
        $mail->Subject = "Ez Bus";
        $mail->Body = <<<END
                            $text                       
                        END;
        try {
            $mail->send();
            echo json_encode(['success' => true, 'message' => "OTP sent successfully"]);
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        $this->db->disconnect();
    }
    public function sendArrivedMail()
    {
        //!sql query to get the email addresses of the passengers
        $mailArray = ["mchanuka72@gmail.com"];
        foreach ($mailArray as $email) {
            // $email = $row['Email']; //! get email from the result set
            $mail = new PHPMailer(true);

            try {

                $mail->isSMTP();
                $mail->SMTPAuth = true;

                $mail->Host = "smtp.gmail.com";
                $mail->Username = 'ezbus.info@gmail.com';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Password = "iieu nqyf ffnj ougw";
                $mail->Port = 465;
                $mail->setFrom("noreply@gmail.com", "EzBus Notifications");
                $mail->addAddress($email);
                $mail->Subject = "Bus Notification: Bus  is Arrived!";
                $mail->Body = "Dear passenger,The Bus is Arrived into [City].";
                $mail->send();
            } catch (Exception $e) {
                error_log($e->getMessage(), 3, '/Backend/error.log');
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            $this->db->disconnect();
        }
    }
}

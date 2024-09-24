<?php
require_once __DIR__ . "/DBConnection.php";
require_once "./Backend/QR.php"; 
require_once "./vendor/autoload.php"; //!change

use NotifyLk\Api\SmsApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Notify
{
    private $db;
    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function sendMsg($txt, $number)
    {
        if (str_starts_with($number, '0')) {
            $number = '94' . substr($number, 1);
        }
        $client = new Client([
            'verify' => false,
        ]);
        $api_instance = new SmsApi();

        $user_id = "27956";
        $api_key = "WXKACXgjdIVg4QxSezAP";
        $message = "$txt";
        $to = "$number";
        $sender_id = "NotifyDEMO";

        try {
            $response = $client->post('https://app.notify.lk/api/v1/send', [
                'form_params' => [
                    'user_id' => $user_id,
                    'api_key' => $api_key,
                    'message' => $message,
                    'to' => $to,
                    'sender_id' => $sender_id,
                ]
            ]);
            echo json_encode(['success' => true, 'message' => "Msg sent successfully"]);
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

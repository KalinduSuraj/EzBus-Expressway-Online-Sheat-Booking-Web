<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

require_once "./Backend/DBConnection.php"; //!change

class QR
{

    private $db;
    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }
    public function generateQRCode($bookingId)
    {
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT * FROM bookingview WHERE BookingID=?";
            $stmnt = $conn->prepare($sql);
            $stmnt->bind_param("s", $bookingId);

            $stmnt->execute();
            $result = $stmnt->get_result();
            $data = $result->fetch_assoc();
            $dataArray = [];
            $dataArray[0] = $data['BookingID'];
            $dataArray[1] = $data['Name'];
            $dataArray[2] = $data['Contact'];
            $dataArray[3] = $data['FromCity'];
            $dataArray[4] = $data['ToCity'];
            $dataArray[5] = $data['Date'];
            $dataArray[6] = $data['Formatted_time'];
            $dataArray[7] = $data['BusNumber'];
            $dataArray[8] = $data['SeatNo'];

            if ($data) {
                $jsonData = json_encode($dataArray);

                $qr = QrCode::create($jsonData)
                    ->setMargin(25)
                    ->setForegroundColor(new Color(0, 0, 255))
                    ->setBackgroundColor(new Color(255, 255, 255));

                $writer = new PngWriter();
                $qrImage = $writer->write($qr);

                $filename = 'qr.png';
                $qrImage->saveToFile($filename);

                return $filename;
            } else {
                error_log("No data found for booking ID: " . $bookingId);
                return false;
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}

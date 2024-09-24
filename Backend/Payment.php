<?php
require_once "./Backend/DBConnection.php"; //!change
require_once "./Backend/Mails.php"; //!change
require_once  './vendor/autoload.php'; //!change

class Payment
{
    private $db;
    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function checkOut($seatPrice)
    {
        $stripe_secret_key = "sk_test_51PwOx8P6B17WC3fQR0Q1tm1fcT2s5TUYTYwMB2cHAKuvux7PrkzsNLWZsB3Tj154FUTaKDf1Tiv9w2QsBCeCm8Ht00yCpKYBqj";

        \Stripe\Stripe::setApiKey($stripe_secret_key);

        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/selectroot.php", //!change
            "cancel_url" => "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php?action=PaymentFailed", //!change
            "locale" => "auto",
            "line_items" => [
                [
                    "quantity" => 1,
                    "price_data" => [
                        "currency" => "lkr",
                        "unit_amount" => $seatPrice * 100,
                        "product_data" => [
                            "name" => "Seat"
                        ]
                    ]
                ]
            ]
        ]);
        echo json_encode(['url' => $checkout_session->url]);
    }
}

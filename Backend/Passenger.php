<?php
require_once 'DBConnection.php';
require_once '/wamp64/www/EzBus/vendor/autoload.php';

use Google\Service\Oauth2;

class Passenger extends User
{


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }
    public function GoogleAuthentication(String $type)
    {
        // init configuration
        $clientID = '964192116650-7bvo1c1cnvi3qgnvk5805f8q82mbamo4.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUri = 'http://localhost/EzBus/';

        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        //internal error
        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => 'C:\wamp64\bin\php\cacert.pem']));

        // authenticate code from Google OAuth Flow
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name = $google_account_info->name;
            switch ($type) {
                case 'login':
                    $this->logWith3rdparty($email, "Google");
                    break;
                case 'signup':
                    $this->registerWith3rdParty($name, $email, 'googleSignUp');
                    break;
            }
            // header('Location: http://localhost/EzBus/');
            exit();
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit();
        }
    } //*----------------------------------------------------------------------|Not working|----------------------------------------------
    public function FacebookAuthentication(String $type)
    {
        session_start();

        $fb = new Facebook\Facebook([
            'app_id' => '349574224876404',
            'app_secret' => '5edf4486e9327bf8a96da63c75667705',
            'default_graph_version' => 'v2.20',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl("http://localhost/EzBus/");

        try {
            $accessToken = $helper->getAccessToken();
            if (isset($accessToken)) {
                $_SESSION['access_token'] = (string)$accessToken;

                // Getting user's profile info
                $response = $fb->get('/me?fields=name,email', $accessToken);
                $user = $response->getGraphUser();
                $email = $user['email'];
                $name = $user['name'];

                switch ($type) {
                    case 'login':
                        $this->logWith3rdparty($email, "Facebook");
                        break;
                    case 'signup':
                        $this->registerWith3rdParty($name, $email, 'facebookSignUp');
                        break;
                }

                // Redirect to your desired page after successful login/signup
                header('Location: http://localhost/EzBus/');
                exit();
            } else {
                $authUrl = $loginUrl;
                header('Location: ' . $authUrl);
                exit();
            }
        } catch (Exception $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit();
        }
    } //*----------------------------------------------------------------------|Not working|----------------------------------------------
    private function logWith3rdParty(String $email, String $logType)
    {
        try {
            $sql = "Select * from user_account where Email='$email' and LoginType='$logType'";
            $result = mysqli_query($this->db->getConnection(), $sql);
            if (mysqli_num_rows($result) == 1) {
                echo "<script>console.log('Login successful');</script>";
                //*passenger panel
            } else {
                echo "<script>console.log('Login Fail');</script>";
            }
        } catch (Exception $e) {
            echo $e;
        }
    } //*----------------------------------------------------------------------|Not working|----------------------------------------------
    public function register(string $name, string $password, string $contact, string $email)
    {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->db->getConnection());

            // Auto increment userID
            $userID = $this->userIDIncrement();
            $passengerId = $this->PassengerIncrement();

            // Registration process
            $sql2 = "SELECT Email FROM user WHERE Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!(mysqli_num_rows($res) == 1)) {
                // Insert queries
                $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType,loginType) VALUES('$userID', '$name', '$email', '$contact', '$password', 'Passenger','Normal')";
                $query2 = "INSERT INTO passenger VALUES('$passengerId', '$userID')";

                $result1 = mysqli_query($this->db->getConnection(), $query1);
                $result2 = mysqli_query($this->db->getConnection(), $query2);

                if ($result1 && $result2) {
                    mysqli_commit($this->db->getConnection());
                    echo "<script> console.log('Added'); </script>";
                    echo "<script>alert('Passenger Registered Successfully');</script>";

                    // Redirection file->
                    // echo "<script>window.location.href = 'signIn.php';</script>";
                } else {
                    mysqli_rollback($this->db->getConnection());
                    echo "<script> alert('not Added'); </>";
                }
                return true;
            } else {
                echo "<script> alert('there is the Passenger in this $email'); </script>";
                mysqli_rollback($this->db->getConnection());
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            echo $e;
        } finally {
            $this->db->disconnect();
        }
    } //*----------------------------------------------------------------------|Not working|----------------------------------------------
    private function registerWith3rdParty(string $name, string $email, string $type3rdParty)
    {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->db->getConnection());

            // Auto increment userID
            $userID = $this->userIDIncrement();

            // Auto increment passengerID
            $sql1 = "SELECT MAX(PassengerID) FROM passenger";
            $r = mysqli_query($this->db->getConnection(), $sql1);
            if ($row = mysqli_fetch_array($r)) {
                $maxId = $row["PassengerID"];
                $numericPart = intval(substr($maxId, 1));
                $newNumericPart = $numericPart + 1;

                $passengerId = 'P' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
            } else {
                $passengerId = 'P001';
            }

            // Registration process
            $sql2 = "SELECT Email FROM user WHERE Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!(mysqli_num_rows($res) == 1)) {
                $registerType = "";
                if ($type3rdParty == 'googleSignUp') {
                    $registerType = 'Google';
                } else if ($type3rdParty == 'facebookSignUp') {
                    $registerType = 'Facebook';
                } else {
                    $registerType = 'Normal';
                }
                // Insert queries
                $query1 = "INSERT INTO user_account(UserID, Name, Email, Password, UserType,loginType) VALUES('$userID', '$name', '$email', 'GooglePassword', 'Passenger',$registerType)";
                $query2 = "INSERT INTO passenger VALUES('$passengerId', '$userID')";

                $result1 = mysqli_query($this->db->getConnection(), $query1);
                $result2 = mysqli_query($this->db->getConnection(), $query2);

                if ($result1 && $result2) {
                    mysqli_commit($this->db->getConnection());
                    echo "<script> console.log('Added'); </script>";
                    echo "<script>alert('Passenger Registered Successfully');</script>";

                    // Redirection file->
                    // echo "<script>window.location.href = 'signIn.php';</script>";
                } else {
                    mysqli_rollback($this->db->getConnection());
                    echo "<script> alert('not Added'); </>";
                }
                return true;
            } else {
                echo "<script> alert('there is the Passenger in this $email'); </script>";
                mysqli_rollback($this->db->getConnection());
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            echo $e;
        } finally {
            $this->db->disconnect();
        }
    } //*----------------------------------------------------------------------|Not working|----------------------------------------------

    function resetPassword($password, $token)
    {
        echo $token . "<br>";
        $tokenHash = hash("sha256", $token);
        echo $tokenHash;
        $sql = "SELECT * from user WHERE reset_token_hash = '$tokenHash'";
        $res = mysqli_query($this->db->getConnection(), $sql);
        $row = mysqli_num_rows($res);
        if ($row == 0) {
            echo "Token not found";
        } else {
            $queary = "UPDATE user SET Password='$password',reset_token_hash = NULL,reset_token_expire_at = NULL WHERE reset_token_hash = '$tokenHash'";
            $result = mysqli_query($this->db->getConnection(), $queary);
            $this->db->disconnect();
            if ($result === true) {
                echo "<script>alert('Password updated Successfully');
                        window.location.href = '../FrontEnd/signIn.php';       
                </script>";
            }
        }
    }//*-----------------------------------------------------|Adjust this <-
    private function PassengerIncrement()
    {

        try {
            // Query to get the last inserted UserID
            $query = "SELECT AdminID FROM admin ORDER BY AdminID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);
            $lastID = mysqli_fetch_assoc($result)['AdminID'];

            if ($lastID) {
                // Extract the numeric part of the last ID
                $number = intval(substr($lastID, 1));
                // Increment the number
                $newNumber = $number + 1;
            } else {
                // If no records exist, start with 1
                $newNumber = 1;
            }

            // Format the new ID with leading zeros
            $newID = 'A' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            return $newID;
        } catch (Exception $e) {
            echo "Error generating new UserID: " . $e->getMessage();
            return null;
        }
    }
}

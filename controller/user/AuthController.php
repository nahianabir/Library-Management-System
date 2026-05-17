<?php

session_start();

include_once '../../model/User.php';

class AuthController {

    public function login() {

        if(isset($_POST['login'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();

            $result = $user->login($email, $password);

            if(mysqli_num_rows($result) > 0) {

                $data = mysqli_fetch_assoc($result);

                $_SESSION['user_id'] = $data['id'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['name'] = $data['name'];

                header("Location: ../../view/dashboard.php");
                 }
            else {
                echo "Invalid Login";
            }
        }
    }
}

$auth = new AuthController();
$auth->login();
?>
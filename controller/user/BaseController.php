<?php

class BaseController {

    public function checkSession() {

        session_start();

        if(!isset($_SESSION['user_id'])) {

            header(
                "Location: ../../view/login.php"
            );
        }
    }
}
?>
<?php

class Validation {

    public function emptyCheck(
        $data
    ) {

        if(empty($data)) {

            return false;
        }

        return true;
    }

    public function emailCheck(
        $email
    ) {

        if(filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )) {

            return true;
        }

        return false;
    }
}
?>
<?php

include_once '../model/TransferRequest.php';

if(

    isset($_POST['id']) &&
    isset($_POST['status'])

) {

    $request =
    new TransferRequest();

    $request->updateStatus(

        $_POST['id'],
        $_POST['status']

    );

    echo "success";
}

?>
<?php

include_once '../../model/TransferRequest.php';

class RequestController {

    public function getRequests() {

        $request = new TransferRequest();

        return $request->allRequests();
    }



    public function changeStatus() {

        if(isset($_POST['id'])
        && isset($_POST['status'])) {

            $id = $_POST['id'];

            $status = $_POST['status'];

            $request = new TransferRequest();

            $request->updateStatus(
                $id,
                $status
            );

            echo "Success";
        }
    }
}

$request = new RequestController();

$request->changeStatus();

?>
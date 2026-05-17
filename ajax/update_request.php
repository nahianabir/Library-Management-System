<?php

include_once '../model/TransferRequest.php';

$id = $_POST['id'];
$status = $_POST['status'];

$request = new TransferRequest();

$request->updateStatus($id, $status);

echo "success";
?>
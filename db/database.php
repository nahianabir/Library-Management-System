<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "library_management"
);

if (!$conn) {
    die("Database Connection Failed");
}
?>
<?php
include '../db/db.php';

class BranchModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll($limit = 50, $offset = 0) {
        $query = "SELECT * FROM branches LIMIT $limit OFFSET $offset";
        return mysqli_query($this->conn, $query);
    }

    public function getById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM branches WHERE id = $id";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function insert($data) {
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $address = mysqli_real_escape_string($this->conn, $data['address']);
        $city = mysqli_real_escape_string($this->conn, $data['city']);
        $phone = mysqli_real_escape_string($this->conn, $data['phone']);

        $query = "INSERT INTO branches (name, address, city, phone) 
                  VALUES ('$name', '$address', '$city', '$phone')";
        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $address = mysqli_real_escape_string($this->conn, $data['address']);
        $city = mysqli_real_escape_string($this->conn, $data['city']);
        $phone = mysqli_real_escape_string($this->conn, $data['phone']);

        $query = "UPDATE branches SET name = '$name', address = '$address', city = '$city', phone = '$phone' WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }

    public function delete($id) {
        $id = (int)$id;
        $query = "DELETE FROM branches WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }
}
?>

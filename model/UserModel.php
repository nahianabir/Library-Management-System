<?php
include '../db/db.php';

class UserModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll($limit = 50, $offset = 0) {
        $query = "SELECT * FROM users LIMIT $limit OFFSET $offset";
        return mysqli_query($this->conn, $query);
    }

    public function getById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM users WHERE id = $id";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function getByEmail($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $query = "SELECT * FROM users WHERE email = '$email'";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function insert($data) {
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $email = mysqli_real_escape_string($this->conn, $data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = mysqli_real_escape_string($this->conn, $data['role']);

        $query = "INSERT INTO users (name, email, password_hash, role) VALUES ('$name', '$email', '$password', '$role')";
        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $email = mysqli_real_escape_string($this->conn, $data['email']);

        $query = "UPDATE users SET name = '$name', email = '$email' WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }

    public function delete($id) {
        $id = (int)$id;
        $query = "DELETE FROM users WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }
}
?>

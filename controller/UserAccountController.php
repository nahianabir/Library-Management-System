<?php
include '../db/db.php';

class UserAccountController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users ORDER BY role, created_at DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = $id";
        return mysqli_fetch_assoc(mysqli_query($this->conn, $query));
    }

    public function createUser($data) {
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $email = mysqli_real_escape_string($this->conn, $data['email']);
        $phone = mysqli_real_escape_string($this->conn, $data['phone']);
        $role = mysqli_real_escape_string($this->conn, $data['role']);
        $branch_id = isset($data['branch_id']) ? (int)$data['branch_id'] : 'NULL';

        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, email, phone, password_hash, role, branch_id) 
                  VALUES ('$name', '$email', '$phone', '$password_hash', '$role', $branch_id)";

        return mysqli_query($this->conn, $query);
    }

    public function updateUser($id, $data) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->conn, $data['name']);
        $email = mysqli_real_escape_string($this->conn, $data['email']);
        $phone = mysqli_real_escape_string($this->conn, $data['phone']);
        $role = mysqli_real_escape_string($this->conn, $data['role']);

        $query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', role = '$role' WHERE id = $id";

        return mysqli_query($this->conn, $query);
    }

    public function deleteUser($id) {
        $id = (int)$id;
        $query = "DELETE FROM users WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }
}
?>

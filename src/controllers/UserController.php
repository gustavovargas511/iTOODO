<?php
include(__DIR__ . '/../models/User.php');

class UserController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new user
    public function createUser(User $user)
    {
        $sql = "INSERT INTO user (username, email, password, created_at) VALUES (:username, :email, :password, :created_at)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $user->getUsername(),
            ':email' => $user->getEmail(),
            ':password' => password_hash($user->getPassword(), PASSWORD_DEFAULT), // Encrypt the password
            ':created_at' => $user->getCreated_at()
        ]);
        return $this->pdo->lastInsertId(); // Return the ID of the inserted record
    }

    // Read user by ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if ($data) {
            $user = new User();
            $user->setId($data['id'])
                ->setUsername($data['username'])
                ->setEmail($data['email'])
                ->setPassword($data['password'])
                ->setCreated_at($data['created_at']);
            return $user;
        }
        return null;
    }

    // Read user by ID
    public function getUserIdByUsername($username)
    {
        $sql = "SELECT id FROM user WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch();
        if ($data) {
            $user = new User();
            $user->setId($data['id']);
            return $user;
        }
        return null;
    }

    // Update a user
    public function updateUser(User $user)
    {
        $sql = "UPDATE user SET username = :username, email = :email, password = :password WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $user->getId(),
            ':username' => $user->getUsername(),
            ':email' => $user->getEmail(),
            ':password' => password_hash($user->getPassword(), PASSWORD_DEFAULT)
        ]);
    }

    // Delete a user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // List all users
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->pdo->query($sql);
        $users = [];
        while ($data = $stmt->fetch()) {
            $user = new User();
            $user->setId($data['id'])
                ->setUsername($data['username'])
                ->setEmail($data['email'])
                ->setPassword($data['password'])
                ->setCreated_at($data['created_at']);
            $users[] = $user;
        }
        return $users;
    }
}

?>
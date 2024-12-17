<?php

include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/src/models/Todo.php';

class TodoController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new Todo
    public function createTodo(Todo $todo)
    {
        $sql = "INSERT INTO todo (title, body, completed, completion_date, user_id) 
                VALUES (:title, :body, :completed, :completion_date, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $todo->getTitle(),
            ':body' => $todo->getBody(),
            ':completed' => $todo->getCompleted(),
            ':completion_date' => $todo->getCompletionDate(),
            ':user_id' => $todo->getUserId(),
        ]);
        return $this->pdo->lastInsertId();
    }

    // Get a Todo by ID
    public function getTodoById($id)
    {
        $sql = "SELECT * FROM todo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();

        if ($data) {
            $todo = new Todo();
            $todo->setId($data['id'])
                ->setTitle($data['title'])
                ->setBody($data['body'])
                ->setCompleted($data['completed'])
                ->setCompletionDate($data['completion_date'])
                ->setUserId($data['user_id'])
                ->setCreatedAt($data['created_at']);
            return $todo;
        }

        return null;
    }

    // Update a Todo
    public function updateTodo(Todo $todo)
    {
        $sql = "UPDATE todo SET 
                    title = :title,
                    body = :body,
                    completed = :completed,
                    completion_date = :completion_date,
                    user_id = :user_id
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $todo->getTitle(),
            ':body' => $todo->getBody(),
            ':completed' => $todo->getCompleted(),
            ':completion_date' => $todo->getCompletionDate(),
            ':user_id' => $todo->getUserId(),
            ':id' => $todo->getId(),
        ]);
    }

    // Delete a Todo
    public function deleteTodoById($id)
    {
        try {
            $sql = "DELETE FROM todo WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            if (!$stmt->execute([':id' => $id])) {
                throw new Exception("Failed to delete the todo with ID: $id.");
            }

            return true;
        } catch (Exception $e) {
            // Re-throw the exception to the calling code
            throw new Exception("Error occurred in deleteTodoById: " . $e->getMessage());
        }
    }

    // Get all Todos for a specific user
    public function getTodosByUserId($userId)
    {
        $sql = "SELECT * FROM todo WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $todos = $stmt->fetchAll();

        $todoObjects = [];
        foreach ($todos as $data) {
            $todo = new Todo();
            $todo->setId($data['id'])
                ->setTitle($data['title'])
                ->setBody($data['body'])
                ->setCompleted($data['completed'])
                ->setCompletionDate($data['completion_date'])
                ->setUserId($data['user_id'])
                ->setCreatedAt($data['created_at']);
            $todoObjects[] = $todo;
        }
        return $todoObjects;
    }

    // Get all Todos for a specific user
    public function getTodosByUsername($username)
    {
        $sql = "select td.*
                from todo td
                inner join user us
                on td.user_id = us.id
                where us.username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $todos = $stmt->fetchAll();

        $todoObjects = [];
        foreach ($todos as $data) {
            $todo = new Todo();
            $todo->setId($data['id'])
                ->setTitle($data['title'])
                ->setBody($data['body'])
                ->setCompleted($data['completed'])
                ->setCompletionDate($data['completion_date'])
                ->setUserId($data['user_id'])
                ->setCreatedAt($data['created_at']);
            $todoObjects[] = $todo;
        }
        return $todoObjects;
    }
}

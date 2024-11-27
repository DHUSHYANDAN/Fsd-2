<?php
require 'db.php';

// Get all todos
function getTodos($conn) {
    $stmt = $conn->prepare("SELECT * FROM todos");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get a single todo by ID
function getTodoById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM todos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Create a new todo
function createTodo($conn, $title, $description) {
    $stmt = $conn->prepare("INSERT INTO todos (title, description) VALUES (:title, :description)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}

// Update an existing todo
function updateTodo($conn, $id, $title, $description, $status) {
    $stmt = $conn->prepare("UPDATE todos SET title = :title, description = :description, status = :status WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Delete a todo
function deleteTodo($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
?>

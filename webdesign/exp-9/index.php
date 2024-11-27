<?php
require 'functions.php';

// Handle create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    createTodo($conn, $_POST['title'], $_POST['description']);
    header("Location: index.php");
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    updateTodo($conn, $_POST['id'], $_POST['title'], $_POST['description'], $_POST['status']);
    header("Location: index.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    deleteTodo($conn, $_GET['delete']);
    header("Location: index.php");
    exit;
}

// Fetch all todos
$todos = getTodos($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h1 {
            text-align: center;
            margin: 20px;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Form Styles */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        form input[type="text"], form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Todo List Styles */
        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        li strong {
            display: block;
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        li p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        li a {
            text-decoration: none;
            color: #e74c3c;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
        }

        li a:hover {
            color: #c0392b;
        }

        /* Update Form Styles */
        form input[type="text"], form textarea, form select {
            margin-top: 5px;
        }

        form button[type="submit"] {
            background-color: #f39c12;
            color: white;
        }

        form button[type="submit"]:hover {
            background-color: #e67e22;
        }

        select {
            width: auto;
            padding: 8px;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-indigo-600 mb-8">Todo List</h1>
        
        <!-- Create Todo Form -->
        <form method="POST" class="bg-white p-6 rounded-lg shadow-md mb-8 max-w-md mx-auto">
            <input type="hidden" name="action" value="create">
            <div class="mb-4">
                <input type="text" name="title" placeholder="Title" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
            </div>
            <div class="mb-4">
                <textarea name="description" placeholder="Description" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"></textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 focus:outline-none">Add Todo</button>
        </form>

        <!-- Todo List -->
        <ul class="space-y-6">
            <?php foreach ($todos as $todo): ?>
                <li class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900"><?= htmlspecialchars($todo['title']); ?></h2>
                            <p class="text-gray-600"><?= htmlspecialchars($todo['description']); ?></p>
                            <p class="mt-2 text-sm text-gray-500">Status: <span class="<?= $todo['status'] === 'completed' ? 'text-green-500' : 'text-yellow-500'; ?>"><?= ucfirst($todo['status']); ?></span></p>
                        </div>
                        
                        <!-- Delete Link -->
                        <div>
                            <a href="index.php?delete=<?= $todo['id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this todo?');">Delete</a>
                        </div>
                    </div>
                    
                    <!-- Update Form -->
                    <form method="POST" class="mt-4 space-y-4">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $todo['id']; ?>">

                        <div class="mb-4">
                            <input type="text" name="title" value="<?= htmlspecialchars($todo['title']); ?>" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                        </div>
                        <div class="mb-4">
                            <textarea name="description" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"><?= htmlspecialchars($todo['description']); ?></textarea>
                        </div>
                        <div class="mb-4">
                            <select name="status" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                <option value="pending" <?= $todo['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?= $todo['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 focus:outline-none">Update Todo</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

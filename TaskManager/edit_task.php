<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['UserId'])) {
    die("You need to log in to edit tasks.");
}

// Check if the task ID is provided in the URL
if (!isset($_GET['id'])) {
    die("Invalid task ID.");
}

// Get the task ID from the URL
$taskID = $_GET['id'];
$userId = $_SESSION['UserId'];

// Database connection
$mysql = new mysqli("localhost", "root", "", "task_sql");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

// Query to fetch the task based on the ID and the logged-in user
$query = "SELECT * FROM tasks WHERE TaskID = ? AND UserId = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("ii", $taskID, $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the task exists
if ($result->num_rows > 0) {
    $task = $result->fetch_assoc();
} else {
    die("Task not found.");
}

$stmt->close();

// Update the task if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get the form data
    $title = $_POST['title'];
    $dueDate = $_POST['due_date'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];

    // Update query
    $updateQuery = "UPDATE tasks SET Title = ?, DueDate = ?, Priority = ?, Description = ? WHERE TaskID = ? AND UserId = ?";
    $stmt = $mysql->prepare($updateQuery);
    $stmt->bind_param("ssssis", $title, $dueDate, $priority, $description, $taskID, $userId);
    $stmt->execute();
    $stmt->close();

    // Redirect to the tasks page
    header("Location: view_tasks.php");
    exit();
}

// Close the database connection
$mysql->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Task</h2>
        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['Title']) ?>" required><br><br>

            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" value="<?= htmlspecialchars($task['DueDate']) ?>" required><br><br>

            <label for="priority">Priority:</label>
            <select id="priority" name="priority" required>
                <option value="High" <?= $task['Priority'] == 'High' ? 'selected' : '' ?>>High</option>
                <option value="Medium" <?= $task['Priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
                <option value="Low" <?= $task['Priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
            </select><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($task['Description']) ?></textarea><br><br>

            <button type="submit">Update Task</button>
        </form>

        <div class="back-link">
            <a href="view_tasks.php">Back to Tasks</a>
        </div>
    </div>

</body>
</html>

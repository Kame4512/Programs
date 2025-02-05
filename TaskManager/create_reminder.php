<?php
session_start(); // Ensure session is started

include('page.php'); // Assuming Page is defined in 'page.php'

class CreateReminderPage extends Page {
    public function __construct() {
        parent::__construct("Create Reminder", $this->getReminderContent(), "reminder, create");
    }

    private function getReminderContent() {
        // Start a session to retrieve the logged-in user's ID
        if (!isset($_SESSION['UserId'])) {
            // If no session is found, redirect to login
            header("Location: login.php");
            exit();
        }

        // Get user ID from session
        $userId = $_SESSION['UserId'];

        // Check if TaskID is passed in the URL
        if (!isset($_GET['taskId'])) {
            header("Location: dashboard.php");
            exit();
        }
        $taskId = $_GET['taskId'];

        // Database connection
        $mysql = new mysqli("localhost", "root", "", "task_sql");

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        // Get task details
        $queryTask = "SELECT * FROM tasks WHERE TaskID = ? AND UserId = ?";
        $stmtTask = $mysql->prepare($queryTask);
        $stmtTask->bind_param("ii", $taskId, $userId);
        $stmtTask->execute();
        $resultTask = $stmtTask->get_result();
        $task = $resultTask->fetch_assoc();

        if (!$task) {
            // If task doesn't exist, redirect to dashboard
            header("Location: dashboard.php");
            exit();
        }

        // Handle form submission for creating reminder
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reminderMessage = $_POST['reminderMessage'];
            $reminderTime = $_POST['reminderTime'];

            // Insert reminder into the database
            $queryInsertReminder = "INSERT INTO reminders (UserID, TaskID, Message, Time) VALUES (?, ?, ?, ?)";
            $stmtInsertReminder = $mysql->prepare($queryInsertReminder);
            $stmtInsertReminder->bind_param("iiss", $userId, $taskId, $reminderMessage, $reminderTime);
            $stmtInsertReminder->execute();

            // Redirect back to dashboard after creating the reminder
            header("Location: dashboard.php");
            exit();
        }

        // Close database connection
        $mysql->close();

        return '
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .content {
                margin: 20px;
            }
            h2 {
                color: #333;
            }
            .form-group {
                margin: 15px 0;
            }
            label {
                display: block;
                margin-bottom: 5px;
            }
            input, textarea {
                width: 100%;
                padding: 8px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            button {
                background-color: #007bff;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
        </style>

        <div class="content">
            <h2>Create Reminder for Task: ' . htmlspecialchars($task['Title']) . '</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="reminderMessage">Reminder Message:</label>
                    <textarea id="reminderMessage" name="reminderMessage" required></textarea>
                </div>
                <div class="form-group">
                    <label for="reminderTime">Reminder Time (e.g., 2024-12-10 10:00:00):</label>
                    <input type="datetime-local" id="reminderTime" name="reminderTime" required>
                </div>
                <button type="submit">Create Reminder</button>
            </form>
        </div>';
    }
}

$createReminderPage = new CreateReminderPage();
$createReminderPage->Display();
?>

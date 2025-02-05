<?php
session_start(); // Ensure session is started

include('page.php'); // Assuming Page is defined in 'page.php'

class EditReminderPage extends Page {
    public function __construct() {
        parent::__construct("Edit Reminder", $this->getReminderContent(), "reminder, edit");
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

        // Check if ReminderID is passed in the URL
        if (!isset($_GET['reminderId'])) {
            header("Location: dashboard.php");
            exit();
        }
        $reminderId = $_GET['reminderId'];

        // Database connection
        $mysql = new mysqli("localhost", "root", "", "task_sql");

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        // Get reminder details
        $queryReminder = "SELECT * FROM reminders WHERE ReminderID = ? AND UserID = ?";
        $stmtReminder = $mysql->prepare($queryReminder);
        $stmtReminder->bind_param("ii", $reminderId, $userId);
        $stmtReminder->execute();
        $resultReminder = $stmtReminder->get_result();
        $reminder = $resultReminder->fetch_assoc();

        if (!$reminder) {
            // If reminder doesn't exist, redirect to dashboard
            header("Location: dashboard.php");
            exit();
        }

        // Handle form submission for updating the reminder
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reminderMessage = $_POST['reminderMessage'];
            $reminderTime = $_POST['reminderTime'];

            // Update reminder in the database
            $queryUpdateReminder = "UPDATE reminders SET Message = ?, Time = ? WHERE ReminderID = ?";
            $stmtUpdateReminder = $mysql->prepare($queryUpdateReminder);
            $stmtUpdateReminder->bind_param("ssi", $reminderMessage, $reminderTime, $reminderId);
            $stmtUpdateReminder->execute();

            // Redirect back to dashboard after updating the reminder
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
            <h2>Edit Reminder</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="reminderMessage">Reminder Message:</label>
                    <textarea id="reminderMessage" name="reminderMessage" required>' . htmlspecialchars($reminder['Message']) . '</textarea>
                </div>
                <div class="form-group">
                    <label for="reminderTime">Reminder Time (e.g., 2024-12-10 10:00:00):</label>
                    <input type="datetime-local" id="reminderTime" name="reminderTime" value="' . htmlspecialchars($reminder['Time']) . '" required>
                </div>
                <button type="submit">Update Reminder</button>
            </form>
        </div>';
    }
}

$editReminderPage = new EditReminderPage();
$editReminderPage->Display();
?>

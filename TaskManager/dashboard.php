<?php
session_start(); // Ensure session is started

include('page.php'); // Assuming Page is defined in 'page.php'

class DashboardPage extends Page {
    public function __construct() {
        parent::__construct("Dashboard", $this->getDashboardContent(), "dashboard, tasks, summary");
    }

    private function getDashboardContent() {
        // Start a session to retrieve the logged-in user's ID
        if (!isset($_SESSION['UserId'])) {
            // If no session is found, redirect to login
            header("Location: login.php");
            exit();
        }

        // Get user ID from session
        $userId = $_SESSION['UserId'];

        // Database connection
        $mysql = new mysqli("localhost", "root", "", "task_sql");

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        // Query to fetch upcoming tasks (due date >= today)
        $queryUpcoming = "SELECT * FROM tasks WHERE UserId = ? AND DueDate >= CURDATE() ORDER BY DueDate ASC";
        $stmtUpcoming = $mysql->prepare($queryUpcoming);
        $stmtUpcoming->bind_param("i", $userId);
        $stmtUpcoming->execute();
        $resultUpcoming = $stmtUpcoming->get_result();

        // Query to fetch past tasks (due date < today)
        $queryPast = "SELECT * FROM tasks WHERE UserId = ? AND DueDate < CURDATE() ORDER BY DueDate DESC";
        $stmtPast = $mysql->prepare($queryPast);
        $stmtPast->bind_param("i", $userId);
        $stmtPast->execute();
        $resultPast = $stmtPast->get_result();

        // Query to fetch reminders for tasks with Time field
        $queryReminders = "SELECT * FROM reminders WHERE UserID = ? ORDER BY Time ASC";
        $stmtReminders = $mysql->prepare($queryReminders);
        $stmtReminders->bind_param("i", $userId);
        $stmtReminders->execute();
        $resultReminders = $stmtReminders->get_result();

        // Create an associative array to map TaskID to Reminder messages, ReminderID, and Time
        $reminderMessages = [];
        while ($reminder = $resultReminders->fetch_assoc()) {
            $reminderMessages[$reminder['TaskID']] = [
                'ReminderID' => $reminder['ReminderID'],
                'Message' => $reminder['Message'],
                'Time' => $reminder['Time'] // Store the time in the array
            ];
        }

        // Query to fetch completed tasks
        $queryCompleted = "SELECT * FROM tasks WHERE UserId = ? AND Status = 'Completed' ORDER BY DueDate DESC";
        $stmtCompleted = $mysql->prepare($queryCompleted);
        $stmtCompleted->bind_param("i", $userId);
        $stmtCompleted->execute();
        $resultCompleted = $stmtCompleted->get_result();

        // Display upcoming tasks with reminders, including the reminder time
        $taskListUpcoming = '';
        if ($resultUpcoming->num_rows > 0) {
            while ($task = $resultUpcoming->fetch_assoc()) {
                $reminderMessage = isset($reminderMessages[$task['TaskID']]) ? $reminderMessages[$task['TaskID']]['Message'] : 'No reminder set.';
                $reminderId = isset($reminderMessages[$task['TaskID']]) ? $reminderMessages[$task['TaskID']]['ReminderID'] : null;
                $reminderTime = isset($reminderMessages[$task['TaskID']]) ? $reminderMessages[$task['TaskID']]['Time'] : null;

                $taskListUpcoming .= '
                <li>
                    ' . htmlspecialchars($task['Title']) . ' - Due: ' . htmlspecialchars($task['DueDate']) . ' - Priority: ' . htmlspecialchars($task['Priority']) . '<br>
                    Reminder: ' . $reminderMessage . '<br>';

                // Display reminder time
                if ($reminderTime) {
                    $taskListUpcoming .= 'Reminder Time: ' . htmlspecialchars($reminderTime) . '<br>';
                } else {
                    $taskListUpcoming .= 'No reminder set.<br>';
                }

                // Check if a reminder exists, show "Edit Reminder" or "Create Reminder"
                if ($reminderId !== null) {
                    $taskListUpcoming .= '<a href="edit_reminder.php?taskId=' . $task['TaskID'] . '&reminderId=' . $reminderId . '" class="btn-create-reminder">Edit Reminder</a>';
                } else {
                    $taskListUpcoming .= '<a href="create_reminder.php?taskId=' . $task['TaskID'] . '" class="btn-create-reminder">Create Reminder</a>';
                }

                $taskListUpcoming .= '</li>';
            }
        } else {
            $taskListUpcoming = '<li>No upcoming tasks.</li>';
        }

        // Display past tasks with reminders
        $taskListPast = '';
        if ($resultPast->num_rows > 0) {
            while ($task = $resultPast->fetch_assoc()) {
                $reminderMessage = isset($reminderMessages[$task['TaskID']]) ? $reminderMessages[$task['TaskID']]['Message'] : 'No reminder set.';
                $reminderTime = isset($reminderMessages[$task['TaskID']]) ? $reminderMessages[$task['TaskID']]['Time'] : null;
                $taskListPast .= '<li>' . htmlspecialchars($task['Title']) . ' - Due: ' . htmlspecialchars($task['DueDate']) . ' - Priority: ' . htmlspecialchars($task['Priority']) . '<br>Reminder: ' . $reminderMessage . '<br>';

                // Display reminder time
                if ($reminderTime) {
                    $taskListPast .= 'Reminder Time: ' . htmlspecialchars($reminderTime) . '<br>';
                }

                $taskListPast .= '</li>';
            }
        } else {
            $taskListPast = '<li>No past tasks.</li>';
        }

        // Display completed tasks
        $taskListCompleted = '';
        if ($resultCompleted->num_rows > 0) {
            while ($task = $resultCompleted->fetch_assoc()) {
                $taskListCompleted .= '<li>' . htmlspecialchars($task['Title']) . ' - Completed on: ' . htmlspecialchars($task['DueDate']) . ' - Priority: ' . htmlspecialchars($task['Priority']) . '</li>';
            }
        } else {
            $taskListCompleted = '<li>No completed tasks.</li>';
        }

        // Close the database connection
        $mysql->close();

        return '
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .sidebar {
                width: 250px;
                background: #333;
                color: #fff;
                padding: 15px;
                position: fixed;
                height: 100%;
            }
            .sidebar h2 {
                text-align: center;
            }
            .sidebar a {
                display: block;
                color: #fff;
                text-decoration: none;
                padding: 10px 0;
                margin: 5px 0;
                border-bottom: 1px solid #444;
            }
            .sidebar a:hover {
                background: #575757;
            }
            .content {
                margin-left: 270px;
                padding: 20px;
            }
            h2 {
                color: #333;
            }
            ul {
                list-style-type: none;
                padding: 0;
            }
            ul li {
                background: #fff;
                margin: 5px 0;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            ul li:hover {
                background: #f9f9f9;
            }
            .btn-create-reminder {
                display: inline-block;
                margin-top: 10px;
                padding: 8px 12px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
            }
            .btn-create-reminder:hover {
                background-color: #0056b3;
            }
            .logout-btn {
                background-color: #dc3545;
                color: #fff;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                margin-top: 20px;
            }
            .logout-btn:hover {
                background-color: #c82333;
            }
            .completed-section {
                margin-top: 30px;
            }
            .completed-section h2 {
                color: #28a745;
            }
            .completed-section ul li {
                background: #eaffea;
                border: 1px solid #a3d8a3;
            }
            .completed-section ul li:hover {
                background: #d4f5d4;
            }
        </style>

        <div class="sidebar">
            <h2>Menu</h2>
            <a href="dashboard.php">Dashboard</a>
            <a href="create_task.php">Create a Task</a>
            <a href="view_tasks.php">View Tasks</a>
            <a href="completed_tasks.php">Completed Tasks</a>
            <a href="collaborators.php">Manage Collaborators</a> <!-- Added Collaborator button -->
        </div>
        <div class="content">
            <h2>Your Upcoming Tasks</h2>
            <ul>
                ' . $taskListUpcoming . '
            </ul>
            <h2>Your Past Tasks</h2>
            <ul>
                ' . $taskListPast . '
            </ul>
            <div class="completed-section">
                <h2>Your Completed Tasks</h2>
                <ul>
                    ' . $taskListCompleted . '
                </ul>
            </div>
            <p>Use the navigation above to manage your tasks.</p>
            <a href="login.php" class="logout-btn">Logout</a>
        </div>';
    }
}

$dashboardPage = new DashboardPage();
$dashboardPage->Display();
?>

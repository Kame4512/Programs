<?php
session_start(); // Start the session to store user data

include('page.php'); // Assuming Page is defined in 'page.php'

class ViewTasksPage extends Page {
    public function __construct() {
        parent::__construct("View Tasks", $this->getTasksList(), "view, tasks, list");
    }

    private function getTasksList() {
        // Check if the user is logged in
        if (!isset($_SESSION['UserId'])) {
            return '<p>You need to log in to view your tasks.</p>';
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['UserId'];

        // Database connection
        $mysql = new mysqli("localhost", "root", "", "task_sql");

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        // Check if a task has been marked as completed
        if (isset($_POST['complete_task_id'])) {
            $taskID = $_POST['complete_task_id'];
            
            // Update the task's status to 'Completed'
            $updateStatusQuery = "UPDATE tasks SET Status = 'Completed' WHERE TaskID = ? AND UserId = ?";
            $stmt = $mysql->prepare($updateStatusQuery);
            $stmt->bind_param("ii", $taskID, $userId);
            $stmt->execute();
            $stmt->close();

            // Redirect to refresh the page
            header("Location: view_tasks.php");
            exit();
        }

        // Query to fetch tasks for the logged-in user excluding completed tasks
        $query = "SELECT * FROM tasks WHERE UserId = ? AND Status != 'Completed'"; // Exclude completed tasks
        $stmt = $mysql->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any tasks
        if ($result->num_rows > 0) {
            $taskList = '';
            while ($row = $result->fetch_assoc()) {
                // Create a list item for each task
                $taskList .= '
                    <li>
                        <span class="task-info">
                            <strong>Title:</strong> ' . htmlspecialchars($row['Title']) . ' | 
                            <strong>Due:</strong> ' . htmlspecialchars($row['DueDate']) . ' |
                            <strong>Priority:</strong> ' . htmlspecialchars($row['Priority']) . ' |
                            <strong>Description:</strong> ' . htmlspecialchars($row['Description']) . ' |
                            <strong>Status:</strong> ' . htmlspecialchars($row['Status']) . '
                        </span>
                        <span>
                            <form method="POST" action="">
                                <input type="hidden" name="complete_task_id" value="' . $row['TaskID'] . '">
                                <label for="completed_' . $row['TaskID'] . '">Completed?</label>
                                <input type="checkbox" id="completed_' . $row['TaskID'] . '" name="completed" 
                                    ' . ($row['Status'] == 'Completed' ? 'checked' : '') . ' 
                                    onclick="this.form.submit()">
                            </form>
                            <a href="edit_task.php?id=' . $row['TaskID'] . '">Edit</a> |
                            <a href="view_tasks.php?delete_id=' . $row['TaskID'] . '" onclick="return confirm(\'Are you sure you want to delete this task?\')">Delete</a>
                        </span>
                    </li>';
            }
        } else {
            $taskList = '<li>No tasks available.</li>';
        }

        // Close the database connection
        $mysql->close();

        // Return the HTML for the tasks
        return '
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .task-container {
                max-width: 800px;
                margin: 50px auto;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .task-container h2 {
                text-align: center;
                color: #333;
                margin-bottom: 20px;
            }
            ul.task-list {
                list-style: none;
                padding: 0;
            }
            ul.task-list li {
                padding: 15px;
                margin-bottom: 10px;
                background: #e9f5e9;
                border: 1px solid #c3e6c3;
                border-radius: 5px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            ul.task-list li:nth-child(even) {
                background: #f2f8f2;
            }
            ul.task-list li a {
                text-decoration: none;
                font-weight: bold;
                color: #007bff;
                margin-left: 10px;
                transition: color 0.3s;
            }
            ul.task-list li a:hover {
                color: #0056b3;
            }
            .task-info {
                flex-grow: 1;
            }
            .back-to-dashboard {
                display: block;
                text-align: center;
                margin-top: 30px;
                font-size: 16px;
                color: #007bff;
                text-decoration: none;
                font-weight: bold;
            }
            .back-to-dashboard:hover {
                color: #0056b3;
            }
        </style>

        <div class="task-container">
            <h2>Your Tasks</h2>
            <ul class="task-list">
                ' . $taskList . '
            </ul>
            <!-- Back to Dashboard link -->
            <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
        </div>';
    }
}

$viewTasksPage = new ViewTasksPage();
$viewTasksPage->Display();
?>

<?php
include('page.php');

class CompletedTasksPage extends Page {
    public function __construct() {
        // Handle task restoration or deletion
        $this->handleActions();
        parent::__construct("Completed Tasks", $this->getCompletedTasksList(), "completed, tasks, list");
    }

    private function handleActions() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['UserId'])) {
            return; // Skip processing if not logged in
        }

        // Check if the action is triggered
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $taskId = intval($_GET['id']); // Sanitize task ID
            if ($taskId > 0) {
                $mysql = new mysqli("localhost", "root", "", "task_sql");

                if ($mysql->connect_error) {
                    die("Database connection failed: " . $mysql->connect_error);
                }

                if ($_GET['action'] === 'restore') {
                    // Update the task status to "In Progress"
                    $query = "UPDATE tasks SET Status = 'In Progress' WHERE TaskID = ? AND UserId = ?";
                } elseif ($_GET['action'] === 'delete') {
                    // Permanently delete the task
                    $query = "DELETE FROM tasks WHERE TaskID = ? AND UserId = ?";
                } else {
                    return; // Invalid action
                }

                $stmt = $mysql->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("ii", $taskId, $_SESSION['UserId']);
                    if ($stmt->execute()) {
                        $actionMessage = ($_GET['action'] === 'restore') ? 'Task restored successfully.' : 'Task deleted successfully.';
                        header("Location: completed_tasks.php?message=" . urlencode($actionMessage));
                        exit();
                    } else {
                        echo "Error: Could not execute action. " . $mysql->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error: Query preparation failed. " . $mysql->error;
                }
                $mysql->close();
            }
        }
    }

    private function getCompletedTasksList() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['UserId'])) {
            return '<p>You need to log in to view your tasks.</p>';
        }

        $userId = $_SESSION['UserId'];
        $mysql = new mysqli("localhost", "root", "", "task_sql");

        if ($mysql->connect_error) {
            die("Database connection failed: " . $mysql->connect_error);
        }

        $output = '
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
            <h2>Completed Tasks</h2>
            <ul class="task-list">';

        // Fetch completed tasks for the logged-in user
        $query = "SELECT TaskID, Title FROM tasks WHERE Status = 'Completed' AND UserId = ?";
        $stmt = $mysql->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $output .= '
                    <li>
                        <span class="task-info">' . htmlspecialchars($row['Title']) . '</span>
                        <span>
                            <a href="completed_tasks.php?action=restore&id=' . $row['TaskID'] . '">Restore</a> |
                            <a href="completed_tasks.php?action=delete&id=' . $row['TaskID'] . '" style="color: red;">Delete</a>
                        </span>
                    </li>';
                }
            } else {
                $output .= '<li>No completed tasks found.</li>';
            }

            $stmt->close();
        } else {
            $output .= '<li>Error fetching tasks.</li>';
        }

        $mysql->close();

        $output .= '
            </ul>
            <!-- Back to Dashboard link -->
            <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
        </div>';

        return $output;
    }
}

$completedTasksPage = new CompletedTasksPage();
$completedTasksPage->Display();
?>

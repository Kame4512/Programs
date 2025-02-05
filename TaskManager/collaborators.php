<?php
include('page.php'); // Assuming Page is defined in 'page.php'

class CollaboratorsPage extends Page {
    public function __construct() {
        parent::__construct("Manage Collaborators", $this->getCollaboratorsContent(), "collaborators, tasks");
    }

    private function getCollaboratorsContent() {
        // Database connection
        $mysql = new mysqli("localhost", "root", "", "task_sql");

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        // Query to fetch all users from the 'users' table
        $queryUsers = "SELECT UserID, Username FROM users";
        $stmtUsers = $mysql->prepare($queryUsers);
        $stmtUsers->execute();
        $resultUsers = $stmtUsers->get_result();

        // Query to fetch tasks (just the task ID and title)
        $queryTasks = "SELECT TaskID, Title FROM tasks";
        $stmtTasks = $mysql->prepare($queryTasks);
        $stmtTasks->execute();
        $resultTasks = $stmtTasks->get_result();

        // Handle adding collaborators
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_collaborator'])) {
            $taskId = $_POST['task_id'];
            $collaboratorId = $_POST['collaborator_id'];
            $role = $_POST['role'];

            // Check if the user is already a collaborator on the selected task
            $checkQuery = "SELECT COUNT(*) FROM collaborators WHERE TaskID = ? AND UserID = ?";
            $stmtCheck = $mysql->prepare($checkQuery);
            $stmtCheck->bind_param("ii", $taskId, $collaboratorId);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close(); // Ensure you close the statement to avoid sync issues

            if ($count > 0) {
                $content = '<p class="alert">This user is already a collaborator on this task.</p>';
            } else {
                // Insert the new collaborator into the database if not already a collaborator
                $addQuery = "INSERT INTO collaborators (TaskID, UserID, Role) VALUES (?, ?, ?)";
                $stmtAdd = $mysql->prepare($addQuery);
                $stmtAdd->bind_param("iis", $taskId, $collaboratorId, $role);
                $stmtAdd->execute();
                $stmtAdd->close(); // Close the statement
                $content = '<p class="success">Collaborator added successfully.</p>';
            }
        }

        // Close the database connection
        $mysql->close();

        // Display content
        $content = '<h2>Add Collaborator to Task</h2>';

        // Display tasks dropdown
        $content .= '<form method="POST" class="collaborator-form">
                        <label for="task_id">Select Task:</label>
                        <select name="task_id" id="task_id" required>
                            <option value="">Select Task</option>';

        while ($task = $resultTasks->fetch_assoc()) {
            $content .= '<option value="' . $task['TaskID'] . '">' . htmlspecialchars($task['Title'] ?? 'Untitled Task') . '</option>';
        }

        $content .= '</select><br>';

        // Display users dropdown
        $content .= '<label for="collaborator_id">Select Collaborator:</label>
                        <select name="collaborator_id" id="collaborator_id" required>
                            <option value="">Select Collaborator</option>';

        while ($user = $resultUsers->fetch_assoc()) {
            $content .= '<option value="' . $user['UserID'] . '">' . htmlspecialchars($user['Username'] ?? 'Unknown User') . '</option>';
        }

        $content .= '</select><br>';

        // Display role dropdown
        $content .= '<label for="role">Select Role:</label>
                        <select name="role" id="role" required>
                            <option value="Viewer">Viewer</option>
                            <option value="Editor">Editor</option>
                        </select><br>';

        // Add Collaborator button
        $content .= '<button type="submit" name="add_collaborator" class="btn-add-collaborator">Add Collaborator</button>
                    </form>';

        // Back to Dashboard Button
        $content .= '<a href="dashboard.php" class="btn-back-dashboard">Back to Dashboard</a>';

        // Return content with style
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
                padding: 20px;
                background-color: white;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #333;
            }
            .collaborator-form {
                margin-top: 20px;
                max-width: 500px;
                margin: 0 auto;
            }
            .collaborator-form label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }
            .collaborator-form select {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: #f9f9f9;
            }
            .collaborator-form button {
                padding: 10px 15px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
            }
            .collaborator-form button:hover {
                background-color: #0056b3;
            }
            .btn-back-dashboard {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 15px;
                background-color: #28a745;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                text-align: center;
                width: 100%;
            }
            .btn-back-dashboard:hover {
                background-color: #218838;
            }
            .alert {
                color: red;
                font-weight: bold;
            }
            .success {
                color: green;
                font-weight: bold;
            }
        </style>

        <div class="content">
            ' . $content . '
        </div>';
    }
}

$collaboratorsPage = new CollaboratorsPage();
$collaboratorsPage->Display();
?>

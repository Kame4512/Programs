<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_sql"; // Adjust the database name if necessary

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class CreateTaskPage {
    public function Display() {
        global $conn;

        // Fetch categories from the database
        $sql_categories = "SELECT CategoryID, CategoryName FROM Categories";
        $result_categories = $conn->query($sql_categories);

        // Check if categories are available
        if ($result_categories->num_rows > 0) {
            // Store categories in an array
            $categories = [];
            while ($row = $result_categories->fetch_assoc()) {
                $categories[] = $row;
            }
        } else {
            echo "No categories available.";
            return;
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize form data
            $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
            $priority = mysqli_real_escape_string($conn, $_POST['priority']);
            $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
            
            // Assuming UserId is stored in the session
            session_start();
            $user_id = $_SESSION['UserId'];
            
            // Insert the task into the database, including the UserId and CategoryID
            $sql = "INSERT INTO Tasks (Title, Description, DueDate, Priority, Status, UserID, CategoryID) 
                    VALUES ('$task_name', '$description', '$due_date', '$priority', 'In Progress', '$user_id', '$category_id')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Task added successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Output the form HTML
        echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .form-container {
                width: 40%;
                margin: 50px auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                color: #333;
            }

            label {
                font-size: 16px;
                color: #555;
                margin-bottom: 8px;
                display: block;
            }

            input[type="text"], input[type="date"], select, textarea {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
            }

            textarea {
                resize: vertical;
                height: 100px;
            }

            input[type="submit"] {
                background-color: #28a745;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
            }

            input[type="submit"]:hover {
                background-color: #218838;
            }

            .back-to-dashboard {
                display: block;
                text-align: center;
                margin-top: 20px;
                font-size: 16px;
                color: #007bff;
            }

            .back-to-dashboard:hover {
                text-decoration: underline;
            }
        </style>

        <div class="form-container">
            <h2>Create a New Task</h2>
            <form method="POST" action="">
                <label for="task_name">Task Name:</label>
                <input type="text" id="task_name" name="task_name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>

                <label for="due_date">Due Date:</label>
                <input type="date" id="due_date" name="due_date" required>

                <label for="priority">Priority:</label>
                <select id="priority" name="priority">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>

                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select a Category</option>';

                    // Display categories in the dropdown
                    foreach ($categories as $category) {
                        $selected = (isset($_POST['category_id']) && $_POST['category_id'] == $category['CategoryID']) ? 'selected' : '';
                        echo '<option value="' . $category['CategoryID'] . '" ' . $selected . '>' . $category['CategoryName'] . '</option>';
                    }

        echo '
                </select>

                <input type="submit" value="Save">
            </form>
            <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
        </div>';
    }
}

// Instantiate and display the form
$createTaskPage = new CreateTaskPage();
$createTaskPage->Display();

// Close the database connection
$conn->close();
?>

<?php
session_start(); // Start the session to store user data after login

include('page.php'); // Assuming Page is defined in 'page.php'

class LoginPage extends Page {
    public function __construct() {
        parent::__construct("Login", $this->getLoginForm(), "login, registration");
    }

    private function getLoginForm() {
        // Check if there's an error message to display
        $error_message = isset($_GET['error']) ? $_GET['error'] : '';

        return '
        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f4f4f4;
            }

            h1 {
                text-align: center;
                margin-top: 20px;
            }

            .login-form input {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .login-form button {
                padding: 10px;
                width: 100%;
                background-color: #4CAF50;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
            }

            .register-btn {
                margin-top: 20px;
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .register-btn:hover {
                background-color: #0056b3;
            }

            .error {
                color: red;
                margin-bottom: 10px;
            }
        </style>
        
        <form method="POST" action="">
            <div class="login-form">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Login">
                <p class="error">' . $error_message . '</p>
            </div>
        </form>
        <a href="register.php" class="register-btn">Register</a>'; // Register button
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $mysql = new mysqli("localhost", "root", "", "task_sql");

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch the user data based on username
    $query = "SELECT * FROM users WHERE Username = ?";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        // Verify password
        if ($password === $user['Password']) {
            // Password is correct, start the session and redirect to dashboard
            $_SESSION['UserId'] = $user['UserId'];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION['Role'] = $user['Role'];

            header("Location: dashboard.php"); // Redirect to dashboard after login
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid password. Please try again.";
            $loginPage = new LoginPage();
            echo $loginPage->getLoginForm($error_message); // Pass error message to the form
        }
    } else {
        // User not found
        $error_message = "No user found with that username.";
        $loginPage = new LoginPage();
        echo $loginPage->getLoginForm($error_message); // Pass error message to the form
    }

    // Close the database connection
    $mysql->close();
} else {
    // If no form submitted, just display the login page
    $loginPage = new LoginPage();
    echo $loginPage->Display();
}
?>

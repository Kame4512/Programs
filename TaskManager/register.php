<?php
session_start(); // Start the session

include('page.php'); // Assuming Page is defined in 'page.php'

class RegisterPage extends Page {
    public function __construct() {
        parent::__construct("Register", $this->getRegisterForm(), "register, registration");
    }

    private function getRegisterForm() {
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

            .register-form input, .register-form select {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .register-form button {
                padding: 10px;
                width: 100%;
                background-color: #4CAF50;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
            }

            .error-message {
                color: red;
                font-size: 14px;
            }
        </style>
        
        <form method="POST" action="">
            <div class="register-form">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br><br>
                
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                
                <label for="role">Role:</label><br>
                <select id="role" name="role" required>
                    <option value="student">Student</option>
                    <option value="professional">Professional</option>
                    <option value="freelancer">Freelancer</option>
                </select><br><br>
                
                <input type="submit" value="Register">
                <div class="error-message">' . (isset($_GET['error']) ? $_GET['error'] : '') . '</div>
            </div>
        </form>';
    }
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $mysql = new mysqli("localhost", "root", "", "task_sql");

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    // Get user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Capture role

    // Check if username already exists
    $queryCheckUsername = "SELECT * FROM users WHERE Username = ?";
    $stmtCheckUsername = $mysql->prepare($queryCheckUsername);
    $stmtCheckUsername->bind_param("s", $username);
    $stmtCheckUsername->execute();
    $resultCheckUsername = $stmtCheckUsername->get_result();

    // Check if email already exists
    $queryCheckEmail = "SELECT * FROM users WHERE Email = ?";
    $stmtCheckEmail = $mysql->prepare($queryCheckEmail);
    $stmtCheckEmail->bind_param("s", $email);
    $stmtCheckEmail->execute();
    $resultCheckEmail = $stmtCheckEmail->get_result();

    if ($resultCheckUsername->num_rows > 0) {
        // Username exists, redirect back with error message
        header("Location: register.php?error=Username%20already%20exists.%20Please%20choose%20a%20different%20username.");
        exit();
    } elseif ($resultCheckEmail->num_rows > 0) {
        // Email exists, redirect back with error message
        header("Location: register.php?error=Email%20already%20exists.%20Please%20choose%20a%20different%20email.");
        exit();
    } else {
        // Insert the new user into the database
        $query = "INSERT INTO users (Username, Email, Password, Role) VALUES (?, ?, ?, ?)";
        $stmt = $mysql->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        
        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header("Location: login.php");
            exit();
        } else {
            // Registration failed
            echo "Error: Could not register user.";
        }
    }

    // Close the database connection
    $mysql->close();
} else {
    // If no form submitted, just display the register page
    $registerPage = new RegisterPage();
    echo $registerPage->Display();
}
?>

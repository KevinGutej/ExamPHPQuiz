<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam - Sign In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signin-container {
            width: 400px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .signin-container h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .input-container {
            margin-bottom: 20px;
        }

        .input-container label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        .input-container input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-container input[type="checkbox"] {
            display: inline-block;
            width: auto;
            margin-top: 5px;
        }

        .forgot-password {
            margin-bottom: 20px;
            text-align: right;
        }

        .signin-btn,
        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .signin-btn:hover,
        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="signin-container">
        <h2>Sign In</h2>
        <form id="signinForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-container">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-container">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" pattern="^(?=.*\d).{9,}$" required>
            </div>
            <div class="input-container">
                <input type="checkbox" id="showPassword">
                <label for="showPassword">Show Password</label>
            </div>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" class="signin-btn" name="submit">Sign In</button>
            <div style="margin-top: 10px;"></div>
            <button type="button" class="login-btn" onclick="redirectToLoginPage()">Log In</button>
        </form>
    </div>

    <?php
    $servername = "localhost";
    $username = ""; //fill out
    $password = ""; //fill out

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS ExamQuiz";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully\n";
    } else {
        echo "Error creating database: " . $conn->error . "\n";
    }

    $conn->select_db("ExamQuiz");

    $sql = "CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        dob DATE NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table Users created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $name = $_POST["name"];
        $dob = $_POST["dob"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (name, dob, email, password) VALUES ('$name', '$dob', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Account created successfully. Confirmation email sent to $email');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
    ?>

    <script>
        function redirectToLoginPage() {
            window.location.href = "login.html";
        }

        var showPasswordCheckbox = document.getElementById('showPassword');
        var passwordInput = document.getElementById('password');

        showPasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>

<?php
session_start();

// Hardcoded credentials for demo
$valid_username = "admin";
$valid_password = "123";

// Cookie expiration (7 days)
$cookie_expiration = time() + (7 * 24 * 60 * 60); 

// If user is already logged in via session, redirect to index.php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

// If user has a valid cookie, log them in automatically
if (!isset($_SESSION["loggedin"]) && isset($_COOKIE['remember_me'])) {
    $cookie_data = json_decode($_COOKIE['remember_me'], true);
    
    if ($cookie_data['username'] === $valid_username && $cookie_data['password'] === md5($valid_password)) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $valid_username;
        header("Location: index.php");
        exit;
    }
}

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $remember_me = isset($_POST["remember_me"]);

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;

        // Set a cookie if "Remember Me" is checked
        if ($remember_me) {
            $cookie_value = json_encode([
                "username" => $username,
                "password" => md5($password) // Hash password for security
            ]);
            setcookie("remember_me", $cookie_value, $cookie_expiration, "/");
        }

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 2px solid #ccc;
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 50%;
        }
        button:hover {
            background-color: #218838;
        }
        .remember-me {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }
        .remember-me input {
            width: auto;
            margin-right: 5px;
        }
        p {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Dashboard</h2>
        
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
        
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <div class="remember-me">
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Remember Me</label>
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

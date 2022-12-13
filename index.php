<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: main.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: main.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {

            font-family: Fredoka, sans-serif;
            color: #37383a;
        }

        .logocontainer, img{

        position: absolute;
        height: 100px;
        width: 200px;
        top: 0%;
    }

    img.imagecontainer {
        position: absolute;
        height: 650px;
        width: 650px;
        top: 50px;
        left: 150px;
    }

    p {
        position: absolute;
        font-size: 30px;
        font-weight: 900;
        top: 80%;
        left: 24%;
    }

    a.hypertext {
        position: relative;
        font-size: 20px;
        font-weight: 400;
        padding: 10px;
        top: 30px;
        color: #37383a;
        text-decoration: none;
        left: 75%;
    }

    a.txt-donate {
        position: relative;
        font-size: 20px;
        font-weight: 600;
        padding: 10px;
        top: 30px;
        color: #ffb200;
        text-decoration: none;
        left: 75%;
    }

        .wrapper {
            position: absolute;
            top: 150px;
            right: 100px;
            padding: 20px;
            width: 300px;
            background-color: white;
            border-radius: 20px;
        }

        input {
        height: 30px;
        width: 250px;
        background: transparent;
        border-top: transparent;
        border-right: transparent;
        border-left: transparent;
        padding: 10px;
    }

    h1,
    h5 {
        font-size: 15px;
        font-weight: 600;
    }

    h1 {
        font-size: 50px;
    }

    input.btn-primary {

        margin-top: 20px;
        position: relative;
        font-family: Fredoka;
        font-size: 20px;
        font-weight: 600;
        color: white;
        border: none;
        box-shadow: none;
        border-radius: 20px;
        background-color: #37383a;
        padding: 10px;
        height: 45px;
        width: 90px;

    }

    input.btn-secondary {

        margin-top: 20px;
        position: relative;
        font-family: Fredoka;
        font-size: 20px;
        font-weight: 600;
        color: white;
        border: none;
        box-shadow: none;
        border-radius: 20px;
        background-color: #ff4242;
        padding: 10px;
        height: 45px;
        width: 90px;
        margin-left: 80px;

    }

    .invalid-feedback {

        font-size: 12px;
        font-weight: 500;
        color: #ff4242;

    }

    .button :hover {

        margin-top: 20px;
        position: relative;
        font-family: Fredoka;
        font-size: 20px;
        font-weight: 600;
        color: white;
        border: none;
        box-shadow: none;
        border-radius: 20px;
        background-color: rgb(255, 182, 24);
        padding: 10px;
        height: 45px;
        width: 90px;
    }

    .alert-danger{
        font-weight: 600;
        text-align: center;
        padding: 10px;
        color: #ff4242;
    }
    </style>
</head>

<body>

<div class="logocontainer">
        <img src="images/logo.PNG" alt="logo">
    </div>
        
    <img class="imagecontainer" src="images/dedlifriends.PNG" alt="dedlifriends">

    <p>kill all your deadlines.</p>

    <a href="" class="hypertext">About</a>
    <a href="" class="hypertext">Community |  </a>
    <a href="" class="txt-donate">Donate</a>

    <div class="wrapper">
        <h1>Login</h1>
        <?php
        if (!empty($login_err)) {
            echo '<div class="alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder = "Enter Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder = "Enter Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="button">
                <input type="submit" class="btn-primary" value="Login">
            </div>
            <h5>Don't have an account? <a href="register.php">Sign up now</a>.</>
        </form>
    </div>
</body>

</html>
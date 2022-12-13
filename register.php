<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: index.php");
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
    <title>Sign Up</title>

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
            top: 110px;
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
        <h1>Sign Up</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Create Username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $username; ?>">
                <span class="invalid-feedback">
                    <?php echo $username_err; ?>
                </span>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Create Password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>">
                <span class="invalid-feedback">
                    <?php echo $password_err; ?>
                </span>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>
            <div class="button">
                <input type="submit" class="btn-primary" value="Submit">
                <input type="reset" class="btn-secondary" value="Reset">
            </div>
            <h5>Already have an account? <a href="index.php">Login</a>.</h5>
        </form>
    </div>
</body>

</html>
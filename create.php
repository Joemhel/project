<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$socialplatform = $duedate = $subscriptionfee = "";
$socialplatform_err = $duedate_err = $subscriptionfee_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate social platform
    $input_socialplatform = trim($_POST['socialplatform']);
    if (empty($input_socialplatform)) {
        $socialplatform_err = "Please enter the platform.";
    } elseif (!filter_var($input_socialplatform, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $socialplatform_err = "Please enter a valid platform.";
    } else {
        $socialplatform = $input_socialplatform;
    }

    // Validate $subscriptionfee
    $input_subscriptionfee = trim($_POST['subscriptionfee']);
    if (empty($input_subscriptionfee)) {
        $subscriptionfee_err = "Please enter the amount of payment.";
    } elseif (!ctype_digit($input_subscriptionfee)) {
        $subscriptionfee_err = "Please enter a positive integer value.";
    } else {
        $subscriptionfee = $input_subscriptionfee;
    }

    // Validate duedate
    $input_duedate = trim($_POST['duedate']);
    if (empty($input_duedate)) {
        $duedate_err = "Please enter subscription due date.";
    } else {
        $duedate = $input_duedate;
    }



    // Check input errors before inserting in database
    if (empty($socialplatform_err) && empty($duedate_err) && empty($subscriptionfee_err)) {
        // Prepare an insert statement
        $sql = 'INSERT INTO subscription (socialplatform , duedate , subscriptionfee ) VALUES (?,?,?)';

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $param_socialplatform, $param_duedate, $param_subscriptionfee);

            // Set parameters
            $param_socialplatform = $socialplatform;
            $param_duedate = $duedate;
            $param_subscriptionfee = $subscriptionfee;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: main.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {

            background-color: #E0E0E0;
            font-family: Fredoka, sans-serif;
            color: #37383a;
        }

        .wrapper {
            position: absolute;
            left: 37%;
            top: 110px;
            padding: 30px;
            width: 275px;
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

        p {
            position: relative;
            font-size: 13px;
        }

        input.btn-primary {

            margin-top:60px;
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

        a {

            margin-top: 60px;
            position: relative;
            text-decoration: none;
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
            margin-left: 95px;

        }

        .button :hover {

            margin-top: 60px;
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

        h1 {
            margin-top:10px;
            margin-bottom: 1px;
            font-size: 50px;
            font-weight: 600;
        }

        .form-group {

            position: relative;

            top: 20px;
            bottom: 20px;
        }

        .invalid-feedback {

        font-size: 12px;
        font-weight: 500;
        color: #ff4242;

        }

    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Create Record</h2>
                    <p>Please fill this form and submit to add Subscription record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <input type="text" name="socialplatform" placeholder="Subscription Name" class="form-control <?php echo (!empty($socialplatform_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $socialplatform; ?>">
                            <span class="invalid-feedback"><?php echo $socialplatform_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type = "date" name="duedate" class="form-control <?php echo (!empty($duedate_err)) ? 'is-invalid' : ''; ?>"><?php echo $duedate; ?></textarea>
                            <span class="invalid-feedback"><?php echo $duedate_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subscriptionfee" placeholder="Subscription Fee" class="form-control <?php echo (!empty($subscriptionfee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subscriptionfee; ?>">
                            <span class="invalid-feedback"><?php echo $subscriptionfee_err; ?></span>
                        </div>

                        <div class="button">
                            <input type="submit" class="btn-primary" value="Submit">
                            <a href="main.php" class="btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
// Iclude config file
require_once "config.php";

// Define variables and initialize with empty values
$socialplatform = $duedate = $subscriptionfee = "";
$socialplatform_err = $duedate_err = $subscriptionfee_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate socialplatform
    $input_socialplatform = trim($_POST["socialplatform"]);
    if (empty($input_socialplatform)) {
        $socialplatform_err = "Please enter the platform.";
    } elseif (!filter_var($input_socialplatform, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $socialplatform_err = "Please enter a valid social platform.";
    } else {
        $socialplatform = $input_socialplatform;
    }

    // Validate duedate 
    $input_duedate = trim($_POST["due date"]);
    if (empty($input_duedate)) {
        $duedate_err = "Please enter due date.";
    } else {
        $duedate = $input_duedate;
    }

    // Validate subscriptionfee
    $input_subscriptionfee = trim($_POST["subscription fee"]);
    if (empty($input_subscriptionfee)) {
        $subscriptionfee_err = "Please enter the subscription fee amount.";
    } elseif (!ctype_digit($input_subscriptionfee)) {
        $subscriptionfee_err = "Please enter a positive integer value.";
    } else {
        $subscriptionfee = $input_subscription;
    }

    // Check input errors before inserting in database
    if (empty($socialplatform_err) && empty($duedate_err) && empty($subscriptionfee_err)) {
        // Prepare an update statement
        $sql = "UPDATE subscription SET socialplatform=?, duedate=?, subscriptionfee=? WHERE id=?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssi", $param_socialplatform, $param_duedate, $param_subscriptionfee, $param_id);

            // Set parameters
            $param_socialplatform = $socialplatform;
            $param_duedate = $duedate;
            $param_subscriptionfee = $subscriptionfee;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
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
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM subscription WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $socialplatform = $row["SocialPlatform"];
                    $duedate = $row["DueDate"];
                    $subscriptionfee = $row["SubscriptionFee"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();

        // Close connection
        $mysqli->close();
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

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
            margin-left: 80px;

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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the Subscription record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <input type="text" name="socialplatform" class="form-control <?php echo (!empty($socialplatform_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $socialplatform; ?>">
                            <span class="invalid-feedback"><?php echo $socialplatform_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="date" name="duedate" class="form-control <?php echo (!empty($duedate_err)) ? 'is-invalid' : ''; ?>"><?php echo $duedate; ?></input>
                            <span class="invalid-feedback"><?php echo $duedate_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subscriptionfee" class="form-control <?php echo (!empty($subscriptionfee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subscriptionfee; ?>">
                            <span class="invalid-feedback"><?php echo $subscriptionfee_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="main.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
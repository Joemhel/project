<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM subscription WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

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
                // URL doesn't contain valid id parameter. Redirect to error page
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>

        body {

            font-family: Fredoka, sans-serif;
            color: #37383a;
        }

        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        .dd {
            position: absolute;
            top: 85px;
            left: 40%;
        }

        .sp {

            position: absolute;
            top: 85px;
        }

        .sf {

            position: absolute;
            top:85px;
            left: 50%;
        }

        img.imagecon{

            position: absolute;
            height: 500px;
            height: 500px;
            left: 27%;
            top: 120px;
        }

        a.btn{

            position: absolute;
            top: 78%;
            left: 45%;
            background-color: #37383a;
            color: white;
            border-radius: 20px;    
            padding: 10px;    
            width: 50px;
            height: 20px;
            text-decoration: none;
            text-align: center;
        }



    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Your Record</h1>
                    <div class="sp">
                        <label>Social Platform:</label>
                        <p><b><?php echo $row["SocialPlatform"]; ?></b></p>
                    </div>
                    <div class="dd">
                        <label>Due date:</label>
                        <p><b><?php echo $row["DueDate"]; ?></b></p>
                    </div>
                    <div class="sf">
                        <label>Subscription fee:</label>
                        <p><b><?php echo $row["SubscriptionFee"]; ?></b></p>
                    </div>

                    <img class = "imagecon" src="images/flowerkid.png" alt = "flowerkid_img">

                    <a href="main.php" class="btn">Back</a>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
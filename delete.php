<?php
// Process delete operation after confirmation
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Include config file
    require_once "config.php";

    // Prepare a delete statement
    $sql = "DELETE FROM subscription WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Records deleted successfully. Redirect to landing page
            header("location: main.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else {
    // Check existence of id parameter
    if (empty(trim($_GET["id"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>

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
            width: 300px;
            height: 400px;
            padding: 10px;
            border-radius: 20px;
            background-color: white;
            left: 40%;
            top: 20%;
        }

        h2 {

            position: relative;
            color:  #ff4242;
            top:1px;
            left: 20px;
        }

        a.btn {

            position: relative;
            top: 220px;
            left: 130px;
            text-decoration: none;
            font-family: Fredoka;
            font-size: 20px;
            font-weight: 600;
            color: white;
            border: none;
            box-shadow: none;
            border-radius: 20px;
            background-color: #37383a;
            padding: 10px;

        }

        p.confirmtext {

            position: relative;
            font-size: 15px;
            left: 20px;
            margin-right: 25px;
        }

        input.btn {

            position: relative;
            top: 220px;
            left:20px;
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
            width: 70px;
        }

        img.imagecon{

            position: absolute;
            height: 200px;
            height: 200px;
            left: 50px;
        }
    
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Are you sure?</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p class = "confirmtext">Do you really want to delete this subscription record?</p>
                            <img class = "imagecon" src="images/trash.png" alt = "trash_img">
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="main.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
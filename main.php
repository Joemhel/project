<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {

            font-family: Fredoka, sans-serif;
            color: #37383a;
        }

        h1 {

            position: relative;
            top: 190px;
            font-size: 30px;
            font-weight: 400;
        }

        h2.banner {
            position: absolute;
            font-weight: 600;
            font-size: 50px;
            top: 100px;
            padding-bottom: 50px;
            left: 29%;
        }

        img.handimg {

            position: absolute;
            height: 450px;
            width: 450px;
        }

        img.peakimg {

            position: absolute;
            top: 100px;
            left: 70.5%;
            height: 450px;
            width: 450px;
        }

        .wrapper {
            position: relative;
            width: 600px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }

        .mr-3 {

            color: #37383a;
        }

        .fa-trash {

            color: #ff4242;
        }

        a.button {

            position: relative;
            top: 210px;
            left: 82%;
            text-decoration: none;
            border-radius: 10px;
            padding: 10px;
            background-color: #ffb200;
            color: white;
        }

        a.logoutbtn {

            position: relative;
            top: 20px;
            left: 90%;
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
            height: 45px;
            width: 90px;
        }

        .sortbtn {

            position: relative;
            top: 160px;
            text-decoration: none;
            box-shadow: none;
            border-radius: 10px;
            border-color: #37383a;
            padding: 5px;
            background-color: transparent;
            color: #37383a;

        }

        .filter {

            position: relative;
            top: 160px;
            border-radius: 10px;
            padding: 8px;
            margin-bottom: 20px;
        }

        table {
            position: relative;
            top: 150px;
        }

        .alert {

            position: relative;
            top: 200px;
        }

        b {
            color: #ffb200;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>

    <img class="handimg" src="images/hand.PNG" alt="hand">
    <img class="peakimg" src="images/peak.PNG" alt="peak">


    <a href="logout.php" class="logoutbtn">Sign Out</a>
    <h2 class="banner">Hi, <b>
            <?php echo htmlspecialchars($_SESSION["username"]); ?>.
        </b> Welcome to Dedli!</h2>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h1>Subscription Details</h1>
                        <a href="create.php" class="button"><i class="fa fa-plus"></i> Add New</a>
                    </div>

                    <form>
                        <select name="sortBy" class="filter">
                            <option value="id">ID</option>
                            <option value="SocialPlatform">Subscription Name</option>
                            <option value="DueDate">Due Date</option>
                            <option value="SubscriptionFee">Subscription Fee</option>
                        </select>
                        <button type="submit" class="sortbtn" formaction="?" formmethod="post">Sort </button>
                    </form>


                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM subscription";
                    if ($result = $mysqli->query($sql)) {


                        $sortBy = (isset($_POST['sortBy']) ? $_POST['sortBy'] : NULL);
                        $sql = 'SELECT * FROM subscription';
                        if ($sortBy != NULL) {
                            $sql .= ' ORDER BY ' . $sortBy;
                        }
                        $result = $mysqli->query($sql);
                        if (mysqli_num_rows($result) > 0) {



                            if ($result->num_rows > 0) {
                                echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Subscription Name</th>";
                                echo "<th>Subscription Fee</th>";
                                echo "<th>Due Date</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_array()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['SocialPlatform'] . "</td>";
                                    echo "<td>" . $row['SubscriptionFee'] . "</td>";
                                    echo "<td>" . $row['DueDate'] . "</td>";
                                    echo "<td>";
                                    echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                    echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                    echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    $mysqli->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
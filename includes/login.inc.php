<?php

// Check if the user access this page by clicking login button
if (isset($_POST['login-submit'])) {

    // We grab the connection to the database
    require "dbh.inc.php";

    // Fetch all the information the user passed on the login form and put it into variables
    $username = $_POST["username"];
    $password = $_POST["password"];

    // We check if the user let the fields empty
    if (empty($username) || empty($password)) {
        // We send back the user to the index page with an error message
        header("Location: ../index.php?error=emptyfields");
        exit();
    } else {
        // We check the database to see if there is a user that have this username and this password when he tried to login to the web site
        // We run a SQL statement that we want to send to the database
        // We use placeholders and prepared statements for security reasons
        $sql = "SELECT * FROM users WHERE username=?;";
        // We initialise a new statement with the correct connection ($conn)
        $stmt = mysqli_stmt_init($conn);

        // We run the SQL statement and at the same time check if it does actually work inside the database
        // First we check if it doesn't work
        // We preaparing the statement by running the SQL string inside the database and checking if this specific statement that we created up here have any kind of errors inside of it
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            // We grab the information that we got from the $sql statement up here
            // We want to pass the parameters from the user input when trying login to the web site into the database and see if we can get a result from this SQL statement ($sql)
            mysqli_stmt_bind_param($stmt, "s", $username);
            // We execute the statement to bind it to the parameter up here
            mysqli_stmt_execute($stmt);
            // We executed it and grab the actual result and store it in a variable $result
            $result = mysqli_stmt_get_result($stmt);
            // We have to check if the $result is empty or not
            if ($row = mysqli_fetch_assoc($result)) {
                $pwd_check = password_verify($password, $row["password"]);
                if ($pwd_check == false) {
                    header("Location: ../index.php?error=wrongpassword");
                    exit();
                } elseif ($pwd_check == true) {
                    session_start();
                    $_SESSION["users_id"] = $row["id"];
                    $_SESSION["users_user"] = $row["username"];
                    header("Location: ../facebook/index.html");
                    exit();
                } else {
                    header("Location: ../index.php?error=wrongpassword");
                    exit();
                }
            } else {
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }

} else {
    // if the user try to access this page without clicking the signup button, we send him back to the index page
    header("Location: ../index.php");
    exit();
}

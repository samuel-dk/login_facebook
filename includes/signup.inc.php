<?php
// Check if the user access this page by clicking signup button
if (isset($_POST['signup-submit'])) {

    // We grab the connection to the database
    require "dbh.inc.php";

    // Fetch all the information the user passed on the signup form and put it into variables
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];

    // Check if the user make a mistake inside the website by using error handlers
    if (empty($username) || empty($email) || empty($password) || empty($password_repeat)) {
        // if empty password field send back the user to signup page with the username and email field fill
        header("Location: ../signup.php?error=emptyfields&uid=" . $username . "&mail=" . $email);
        exit(); // Stop the script from running
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        // if invalid or empty (email and/or username) field send back the user to signup page with all empty fields
        header("Location: ../signup.php?error=invalidmailuid");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // if invalid or empty email field send back the user to signup page with the username field fill
        header("Location: ../signup.php?error=invalidmail&uid=" . $username);
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        // if invalid or empty username field send back the user to signup page with the email field fill
        header("Location: ../signup.php?error=invaliduid&mail=" . $email);
        exit();
    } elseif ($password !== $password_repeat) {
        // if the password doesn't match the password repeat send back the user to signup page with the username and email field fill
        header("Location: ../signup.php?error=passwordcheck&uid=" . $username . "&mail=" . $email);
        exit();
    } else {
        // if the user try to signin with a username that already exist in the database
        // try to see if there is no user that already register with this username
        // we use prepared statement, placeholders to prevent sql injections
        // Running an SQL Injection Attack - Computerphile: https://www.youtube.com/watch?v=ciNHn38EyRc
        // Hacking Websites with SQL Injection - Computerphile: https://www.youtube.com/watch?v=_jKylhJtPmI
        $sql = "SELECT username FROM users WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);

        // if the statment fail send the user to the signup page with an error message
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        } else {
            // we take the information the user gave us and put it inside the database using the previous sql statement
            // we bind the parameters from the user to the statement we created up
            mysqli_stmt_bind_param($stmt, "s", $username);
            // we execute our data from the user together with the SQL statement we created up
            // it will run the information into the database
            mysqli_stmt_execute($stmt);
            // we store the result into the variable $stmt
            mysqli_stmt_store_result($stmt);
            // we check how many result we have into the variable $stmt
            $result_check = mysqli_stmt_num_rows($stmt);

            if ($result_check > 0) {
                // if the result is greater than 0 we send back the user to signup page with the email field fill
                header("Location: ../signup.php?error=usertaken&mail=" . $email);
                exit();
            } else {
                // we run a SQL statement that will insert into the database the user data by using a prepared statement
                $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?);";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                } else {
                    // we hash the password using bcrypt: https://en.wikipedia.org/wiki/Bcrypt
                    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_pwd);
                    // we insert the datas in the database
                    mysqli_stmt_execute($stmt);
                    // we return the user to the login page with a sucess message
                    header("Location: ../login.php?signup=success");
                    exit();
                }
            }
        }
    }
    // we close the statement and the connection to the database in order to save ressources
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // if the user try to access this page without clicking the signup button, we send him back to the index page
    header("Location: ../index.php");
    exit();
}

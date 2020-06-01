<?php
include "dbh.inc.php";

if (!isset($_GET["code"])) {
    exit("401: Unauthorized");
}

$code = $_GET["code"];

$get_email_query = mysqli_query($conn, "SELECT email FROM reset_passwords WHERE code='$code'");

if (mysqli_num_rows($get_email_query) == 0) {
    exit("404: Not Found");
}

if (isset($_POST["password"])) {
    $pwd = $_POST["password"];
    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

    $row = mysqli_fetch_array($get_email_query);
    $email = $row["email"];

    $query = mysqli_query($conn, "UPDATE users SET password='$hashed_pwd' WHERE email='$email'");

    if ($query) {
        $query = mysqli_query($conn, "DELETE FROM reset_passwords WHERE code='$code'");
        exit("Password Updated");
    } else {
        exit("Something went wrong");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style_signup.css">
    <title>Reset Password</title>
</head>

<body>
    <div class="container">

        <form method="POST">
            <div class="container">

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter a new Password" name="password" value="Update Password"
                    required>


                <div class="clearfix">
                    <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
                    <button type="submit" name="submit" class="signupbtn">Reset Password</button>
                </div>
            </div>
        </form>
</body>

</html>

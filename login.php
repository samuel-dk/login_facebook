<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/style_login.css">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form action="includes/login.inc.php" method="POST">
        <div class="imgcontainer">
            <img src="img/user_0.svg" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit" name="login-submit">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>
        <div class="container" style="background-color:#f1f1f1">
            <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
            <span class="psw">Forgot <a href="includes/reset_request.inc.php">password?</a></span>
        </div>
    </form>
</body>

</html>
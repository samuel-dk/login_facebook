<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/style_signup.css">
    <title>Sign Up</title>
</head>

<body>
    <form action="includes/signup.inc.php" method="POST">
        <div class="container">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="password_repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="password_repeat" required>

            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
            </label>

            <p>By creating an account you agree to our <a href="https://www.facebook.com/terms.php" title="Facebook"
                    target="_blank" style="color:dodgerblue">Terms & Privacy</a>.</p>

            <div class="clearfix">
                <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
                <button type="submit" class="signupbtn" name="signup-submit">Sign Up</button>
            </div>
        </div>
    </form>
</body>

</html>
<?php
session_start();
if (isset($_SESSION['id'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <?php include 'modules/config.php' ?>
    <?php include 'modules/staticFiles.php' ?>
</head>
<style>
    body{
background-color:#4BCFFA;
    }
    form {
        margin: 10px;
        width: 95%;
        border-radius: 27px;
        background-color: #ffffff;
    }

    h2 {
        padding-top: 100px;
    }

    form input {
        font-family: Montserrat-Bold;
        font-size: 15px;
        color: #1b3815;
        color: #333;
        line-height: 1.2;
        display: block;
        width: 90%;
        height: 45px;
        background: #ebebeb;
        background: transparent;
        padding: 0 35px;
        border-radius: 27px;
    }

    #submit {
        background-color: #25CCF7;
        
    }
    h4{
        padding-top:50px;
        padding-bottom:50px;
        font-size: inherit;
    }
    h6{
        color: #007bff;
    }
</style>

<body>
    <center>
       
        <form action="auth.php" method="post">
        <h2>Welcome</h2>
        <h6>Please login</h6><br>
            <input type="email" name="email" id="email" placeholder="Email" required><br><br>
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off"><br><br>
            <input type="submit" value="Login" id='submit'>
            <h4 id="signup"><a href="signup.php">Don't have an account? Sign up</a></h4>
        </form>
    </center>
</body>

</html>
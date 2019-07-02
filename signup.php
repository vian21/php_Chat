<?php
session_start();
if (isset($_SESSION['id'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="src/js/jquery.js"></script>
    <link rel="stylesheet" href="src/css/bootstrap.css">
    <title>Signup</title>
</head>
<style>
    body {
        background-color: #4BCFFA;
        margin: 0;
        align-content: center;
    }

    form {
        margin: 10px;
        width: 95%;
        border-radius: 27px;
        background-color: #ffffff;
    }

    img {
        width: 250px;
        height: 250px;
        border-radius: 50%;
        object-fit:cover;
    }

    form input {
        font-family: Montserrat-Bold;
        font-size: 15px;
        color: #1b3815;
        color: #333;
        line-height: 1.2;
        display: block;
        height: 45px;
        background: #ebebeb;
        background: transparent;
        padding: 0 35px;
        border-radius: 27px;
        width: 80%;
    }

    #submit {
        margin-top: 50px;
        padding: 0 35px;
        border-radius: 27px;
        font-family: Montserrat-Bold;
        font-size: 15px;
        color: #1b3815;
        color: #333;
        background-color: #25CCF7;
        height: 45px;
        display: block;
        width: 80%;

    }

    h4 {
        padding-top: 50px;
        padding-bottom: 50px;
        font-size: inherit;
    }

    h6 {
        color: #007bff;
    }
</style>

<body>
    <center>
        <form enctype="multipart/form-data" id="form">
            <img src="src/img/user.png" alt="img" id="img">
            <input type="file" name="image" id="imgChoose">
            <h4>Name</h4>
            <input type="text" name="name" id="name" autocomplete="off" required>
            <h4>Telephone Number</h4>
            <input type="tel" name="tel" id="tel" autocomplete="off" required>
            <h4>Email</h4>
            <input type="email" name="email" id="email" required autocomplete="off">
            <h4>Password</h4>
            <input type="password" name="password" id="password" autocomplete="off" required>
            <button type="submit" name="submit" id="submit">Sign up</button>
            <br>
            <br>
        </form>
    </center>
    <script>
        $(document).ready(function() {
            $("#submit").click(function() {
                event.preventDefault();
                //var form = $("#form")[0];
                var fd = new FormData();
                var imgFile = $("#imgChoose")[0].files[0];
                var name = $("#name").val();
                var tel = $("#tel").val();
                var email = $("#email").val();
                var password = $("#password").val();
                fd.append('name', name);
                fd.append('tel', tel);
                fd.append('email', email);
                fd.append('password', password);
                fd.append('img', imgFile);
                $.ajax({
                    method: "post",
                    url: "modules/signup.php",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data: fd,
                    success: function(response) {
                        if (response == "ok") {
                            window.location.replace("index.php");

                        }
                        if (response == "ko") {
                            alert("Failed to create user account")
                        }
                        if (response == "exists") {
                            alert("Email already taken. Use another one!")
                        }
                    }
                })
            })
            //If user selects an image
            $("#imgChoose").change(function() {
                readURL(this);
            });
        });
        //Get the image location and ajax preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
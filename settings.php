<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
    <?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location:index.php");
    }
    $id = $_SESSION['id'];
    include 'modules/functions.php' ?>
</head>
<style>
    body {
        margin: 0;
        background-color: #4BCFFA;
        display: block;
        font-family: arial;
    }

    .navbar {
        text-align: center;
        width: 100%;

        background-color: #333;

        top: 0;


    }

    .navbar span {
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 18px;

    }

    #cancel {
        float: left;
        padding-top: 14px;
    }

    #cancel:hover {
        background: #ddd;
        color: black;
    }

    #edit {
        margin: 0 auto;
        display: inline-block;
        padding-top: 14px;
    }

    #save {
        float: right;
        padding-right: 10px;
    }

    #save:hover {
        background: #ddd;
        color: black;
    }

    #form {
        margin-top: 10px;
        width: 95%;
        border-radius: 27px;
        background-color: #ffffff;
    }

    img {
        margin-top: 50px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        object-fit: cover;
    }

    #form input {
        font-family: arial;
        font-size: 15px;
        display: block;
        height: 45px;
        background-color: #ebebeb;
        background-color: transparent;
        padding: 0 20px;
        border-radius: 27px;
    }
</style>

<body>
    <div class="navbar">
        <span id="cancel">&times;</span>
        <span id="edit">Edit settings</span>
        <span id=save style="float:right">&#10004;</span>
    </div>
    <center>
        <form enctype="multipart/form-data" id="form">

            <img src="src/img/uploaded/<?php echo fetchImage($id); ?>" alt="" id='img'>
            <input type="file" id="imgChoose">
            <h4>Name</h4>
            <input type="text" name="name" id="name" value="<?php echo fetchName($id); ?>">
            <h4>Phone</h4>
            <input type="tel" name="phone" id="phoneNumber" value=<?php echo fetchPhone($id); ?>>
            <br>
            <br>

        </form>
    </center>
    <script src='src/js/jquery.js'></script>
    <script>
        $(document).ready(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imgChoose").change(function() {
                readURL(this);
            });
            var imageChanged = false;
            $("#imgChoose").change(function() {
                imageChanged = true;
            })
            $("#save").click(function() {
                var form_data = new FormData();
                var newName = $("#name").val();
                var newPhoneNumber = $("#phoneNumber").val();
                form_data.append('changeSettings', 'true')
                form_data.append('name', newName);
                form_data.append('phone', newPhoneNumber);
                if (imageChanged == true) {
                    var newImage = $("#imgChoose")[0].files[0];
                    form_data.append('img', newImage);
                }
                $.ajax({
                    method: "post",
                    url: "modules/saveSettings.php",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data: form_data,
                    success: function(response) {
                        if (response == "ok") {
                            window.location.replace("index.php");
                        } else {
                            alert("Failed to save new settings")
                        }
                    }
                })
            })
            $("#cancel").click(function() {
                window.location.replace("index.php");
            })
        });
    </script>
</body>

</html>
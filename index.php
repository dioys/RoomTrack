<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/images/index.png'); 
            background-size: 1600px 770px;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #000000;
        }

        /* Container for the buttons */
        .index {
            position: absolute;
            left: 350px;
            top: 40%;
            transform: translateY(-50%); 
            text-align: center;
            display: flex;
            flex-direction: column; 
            gap: 60px; 
        }

       
        .BUTTON {
            display: inline-block;
            padding: 15px 40px;
            font-size: 24px;
            color: #1d1d1d;
            background-color: #fbfb00;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            width: 300px; 
            text-align: center;
            font-family: "Arial", sans-serif;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .BUTTON:hover {
            background-color: #ffee00;
            transform: translateY(-5px); 
        }

        .BUTTON:active {
            transform: translateY(2px); 
        }
    </style>
</head>
<body>

    <div class="index">
        <!-- Buttons with the CSS design -->
        <a href="auth/register.php" class="BUTTON">Login</a>
        <a href="auth/regform.php" class="BUTTON">Register</a>
        <a href="auth/visitor_login.php" class="BUTTON">Visitor</a>
    </div>

</body>
</html>


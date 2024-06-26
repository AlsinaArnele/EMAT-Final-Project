<!--php
    session_start();
    if(isset($_SESSION['mysession'])){
        header('Location: homepage.php');
    }
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EMAT | Log In</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/signup.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include 'php/connect.php';
        ?>
        <div class="container"> 
            <div class="left">
                <h1>Elevating <span style="color: green;">Campus</span><br/> Mobility<br/></h1>
                <p>Streamlined Transport Solution for <span style="color: red;">Students</span></p>
                <img src="Images/Login-image.png" alt="image">
            </div>
            <div class="middle">
                <img src="Images/logo.png" alt="">
                <h1>EMAT</h1>
            </div>
            <form action="php/login.php" method="post" class="right">
                <h1>Login to your account</h1>
                <div class='error' >
                    <p id='error-message'></p>
                    <?php
                        if (isset($_GET['feedback'])) {
                            $feedback = urldecode($_GET['feedback']);
                            echo "<p>" . htmlspecialchars($feedback) . "</p>";
                        }
                    ?>
                </div>
                <div class="input">
                    <h3>EMAIL ADDRESS</h3>
                    <input type="text" placeholder="&#xF0e0;  Enter Your Email" id="Email" name="Email" style="font-family:Arial, FontAwesome" required>
                </div>
                <div class="input">
                    <h3>PASSWORD</h3>
                    <input type="hidden" id="logTime" name="time">
                    <input type="password" placeholder="&#xF023;  Enter Your Password" id="Password" name="Password" style="font-family:Arial, FontAwesome;" required>
                </div>
                <div id="google-container">
                    <button type="submit" class="submit-button">LOGIN</button>
                    <p>New here?<a href="signup.php">Register</a></p>
                    <p>Forgot password?<a href="forgot.html">Reset</a></p>
                </div>
            </form>
        </div>
    </body>
</html>
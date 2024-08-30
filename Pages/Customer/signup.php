<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EMAT | Sign Up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="../../css/signup.css" rel="stylesheet">
        <script src="js/app.js"></script>
    </head>
    <body id="mainbody">
        <div class="container"> 
            <div class="left">
                <h1>Elevating <span style="color: green;">Campus</span><br/>Mobility</h1>
                <p>Streamlined Transport Solution for <span style="color: red;">Students.</span></p>
                <img src="../../Images/Login-image.png" alt="image">
            </div>
            <div class="middle">
                <img src="Images/logo.png" alt="">
                <h1>EMAT</h1>
            </div>
            <form action="../../php/signup.php" method="post" class="right">
                <h1>Register an Account</h1>
                <div class='error' >
                    <?php
                        if (isset($_GET['feedback'])) {
                            $feedback = urldecode($_GET['feedback']);
                            echo "<p>" . htmlspecialchars($feedback) . "</p>";
                        }else{
                            echo "<p id='error-message'></p>";
                        }
                    ?>
                </div>
                <div class="input">
                    <h3>USERNAME</h3>
                    <input type="text" placeholder="&#xF0e0;  Enter Your Username" id="Username" name="Username" style="font-family:Arial, FontAwesome" required>
                </div>
                <div class="input">
                    <h3>EMAIL ADDRESS</h3>
                    <input type="email" placeholder="&#xF0e0;  Enter Your Email" id="Email" name="Email" style="font-family:Arial, FontAwesome" required>
                </div>
                <div class="input">
                    <h3>PHONE NUMBER</h3>
                    <input type="email" placeholder="&#xF0e0;  Enter Your Phone (254XX-XXX-XXX)" id="Phne" name="Phone" style="font-family:Arial, FontAwesome" required>
                </div>
                <div class="input">
                    <h3>PASSWORD</h3>
                    <input type="password" placeholder="&#xF023;  Enter Your Password" id="Password" name="Password" style="font-family:Arial, FontAwesome;" required>
                </div>
                <div class="input">
                    <h3>CONFIRM PASSWORD</h3>
                    <input type="password" placeholder="&#xF023;  Confirm Password" id="confirm-password" name="confirm-password" style="font-family:Arial, FontAwesome" required>
                </div>
                <div id="google-container">
                    <button id="registerbutton">SIGN UP</button>
                    <p>Already registered?<a href="index.php">  Log in</a></p>
                </div>
            </form>
        </div>
    </body>
</html>
<script>
    var email = document.getElementById('Email');
    var pass = document.getElementById('Password');
    var confirm_pass = document.getElementById('confirm-password');
    var error = document.getElementById('error-message');
    var button = document.getElementById('registerbutton');
    var form = document.querySelector('form');
    button.addEventListener('click', function(e){
        if(pass.value != confirm_pass.value){
            e.preventDefault();
            error.innerHTML = 'Passwords do not match';
        }
        else if(pass.value.length < 8){
            e.preventDefault();
            error.innerHTML = 'Password must be at least 8 characters long';
        }
        else if(pass.value.length > 20){
            e.preventDefault();
            error.innerHTML = 'Password must be at most 20 characters long';
        }
        else if(!email.value.includes('@') || !email.value.includes('.')){
            e.preventDefault();
            error.innerHTML = 'Invalid email';
        }
        else{
            form.submit();
        }
    });

</script>
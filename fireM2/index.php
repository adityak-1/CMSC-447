<?php 
/*
 * Team Name: FIRE^2 (First Responder Framework Improvement Researchers)
 * Product Name: FIRE-M^2 (First Responder Mission Management)
 * File Name: index.php
 *
 * Date Last Modified: December 2, 2018 (Stanislav Babenko)
 *
 * Copyright: (c) 2018 by FIRE^2
 * and all corresponding participants which include:
 * Aditya Kaliappan
 * Lorenzo Neil
 * Robert Duguay
 * Stanislav Babenko
 * Daniel Volinski
 *
 * File Description:
 * This file contains the main page with the map and log in form.
 */

require 'db.php';
session_start();

//set user role to general public
$_SESSION['role'] = 'GP';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Fire M2</title>
    <?php include 'css/css.html'; ?>
</head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';
        
    }
}
?>

<body>
    <!--<img src="img/FIRE_M_LOGO.png" alt="FIRE-M"">-->
    <div class="bigTitle">FIRE-M<p class="sup">2</p>
    </div>
    <br>
    <div class="form">
        <div id="login">
            <div class="loginFormTopBuffer">
            <br> <br> <br>
            </div>
            <h1>Welcome</h1>

            <form action="index.php" method="post" autocomplete="off">

                <div class="field-wrap">
                    <label style="color:white;">Email Address<span class="req">*</span>
                    </label>
                    <input type="email" maxlength="80" required autocomplete="off" name="email" />
                </div>

                <div class="field-wrap">
                    <label style="color:white;">Password<span class="req">*</span>
                    </label>
                    <input type="password" maxlength="100" required autocomplete="off" name="password" />
                </div>

                <button class="button button-block loginButton" name="login" />Login</button>

            </form>

        </div>

    </div> <!-- /form -->

    <div class="footer loginfooter">Powered by First Responder Framework Improvement Researchers</div><!-- /footer -->

    <?php include 'incident_map.php'; ?>
    <?php include 'clock.php'; ?>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>

    <script>
        //initialize map to display heatmap of unassigned events
        dispPoints(false);

    </script>

</body>

</html>

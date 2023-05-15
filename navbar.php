<?php 
include_once __DIR__ .'/database/connection_users.php';
session_start();
if (!isset($_SESSION['user_id'])):?>

    <header class="header fixed-top">

        <div class="container">

            <div class="row align-items-center justify-content-between">
                <!-- <img src="images/telecarely.png" alt=""> -->

                <a href="#home" class="logo">TELE<span>Carely.</span></a>

                <nav class="nav">
                    <a href="#home">home</a>
                    <a href="#about">about</a>
                    <a href="#reviews">reviews</a>
                    <!-- <a href="#contact">contact</a> -->
                </nav>

                <a style=" margin-right: -230px;font-size: 1.7rem; color: var(--blue);" href="login.php">Login</a>
                <a style=" font-size: 1.7rem; color: var(--blue);" href="signup.php">Sing Up</a>


                <div id="menu-btn" class="fas fa-bars"></div>

            </div>

        </div>

    </header>

    <?php else:?>
        <header class="header fixed-top">

        <div class="container">

            <div class="row align-items-center justify-content-between">
                <!-- <img src="images/telecarely.png" alt=""> -->

                <a href="#home" class="logo">TELE<span>Carely.</span></a>

                <nav class="nav">
                    <a href="#home">home</a>
                    <a href="#about">about</a>
                    <a href="#reviews">reviews</a>
                    <!-- <a href="#contact">contact</a> -->
                </nav>
                <a style=" font-size: 1.7rem; color: var(--blue);" href="<?php if($_SESSION['user_role'] ==='patient') echo'patient/patient_Index.php'; elseif
                ($_SESSION['user_role'] ==='doctor') echo'doctors/doctor_index.php'?>">My Profile</a>
                <a style=" font-size: 1.7rem; color: var(--blue);" href="logout.php">Log Out</a>
                <div id="menu-btn" class="fas fa-bars"></div>
            </div>

        </div>

    </header>






    <?php endif ?>

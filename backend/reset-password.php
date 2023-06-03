<?php

    // very important to get the session variables 
	session_start();

    // if client OR employee OR manager is logged off then redirect to login page
	if(!isset($_SESSION['clientId']) && !isset($_SESSION['employeeId']) && !isset($_SESSION['managerId']))
	    header('location:../index.php');

    // connection to database
	include "connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>RB | Reset Password</title>

    <link href = "../css/style.css" rel="stylesheet"></link>
</head>
<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
            </ul>            
        </nav>
        <div class="login">
            <ul>
                <li><a href="#/"><img class="profile-icon" src="../img/Profile-icon.png" alt="NO img"></a>
                    <div class="dropdown">
                        <ul>
                            <li>Welcome 
                                <?php
                                    if (isset($_GET['userClient']))
                                        echo $_GET['clientName']; 
                                    
                                    if (isset($_GET['userEmployee']))
                                        echo $_GET['employeeName'];

                                    if (isset($_GET['userManager']))
                                        echo $_GET['managerName'];
                                ?> 
                            </li>
                            <li>
                                <?php
                                    if (isset($_GET['userClient']))
                                    {
                                        ?><a href="../backend/logout.php?clientLogout=clientLogout" class="logout-btn"><img class="logout-icon" src="../img/Logout.png" alt="NO img"> Logout</a><?php
                                    }
                                    
                                    if (isset($_GET['userEmployee']))
                                    {
                                        ?><a href="../backend/logout.php?employeeLogout=employeeLogout" class="logout-btn"><img class="logout-icon" src="../img/Logout.png" alt="NO img"> Logout</a><?php
                                    }

                                    if (isset($_GET['userManager']))
                                    {
                                        ?><a href="../backend/logout.php?managerLogout=managerLogout" class="logout-btn"><img class="logout-icon" src="../img/Logout.png" alt="NO img"> Logout</a><?php
                                    }
                                ?>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <label for="nav-toggle" class="nav-toggle-lable"> 
            <span></span>
        </label>
    </header>

    <main>
        <?php

            if (isset($_GET['userClient']))
            {
                ?>

                <section class="container-color-resetform">
                    <div class="container">
                        <form action="reset-password-form.php?userClient=<?php echo $_GET['userClient'] ?>&clientName=<?php echo $_GET['clientName'] ?>" method="POST" class="log-control log-control-reset">
                            <h2>Password Reset</h2>
                            <div class="form-col form-col-reset">
                                <label class="log-label">Current Password</label>
                                <input type="password" name="current-password" class="log-input" placeholder="Enter current password" required/>
                            </div>
                            <div class="form-col form-col-reset">
                                <label class="log-label">New Password</label>
                                <input type="password" name="password"  class="log-input"  minlength="5" placeholder="Enter new password" required/>
                            </div>
                            <div class="form-col form-col-reset">
                                <label class="log-label">Confirm Password</label>
                                <input type="password" name="cpassword" class="log-input"  minlength="5" placeholder="Confirm your password" required/>
                            </div>
                            <button type="submit" class="btn btn-login btn-reset" name="clientResetPass">Reset Password</button>
                            
                            <a href="../client/client-dashboard.php" onclick="return checkSubmit()"><div class="btn btn-login btn-reset" id="btn-reset-exit">Exit</div></a>
                        </form>
                    </div>
                </section>
                <hr>

                <?php
            }
            elseif (isset($_GET['userEmployee']))
            {
                ?>

                <section class="container-color-resetform">
                    <div class="container">
                        <form action="reset-password-form.php?userEmployee=<?php echo $_GET['userEmployee'] ?>&employeeName=<?php echo $_GET['employeeName'] ?>" method="POST" class="log-control log-control-reset">
                            <h2>Password Reset</h2>
                            <div class="form-col form-col-reset">
                                <label class="log-label">Current Password</label>
                                <input type="password" name="current-password" class="log-input" placeholder="Enter current password" required/>
                            </div>
                            <div class="form-col form-col-reset">
                                <label class="log-label">New Password</label>
                                <input type="password" name="password" class="log-input"  minlength="5" placeholder="Enter new password" required/>
                            </div>
                            <div class="form-col form-col-reset">
                                <label class="log-label">Confirm Password</label>
                                <input type="password" name="cpassword" class="log-input"  minlength="5" placeholder="Confirm your password" required/>
                            </div>
                            <button type="submit" class="btn btn-login btn-reset" name="employeeResetPass">Reset Password</button>
                            
                            <a href="../employee/employee-dashboard.php" onclick="return checkSubmit()"><div class="btn btn-login btn-reset" id="btn-reset-exit">Exit</div></a>
                        </form>
                    </div>
                </section>
                <hr>

                <?php
            }
            else
            {
                ?>

                <section class="container-color-resetform">
                    <div class="container">
                        <form action="reset-password-form.php?userManager=<?php echo $_GET['userManager'] ?>&managerName=<?php echo $_GET['managerName'] ?>" method="POST" class="log-control log-control-reset">
                            <h2>Password Reset</h2>
                            <div class="form-col form-col-reset">
                                <label class="log-label">Current Password</label>
                                <input type="password" name="current-password" class="log-input" placeholder="Enter current password" required/>
                            </div>
                            <div class="form-col form-col-reset">
                                <label class="log-label">New Password</label>
                                <input type="password" name="password" class="log-input"  minlength="5" placeholder="Enter new password" required/>
                            </div>
                            <div class="form-col form-col-reset">
                                <label class="log-label">Confirm Password</label>
                                <input type="password" name="cpassword" class="log-input"  minlength="5" placeholder="Confirm your password" required/>
                            </div>
                            <button type="submit" class="btn btn-login btn-reset" name="managerResetPass">Reset Password</button>
                            
                            <a href="../manager/manager-dashboard.php" onclick="return checkSubmit()"><div class="btn btn-login btn-reset" id="btn-reset-exit">Exit</div></a>
                        </form>
                    </div>
                </section>
                <hr>

                <?php
            }
        ?>
    </main>

    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
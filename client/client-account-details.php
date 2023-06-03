<?php
    session_start();
    if (!isset($_SESSION['clientId']))
    { 
        header('location:../index.php');
    }
    
    include "../backend/connect.php";

    $nav_array = $con->query("SELECT * FROM `clientAccounts` WHERE `id` = '$_SESSION[clientId]'");
    $nav_row = $nav_array->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>RB | Client Details</title>

    <link href = "../css/style.css" rel="stylesheet"></link>
</head>

<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="client-dashboard.php">Dashboard</a></li>
                <li><a href="client-trans-details.php">Account Statements</a></li>
                <li><a href="client-transfer.php">Transfer Funds</a></li>
                <li><a href="#">Feedback</a></li>
            </ul>            
        </nav>
        <div class="login">
            <ul>
                <li><a href="#/"><img class="profile-icon" src="../img/Profile-icon.png" alt="NO img"></a>
                    <div class="dropdown">
                        <ul>
                            <li>Welcome <?php echo $nav_row['first_name']; ?></li>
                            <script>var balanceNav = <?=$nav_row['balance'] ?>;</script>
                            <li>Current Balance<br>
                                <span id="balanceNav"></span></li>
                                <li><a href="../backend/reset-password.php?userClient=client&clientName=<?php echo $nav_row['first_name'] ?>">Reset Password</a></li>
                            <li><a href="../backend/logout.php?clientLogout=clientLogout" class="logout-btn"><img class="logout-icon" src="../img/Logout.png" alt="NO img"> Logout</a></li>
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
        <section class="breadcrumbs">
            <div class="breadcrumbs-title">
                <?php 
                        $ar = $con->query("SELECT * FROM `clientAccounts` WHERE `id` = '$_SESSION[clientId]' LIMIT 1");
                        $userData = $ar->fetch_assoc();

                        echo "  <h2>".$userData['first_name']." ".$userData['last_name']."</h2>
                                <h2>Account No. ".$userData['account_no']."</h2>";
                    ?>                
            </div>
        </section>
        <hr class="breadcrumbs-hr">

        <section class="container-color-tables">
            <h1>Account Details</h1>
            <div class="container">
                    <?php
                        $ar = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `id` = '$_SESSION[clientId]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id`");
                        $userData = $ar->fetch_assoc();

                        ?>
                        <table>
                            <tr>
                                <th>Account Holder Name</th>
                                <td><?php echo $userData['first_name']." ".$userData['last_name'] ?></td>
                                <th>Account Number</th>
                                <td><?php echo $userData['account_no'] ?></td>
                            </tr>
                            <tr>
                                <th>Balance</th>
                                <script>var balance = <?php echo $userData['balance'] ?>;</script>
                                <td id='balance'></td>
                                <th>Account Type</th>
                                <td><?php echo $userData['account_type'] ?></td>
                            </tr>
                            <tr>
                                <th>Email Id.</th>
                                <td><?php echo $userData['email'] ?></td>
                                <th>Contact Number</th>
                                <td><?php echo $userData['contact_no'] ?></td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td><?php $dob = date("jS F, Y", strtotime($userData['dob'])); echo $dob ?></td>
                                <th>Date of Creation</th>
                                <td><?php $date = date("jS F, Y", strtotime($userData['date'])); echo $date ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td><?php echo $userData['gender'] ?></td>
                                <th>Source of Income</th>
                                <td><?php echo $userData['source']  ?></td>                                
                            </tr>
                            <tr>
                                <th>Adhaar Number</th>
                                <td><?php echo $userData['aadhaar_no'] ?></td>
                                <th>State</th>
                                <td><?php echo $userData['state'] ?></td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td><?php echo $userData['district'] ?></td>                                    
                                <th>City</th>
                                <td><?php echo $userData['city'] ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo $userData['address'] ?></td>                                    
                                <th>Pincode</th>
                                <td><?php echo $userData['pincode'] ?></td>
                            </tr>
                            <tr>
                                <th>Branch</th>
                                <td><?php echo $userData['branch_name'] ?></td>                                    
                                <th>IFSC Code</th>
                                <td>RTHB0<?php echo $userData['branch_code']; ?></td>                   
                            </tr>
                        </table>
            </div>
        </section>
        <hr>
    </main>

    <footer></footer>

    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
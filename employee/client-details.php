<?php
    session_start();
    if (!isset($_SESSION['employeeId']))
    { 
        header('location:../index.php');
    }
    
    include "../backend/connect.php";
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
                <li><a href="employee-dashboard.php">Dashboard</a></li>
                <li><a href="client-list.php">Show Clients</a></li>
                <li><a href="transaction-list.php">Show Transactions</a></li>
                <li><a href="#">Feedback</a></li>
            </ul>
        </nav>
        <div class="login">
            <ul>
                <li><a href="#/"><img class="profile-icon" src="../img/Profile-icon.png" alt="NO img"></a>
                    <div class="dropdown">
                        <ul>
                            <li>Welcome <?php echo $_SESSION['employeeName']; ?></li>
                            <li><a href="../backend/reset-password.php?userEmployee=employee&employeeName=<?php echo $_SESSION['employeeName'] ?>">Reset Password</a></li>
                            <li><a href="../backend/logout.php?employeeLogout=employeeLogout" class="logout-btn"><img class="logout-icon" src="../img/Logout.png" alt="NO img"> Logout</a></li>
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
                        $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `id` = '$_SESSION[employeeId]' LIMIT 1");
                        $userData = $ar->fetch_assoc();

                        echo "  <h2>".$userData['first_name']." ".$userData['last_name']." [Employee]</h2>
                                <h2>Employee Id. ".$userData['emp_id']."</h2>";
                    ?>                
            </div>      
        </section>
        <hr class="breadcrumbs-hr">

        <section class="container-color-tables">
            <h1>Client Details</h1>
            <div class="container">
                    <?php
                        if (isset($_GET['clientID']))
                        { 
                            $ar = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `clientAccounts`.`id` = '$_GET[clientID]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id`");
                            $userData = $ar->fetch_assoc();
                            
                            ?>
                            <table>
                                <tr>
                                    <th>Account Holder Name</th>
                                    <td><?php echo $userData['first_name']." ".$userData['last_name']; ?></td>
                                    <th>Account Number</th>
                                    <td><?php echo $userData['account_no']; ?></td>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <script>var balance = <?php echo $userData['balance']; ?>;</script>
                                    <td id='balance'></td>
                                    <th>Account Type</th>
                                    <td><?php echo $userData['account_type']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email Id.</th>
                                    <td><?php echo $userData['email']; ?></td>
                                    <th>Contact Number</th>
                                    <td><?php echo $userData['contact_no']; ?></td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td><?php $dob = date("jS F, Y", strtotime($userData['dob'])); echo $dob; ?></td>
                                    <th>Date of Creation</th>
                                    <td><?php $date = date("jS F, Y", strtotime($userData['date'])); echo $date; ?></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td><?php echo $userData['gender']; ?></td>
                                    <th>Source of Income</th>
                                    <td><?php echo $userData['source']; ?></td>
                                </tr>
                                <tr>
                                    <th>Adhaar Number</th>
                                    <td><?php echo $userData['aadhaar_no']; ?></td>
                                    <th>State</th>
                                    <td><?php echo $userData['state']; ?></td>
                                </tr>
                                <tr>
                                    <th>District</th>
                                    <td><?php echo $userData['district']; ?></td>                                    
                                    <th>City</th>
                                    <td><?php echo $userData['city']; ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo $userData['address']; ?></td>                                    
                                    <th>Pincode</th>
                                    <td><?php echo $userData['pincode']; ?></td>
                                </tr>
                                <tr>
                                    <th>Branch</th>
                                    <td><?php echo $userData['branch_name']; ?></td>                                    
                                    <th>IFSC Code</th>
                                    <td>RTHB0<?php echo $userData['branch_code']; ?></td>>                                    
                                </tr>
                            </table>
                            <?php
                        }
                        else
                            echo "<script>alert('No Data Found.')</script>";                            
                    ?>
            </div>
        </section>
        <hr>
    </main>

    <footer></footer>

    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
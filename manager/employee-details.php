<?php
    session_start();
    if (!isset($_SESSION['managerId']))
    { 
        header('location:../index.php');
    }
    
    include "../backend/connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>RB | Employee Details</title>

    <link href = "../css/style.css" rel="stylesheet"></link>
</head>
<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="manager-dashboard.php">Dashboard</a></li>
                <li><a href="employee-list.php">Show Employees</a></li>
                <li><a href="client-list.php">Show Clients</a></li>
                <li><a href="#">Feedback</a></li>
            </ul>
        </nav>
        <div class="login">
            <ul>
                <li><a href="#/"><img class="profile-icon" src="../img/Profile-icon.png" alt="NO img"></a>
                    <div class="dropdown">
                        <ul>
                            <li>Welcome <?php echo $_SESSION['managerName']; ?></li>
                            <li><a href="../backend/reset-password.php?userManager=manager&managerName=<?php echo $_SESSION['managerName'] ?>">Reset Password</a></li>
                            <li><a href="../backend/logout.php?managerLogout=managerLogout" class="logout-btn"><img class="logout-icon" src="../img/Logout.png" alt="NO img"> Logout</a></li>
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
                        $ar = $con->query("SELECT * FROM `managerLogin` WHERE `id` = '$_SESSION[managerId]' LIMIT 1");
                        $userData = $ar->fetch_assoc();

                        $arr = $con->query("SELECT SUM(`balance`) AS total_balance FROM `clientAccounts`");
                        $row = $arr->fetch_assoc();   

                        echo "  <h2>".$userData['first_name']." ".$userData['last_name']." [Manager] </h2>
                                <h2>Total Balance:  <script>var balanceNav =".$row['total_balance'].";</script>
                                <span id='balanceNav'></span> </h2>";
                    ?>                
            </div>
        </section>
        <hr class="breadcrumbs-hr">

        <section class="container-color-tables">
            <h1>Employee Details</h1>
            <div class="container">
                <?php
                    if (isset($_GET['employeeID']))
                    {
                        $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `employeeAccounts`.`id` = '$_GET[employeeID]'");
                        $userData = $ar->fetch_assoc();

                        ?>
                        <table>
                            <tr>
                                <th>Employee Name</th>
                                <td><?php echo $userData['first_name']." ".$userData['last_name']; ?></td>
                                <th>Employee Id.</th>
                                <td><?php echo $userData['emp_id']; ?></td>
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
                                <th>Aadhaar Number</th>
                                <td><?php echo $userData['aadhaar_no']; ?></td>
                            </tr>
                            <tr>
                                <th>Date Joined</th>
                                <td><?php $date = date("jS F, Y", strtotime($userData['date'])); echo $date; ?></td>
                                <th>Length of Service</th>
                                <td>
                                <?php
                                    $date1 = new DateTime($userData['date']);
                                    $date2 = new DateTime("now");
                                    $interval = $date1->diff($date2);

                                    if ($interval->y > 0 && $interval->m > 0 && $interval->d > 0)
                                            echo $interval->y." Years, ".$interval->m." Months, ".$interval->d." Days";                                                
                                        
                                        elseif ($interval->y <= 0 && $interval->m > 0 && $interval->d > 0)
                                            echo $interval->m . " Months, " . $interval->d . " Days";
                                        
                                        elseif ($interval->y <= 0 && $interval->m > 0 && $interval->d <= 0)
                                            echo $interval->m . " Months";
                                        
                                        elseif ($interval->y > 0 && $interval->m <= 0 && $interval->d <= 0)
                                            echo $interval->y . " Years";
                                            
                                        elseif ($interval->y > 0 && $interval->m <= 0 && $interval->d > 0)
                                            echo $interval->y . " Years, " . $interval->d . " Days";
                                        
                                        elseif ($interval->y > 0 && $interval->m > 0 && $interval->d <= 0)
                                            echo $interval->y . " Years, " . $interval->m . " Months";

                                        else
                                            echo $interval->d . " Days";
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td><?php echo $userData['state']; ?></td>
                                <th>District</th>
                                <td><?php echo $userData['district']; ?></td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo $userData['city']; ?></td>
                                <th>Address</th>
                                <td><?php echo $userData['address']; ?></td>                                        
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
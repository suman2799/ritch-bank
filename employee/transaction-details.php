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
    <title>RB | Transaction Details</title>

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

        <section class="container-color-funds">
            <h1>Transaction History</h1>
            <div class="container">
                <h2>
                    <?php 
                        $ar = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `clientAccounts`.`account_no` = '$_GET[account_no]' LIMIT 1");
                        $userData = $ar->fetch_assoc();

                        echo $userData['first_name']." ".$userData['last_name']." [Acc. No. ".$userData['account_no']."]";
                    ?>
                </h2>
                <div class="content">
                    <?php
                        $array = $con->query("SELECT * FROM `transClient` WHERE `transClient`.`from_account` = '$_GET[account_no]' OR `transClient`.`to_account` = '$_GET[account_no]' ORDER BY `date` DESC");

                        if ($array->num_rows > 0)
                        {
                            $c1 = 0;
                            $c2 = 0;
                            $c3 = 0;
                            $c4 = 0;

                            while ($row = $array->fetch_assoc())
                            {
                                if ($row['action'] == 'transfer' &&  $row['to_account'] == $_GET['account_no'])
                                {
                                    $bal = $row['trans_amount'];
                                    
                                    ?>
                                    <div class='content' id='content-div1'>
                                        Received <span class='balRecieved'></span> from Account Number <?php $time = date("h:i A", strtotime($row['date'])); $date = date("l, jS F, Y", strtotime($row['date'])); echo $row['from_account']." [".$row['from_name']." | IFSC : ".$row['from_ifsc']."] at ".$time." on ".$date."."; ?>
                                    </div>
                                    <script>
                                        var balRecieved = '<?=$bal ?>';
                                        var k = '<?=$c1 ?>';
                                        var balINR = new Intl.NumberFormat('en-IN', {
                                                style: 'currency',
                                                currency: 'INR'
                                                })
                                        var arr = document.getElementsByClassName('balRecieved')
                                        arr[k].innerHTML = balINR.format(balRecieved);
                                    </script>
                                    <?php
                                    $c1++;
                                }
                                elseif ($row['action'] == 'transfer' &&  $row['from_account'] == $_GET['account_no'])
                                {
                                    $bal = $row['trans_amount'];
                                    
                                    ?>
                                    <div class='content' id='content-div2'>
                                        Transfered <span class='balTransfered'></span> to Account Number <?php $time = date("h:i A", strtotime($row['date'])); $date = date("l, jS F, Y", strtotime($row['date'])); echo $row['to_account']." [".$row['to_name']." | IFSC : ".$row['to_ifsc']."] at ".$time." on ".$date."."; ?>
                                    </div>
                                    <script>
                                        var balTransfered = '<?=$bal ?>';
                                        var k = '<?=$c2 ?>';
                                        var balINR = new Intl.NumberFormat('en-IN', {
                                                style: 'currency',
                                                currency: 'INR'
                                                })
                                        var arr = document.getElementsByClassName('balTransfered')
                                        arr[k].innerHTML = balINR.format(balTransfered);
                                    </script>
                                    <?php
                                    $c2++;
                                }
                                elseif ($row['action'] == 'deposit')
                                {
                                    $bal = $row['trans_amount'];

                                    ?>
                                    <div class='content' id='content-div3'>
                                            Deposited <span class='balDeposited'></span><?php $time = date("h:i A", strtotime($row['date'])); $date = date("l, jS F, Y", strtotime($row['date'])); echo " at ".$time." on ".$date."."; ?>
                                    </div>
                                    <script>
                                        var balDeposited = '<?=$bal ?>';
                                        var k = '<?=$c3 ?>';
                                        var balINR = new Intl.NumberFormat('en-IN', {
                                                style: 'currency',
                                                currency: 'INR'
                                                })
                                        var arr = document.getElementsByClassName('balDeposited')
                                        arr[k].innerHTML = balINR.format(balDeposited);
                                    </script>
                                    <?php
                                    $c3++;
                                }
                                else
                                {
                                    $bal = $row['trans_amount'];

                                    ?>
                                    <div class='content' id='content-div4'>
                                        Withdrawn <span class='balWithdrawn'></span><?php $time = date("h:i A", strtotime($row['date'])); $date = date("l, jS F, Y", strtotime($row['date'])); echo " at ".$time." on ".$date."."; ?>
                                    </div>
                                    <script>
                                        var balWithdrawn = '<?=$bal ?>';
                                        var k = '<?=$c4 ?>';
                                        var balINR = new Intl.NumberFormat('en-IN', {
                                                style: 'currency',
                                                currency: 'INR'
                                                })
                                        var arr = document.getElementsByClassName('balWithdrawn')
                                        arr[k].innerHTML = balINR.format(balWithdrawn);     
                                    </script>
                                    <?php
                                    $c4++;
                                }
                            }
                        }
                        else
                            echo "  <div class='content' id='content-div5'>
                                        No Transactions Yet.
                                    </div>";
                    ?>
                </div>
            </div>
        </section>
        <hr>
    </main>

    <footer></footer>

    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
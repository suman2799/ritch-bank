<?php
	session_start();
	if(!isset($_SESSION['clientId']))
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
    <title>RB | Client</title>

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
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

                        echo "  <h2>Welcome ".$userData['first_name']." ".$userData['last_name']."</h2>
                                <h2>Account No. ".$userData['account_no']."</h2>";
                    ?>                
            </div>
        </section>
        <hr class="breadcrumbs-hr"> 
        
        <section>
            <h1>Manage Account</h1>
            <div class="container">
                <div class="tabs">
                    <input type="radio" id="tab-view-client" name="tabs-clients" checked="checked"/>
                    <label class="tab-label label-view" for="tab-view-client">Account Summery</label>
                    <div class="tab-content tab-content-view">
                        <h2>Your Account Summery</h2>
                        <?php
                            $ar = $con->query("SELECT * FROM `clientAccounts`,`branch` WHERE `clientAccounts`.`id` = '$_SESSION[clientId]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id`");
                            $userData = $ar->fetch_assoc();

                            if (isset($userData))
                            {
                                ?>    
                                <form class='form-control'>
                                    <div class='col'>
                                        <label class='form-label'>Acc. Holder Name</label>
                                        <input type='text' value="<?php echo $userData['first_name']." ".$userData['last_name'] ?>" class='form-inputbar' readonly/>
                                    </div>
                                    <div class='col'>
                                        <label class='form-label'>Account Number</label>
                                        <input type='text' value="<?php echo $userData['account_no'] ?>" class='form-inputbar' readonly/>
                                    </div>
                                    <div class='col'>
                                        <label class='form-label'>Balance (&#x20b9;)</label>
                                        <script>var balance = <?php echo $userData['balance'] ?>;</script>
                                        <input type='text' id='balance' value='' class='form-inputbar' readonly/>
                                    </div>
                                    <div class='col'>
                                        <label class='form-label'>Account Type</label>
                                        <input type='text' value="<?php echo $userData['account_type'] ?>" class='form-inputbar' readonly/>
                                    </div>
                                    <div class='col'>
                                        <label class='form-label'>Branch Name</label>
                                        <input type='text' value="<?php echo $userData['branch_name'] ?>" class='form-inputbar' readonly/>
                                    </div>
                                    <div class='col'>
                                        <label class='form-label'>IFSC Code</label>
                                        <input type='text' value="RTHB0<?php echo $userData['branch_code']; ?>" class='form-inputbar' readonly/>
                                    </div>
                                </form>
                                <?php                                        
                            }
                        ?>
                        <a href="client-account-details.php" class="btn btn-view">View Details</a>
                    </div>
                                      
                    <input type="radio" id="tab-transfer-client" name="tabs-clients"/>
                    <label class="tab-label label-add" for="tab-transfer-client">Transfer Funds</label>
                    <div class="tab-content tab-content-add">
                        <h2>Transfer Funds To Other Accounts</h2>
                        <form action="../backend/transfer-fund.php?client=client" method="POST" class="input-control">
                            <div class="row" style="width: 50%;">
                                <label for="" class="input-label">Acc. Holder Name</label>
                                <input type="text" name="name" class="input-inputbar" placeholder="Enter Name" style="text-transform: uppercase;" required/>
                            </div>
                            <div class="row" style="width: 50%;">
                                <label for="" class="input-label">Account No.</label>
                                <input type="number" name="to_account" class="input-inputbar" placeholder="Enter Acc. No." required/>
                            </div>
                            <div class="row" style="width: 50%;">                                
                                <label for="" class="input-label">Amount (&#x20b9;)</label>
                                <input type="number" name="amount" min="1" class="input-inputbar" placeholder="Enter Amount" required/>
                            </div>
                            <div class="row" style="width: 50%;">                                
                                <label for="" class="input-label">IFSC Code</label>
                                <input type="text" name="ifsc" minlength="11" maxlength="11" class="input-inputbar" placeholder="Enter IFSC Code" style="text-transform: uppercase;" required/>
                            </div>
                            <button type='sunmit' name="transfer-fund" class="btn btn-view" id="btn-form-submit">Transfer Fund</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <hr>
    </main>
     
    <footer></footer>

    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
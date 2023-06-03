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
  	<title>RB | Transfer Funds</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="client-dashboard.php">Dashboard</a></li>
                <li><a href="client-trans-details.php">Account Statements</a></li>
                <li><a href="client-account-details.php">Account Details</a></li>
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

		<section class="container-color-funds">
            <h1>Transfer Funds</h1>
			<div class="container">
                <form action="" method="post" class="search-control">
                    <input type="number" class="search-bar" name="account_no_find" placeholder="Enter Account Number" required/>
                    <button class="btn btn-find" name="find-account" type="submit">Get Info.</button>
                </form>
				<?php
                    if (isset($_POST['find-account']))
                    { 
                        $ar = $con->query("SELECT * FROM `clientAccounts`,`branch` WHERE `clientAccounts`.`account_no` = '$_POST[account_no_find]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                        $userData = $ar->fetch_assoc();
                    
                        if (isset($userData))
                        {
                            ?>
                            <form class='form-control form-control-info'>
                                <h3>Account Holder Information</h3>
                                <div class='col'>
                                    <label class='form-label'>Account Holder Name</label>
                                    <input type='text' value="<?php echo $userData['first_name']." ".$userData['last_name']; ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Account Number</label>
                                    <input type='text' value="<?php echo $userData['account_no']; ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>IFSC Code</label>
                                    <input type='text' value="RTHB0<?php echo $userData['branch_code']; ?>" class='form-inputbar' readonly/>
                                </div>
                            </form>
                            <?php                         
                        }
                        else
                            echo "  <div class='content' id='content-div5'>
                                        Account Number ".$_POST['account_no_find']." Does Not Exist.
                                    </div>";
                    }
                ?>  
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
                    <button type='sunmit' name="transfer-fund-nav" class="btn btn-view" id="btn-form-submit">Transfer Fund</button>
                </form>
			</div>
		</section>
        <hr>

		<section class="container-color-funds">
			<div class="container">
				<h2>Transfer History</h2>
				<?php
					$ar = $con->query("SELECT * FROM `clientAccounts` WHERE `clientAccounts`.`id` = '$_SESSION[clientId]'");
					$userData = $ar->fetch_assoc();

                    $array = $con->query("SELECT * FROM `transClient` WHERE `transClient`.`from_account` = '$userData[account_no]' OR `transClient`.`to_account` = '$userData[account_no]' ORDER BY `date` DESC");

                    if ($array->num_rows > 0)
                    {
                        $c = 0;

                        while ($row = $array->fetch_assoc())
                        {
                            if ($row['action'] == 'transfer' &&  $row['from_account'] == $userData['account_no'])
                            {
                                $bal = $row['trans_amount'];
                                    
                                ?>
                                <div class='content' id='content-div2'>
                                    Transferd <span class='balTransfered'></span> from your account to Acc. No. <?php $time = date("h:i A", strtotime($row['date'])); $date = date("l, jS F, Y", strtotime($row['date'])); echo $row['to_account']." [".$row['to_name']." | IFSC : ".$row['to_ifsc']."] at ".$time." on ".$date."."; ?>
                                </div>
                                <script>
                                    var balTransfered = '<?=$bal ?>';
                                    var k = '<?=$c ?>';
                                    var balINR = new Intl.NumberFormat('en-IN', {
                                            style: 'currency',
                                            currency: 'INR'
                                            })
                                    var arr = document.getElementsByClassName('balTransfered')
                                    arr[k].innerHTML = balINR.format(balTransfered);
                                </script>
                                <?php
                                $c++;
                            }
						}
                    }
                    else
                        echo "  <div class='content' id='content-div5'>
                                    No Transfers Yet.
                                </div>";
                    ?>
			</div>
		</section>
        <hr>
	</main>

	<footer></footer>

    <script type="text/javascript" src="../js/main.js"></script>
    <script>
        if ( window.history.replaceState ) 
            window.history.replaceState( null, null, window.location.href );
    </script>
</body>
</html>
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
    <title>RB | View Transactions</title>

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
                <li><a href="#/" class="active-link">Show Transactions</a></li>
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
            <h1>Search Client's Transaction History</h1>
            <div class="container">
                <form action="" method="post" class="search-control">
                    <input type="number" class="search-bar" name="account_no" placeholder="Enter Account Number" required/>
                    <button class="btn btn-find" name="find-client" type="submit">Find Details</button>
                </form>
                <?php
                    if (isset($_POST['find-client']))
                    {
                        $ar = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `clientAccounts`.`account_no` = '$_POST[account_no]' LIMIT 1");
                        $userData = $ar->fetch_assoc();
                        
                        if (isset($userData))
                        {
                            header("location:transaction-details.php?account_no=".$_POST['account_no']);
                        }
                        else
                        {
                            echo "  <div class='content' id='content-div5'>
                                    Client Account ".$_POST['account_no']." Does Not Exist.
                                    </div>";
                            // echo "<script>alert('Client Not Found.');window.location.href='transaction-list.php'</script>";
                        }
                    }
                ?>
            </div>
        </section>

        <section class="container-color-tables">
            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account Holder Name</th>
                            <th scope="col">Account No.</th>
                            <th scope="col">Current Balance</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=0;
                            $array = $con->query("SELECT * FROM `clientAccounts` ORDER BY `clientAccounts`.`id` ASC");
                            if ($array->num_rows > 0)
                            {
                                $c = 0;
                                while ($row = $array->fetch_assoc())
                                {
                                    $bal = $row['balance'];
                                    $i++;
                                    echo "<tr>
                                            <td scope='row'>".$i."</td>
                                            <td>".$row['first_name']." ".$row['last_name']."</td>
                                            <td>".$row['account_no']."</td>
                                            <td class='balCurrent'></td>";
                                            ?>
                                                <script>
                                                    var balCurrent = '<?=$bal ?>';
                                                    var k = '<?=$c ?>';
                                                    var balINR = new Intl.NumberFormat('en-IN', {
                                                        style: 'currency',
                                                        currency: 'INR'
                                                        })
                                                        var arr = document.getElementsByClassName('balCurrent')
                                                        arr[k].innerHTML = balINR.format(balCurrent);
                                                </script>
                                            <?php
                                                $c++;
                                    echo  " <td>
                                                <a class='btn btn-view' id='btn-view-table' href='transaction-details.php?account_no=".$row['account_no']."' title='View More info'>View</a>
                                            </td>
                                        </tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
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
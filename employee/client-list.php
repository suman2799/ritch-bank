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
    <title>RB | Client List</title>
    
    <link href = "../css/style.css" rel="stylesheet"></link>
</head>

<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="employee-dashboard.php">Dashboard</a></li>
                <li><a href="#/" class="active-link">Show Clients</a></li>
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
            <h1>Client List</h1>
            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account Holder Name</th>
                            <th scope="col">Account No.</th>
                            <th scope="col">Branch Name</th>
                            <th scope="col">Current Balance</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=0;
                            $array = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `clientaccounts`.`branch_id` = `branch`.`branch_id` ORDER BY `clientAccounts`.`id` ASC");
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
                                            <td>".$row['branch_name']."</td>
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
                                        echo"<td>".$row['contact_no']."</td>
                                            <td>
                                                <a class='btn btn-view' id='btn-view-table' href='client-details.php?clientID=".$row['id']."'title='View More info'>View</a>

                                                <a class='btn btn-view' id='btn-edit-table' href='client-details-edit.php?id=".$row['id']."'title='Edit Client Details'>Edit</a>
                                                
                                                <a class='btn btn-delete' id='btn-delete-table' href='client-list.php?delete=".$row['id']."' onclick='return checkDelete()' title='Delete this account'>Delete</a>
                                            </td>
                                        </tr>";
                                }
                            }
                            if (isset($_GET['delete'])) 
                            {
                                if ($con->query("DELETE FROM `clientAccounts` WHERE `id` = '$_GET[delete]' LIMIT 1"))
                                {
                                    echo "<script>alert('Client Deleted Successfully!');window.location.href='client-list.php'</script>";
                                }
                                else
                                    echo "<script>alert('Failed to Delete Client.');window.location.href='client-list.php'</script>";
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
</body>
</html>
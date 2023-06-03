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
    <title>RB | Employee List</title>

    <link href = "../css/style.css" rel="stylesheet"></link>
    <script type="text/javascript" src="../js/main.js"></script>
</head>
<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="manager-dashboard.php">Dashboard</a></li>
                <li><a href="#/" class="active-link">Show Employees</a></li>
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
            <h1>Employee List</h1>
            <div class="container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Employee Id.</th>
                            <th scope="col">Email Id.</th>
                            <th scope="col">Conatct No.</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=0;
                            $array = $con->query("SELECT * FROM `employeeAccounts` ORDER BY `employeeAccounts`.`id` ASC");
                            if ($array->num_rows > 0)
                            {
                                while ($row = $array->fetch_assoc())
                                {
                                    $i++;
                                    echo "<tr>
                                            <td scope='row'>".$i."</td>
                                            <td>".$row['first_name']." ".$row['last_name']."</td>
                                            <td>".$row['emp_id']."</td>
                                            <td>".$row['email']."</td>
                                            <td>".$row['contact_no']."</td>
                                            <td>
                                                <a class='btn btn-view' id='btn-view-table' href='employee-details.php?employeeID=".$row['id']."'title='View More info'>View</a>
                                                
                                                <a class='btn btn-view' id='btn-edit-table' href='employee-details-edit.php?id=".$row['id']."'title='Edit Employee Details'>Edit</a>
                                                
                                                <a class='btn btn-delete' id='btn-delete-table' href='employee-list.php?delete=".$row['id']."' onclick='return checkDelete()' title='Delete this account'>Delete</a>
                                            </td>
                                        </tr>";
                                }
                            }
                            if (isset($_GET['delete'])) 
                            {
                                if ($con->query("DELETE FROM `employeeAccounts` WHERE `id` = '$_GET[delete]' LIMIT 1"))
                                {
                                    echo "<script>alert('Employee Deleted Successfully!');window.location.href='employee-list.php'</script>";
                                }
                                else
                                    echo "<script>alert('Failed to Delete Employee.');window.location.href='employee-list.php'</script>";
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
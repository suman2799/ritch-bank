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
    <title>RB | Manager</title>
    
    <link href = "../css/style.css" rel="stylesheet"></link>
</head>

<body>
    <header>
        <hi class="logo">RITCH BANK</hi>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
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

                        echo "  <h2>Welcome ".$userData['first_name']." ".$userData['last_name']." [Manager] </h2>
                                <h2>Total Balance:  <script>var balanceNav =".$row['total_balance'].";</script>
                                <span id='balanceNav'></span> </h2>";
                    ?>                
            </div>
        </section>
        <hr class="breadcrumbs-hr">        
        
        <section>
            <h1>Manage Client</h1>
            <div class="container">
                <div class="tabs">
                    <input type="radio" id="tab-view-client" name="tabs-clients" checked="checked">
                    <label class="tab-label label-view" for="tab-view-client">Find Client</label>
                    <div class="tab-content tab-content-view">
                        <h2>Find Client Details</h2>
                        <form action="" method="post" class="search-control">
                            <input type="number" class="search-bar" name="account_no" placeholder="Enter Account Number" required/>
                            <button class="btn btn-find" name="find-client" type="submit">Find Details</button>
                        </form>
                        <?php
                            if (isset($_POST['find-client']))
                            { 
                                $ar = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `clientAccounts`.`account_no` = '$_POST[account_no]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                                $userData = $ar->fetch_assoc();
                             
                                if (isset($userData))
                                {
                                    ?>
                                    <h3>Client Details</h3>
                                    <form class='form-control'>
                                        <div class='col'>
                                            <label class='form-label'>Acc. Holder Name</label>
                                            <input type='text' value="<?php echo $userData['first_name']." ".$userData['last_name']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Account Number</label>
                                            <input type='number' value="<?php echo $userData['account_no']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Balance (&#x20b9;)</label>
                                            <script>var balance = <?php echo $userData['balance']; ?>;</script>
                                            <input type='text' id='balance' value='' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Account Type</label>
                                            <input type='text' value="<?php echo $userData['account_type']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Email Id.</label>
                                            <input type='email' value="<?php echo $userData['email']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Contact Number</label>
                                            <input type='number' value="<?php echo $userData['contact_no']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Date of Birth</label>
                                            <input type='text' value="<?php $dob = date("jS F, Y", strtotime($userData['dob'])); echo $dob; ?>" class='form-inputbar' style="text-transform: none;" readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Date of Creation</label>
                                            <input type='text' value="<?php $date = date("jS F, Y", strtotime($userData['date'])); echo $date; ?>" class='form-inputbar' style="text-transform: none;" readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Gender</label>
                                            <input type='text' value="<?php echo $userData['gender']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Source of Income</label>
                                            <input type='text' value="<?php echo $userData['source']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Aadhaar Number</label>
                                            <input type='number' value="<?php echo $userData['aadhaar_no']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>State</label>
                                            <input type='text' value="<?php echo $userData['state']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>District</label>
                                            <input type='text' value="<?php echo $userData['district']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>City</label>
                                            <input type='text' value="<?php echo $userData['city']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Address</label>
                                            <input type='text' value="<?php echo $userData['address']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Pincode</label>
                                            <input type='number' value="<?php echo $userData['pincode']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Branch</label>
                                            <input type='text' value="<?php echo $userData['branch_name']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>IFSC Code</label>
                                            <input type='text' value="RTHB0<?php echo $userData['branch_code']; ?>" class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                        </div>
                                        <div class='col'>
                                        </div>
                                        <div class='col'>
                                            <a href='client-details-edit.php?id=<?php echo $userData['id']; ?>'><div class='form-inputbar btn btn-view' id='btn-form-edit'>Edit Client Details</div></a>
                                        </div>
                                    </form>
                                    <?php
                                }
                                else
                                    echo "<script>alert('Client Not Found.');window.location.href='manager-dashboard.php'</script>";
                            }
                        ?>  
                    </div>

                    <input type="radio" id="tab-add-client" name="tabs-clients">
                    <label class="tab-label label-add" for="tab-add-client">Add Client</label>
                    <div class="tab-content tab-content-add">
                        <h2>Add New Client</h2>
                        <form action="../backend/form.php?user=manager" method="post" class="form-control">
                            <div class="col">
                                <label for="" class="form-label">First Name</label>
                                <input type="text" name="first_name" value="dummy" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" name="last_name" value="dummy" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Gender</label>
                                <input type="text" name="gender" value="dummy" list="gender" class="form-inputbar" placeholder="Enter or select gender" required/>
                                <datalist id="gender">
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                    <option value="OTHERS">OTHERS</option>
                                </datalist>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" value="2021-03-15" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Deposit (&#x20b9;)</label>
                                <input type="number" name="deposit" class="form-inputbar" value="500" min="500" placeholder="Minimum amount of Rs. 500" required/>
                            </div>   
                            <div class="col">
                                <label for="" class="form-label">Aadhaar Number</label>
                                <input type="number" name="aadhaar_no" value="789456" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Email Id.</label>
                                <input type="email" name="email" value="dummy@dummy" class="form-inputbar" placeholder="eg. john@gmail.com" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Password</label>
                                <input type="password" name="password" value="dummy" class="form-inputbar" minlength="5" placeholder="Enter a strong password" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Confirm Password</label>
                                <input type="password" name="cpassword" value="dummy" class="form-inputbar" minlength="5" placeholder="Confirm your password" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Contact Number</label>
                                <input type="number" name="contact_no" value="789456" class="form-inputbar" placeholder="Enter valid contact number" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Source of Income</label>
                                <input type="text" name="source" value="dummy" class="form-inputbar" placeholder="Enter NIL if none" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Account Number</label>
                                <?php
                                    $arr = $con->query("SELECT `account_no` FROM `clientAccounts` ORDER BY `id` DESC LIMIT 1");
                                    if ($arr->num_rows > 0)
                                    {
                                        $row = $arr->fetch_assoc();
                                        echo "<input type='number' name='account_no' readonly value='".($row['account_no']+1)."' class='form-inputbar' min='100000000' max='9999999999999999' required/>";
                                    }
                                ?>                                
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Account Type</label>
                                <select name="account_type" id="" class="form-inputbar" required>
                                    <option value="CURRENT">CURRENT</option>
                                    <option value="SAVINGS">SAVINGS</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">State</label>
                                <select name="state" id="" class="form-inputbar form-select" required>
                                    <option value="">Please Select..</option>
                                    <?php
                                        $arr = $con->query("SELECT * FROM `state`");
                                        if ($arr->num_rows > 0)
                                        {
                                            while ($row = $arr->fetch_assoc())
                                            {
                                                echo "<option value='$row[state_name]'>$row[state_name]</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">District</label>
                                <input type="text" name="district" value="dummy" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">City</label>
                                <input type="text" name="city" value="dummy" class="form-inputbar" placeholder="Enter City / Town" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Permanent Address</label>
                                <input type="text" name="address" value="dummy" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Pincode</label>
                                <input type="number" name="pincode" value="700144" class="form-inputbar" placeholder="eg. 700144" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Branch</label>
                                <select name="branch_id" id="" class="form-inputbar form-select" required>
                                    <option value="">Please Select..</option>
                                    <?php
                                        $arr = $con->query("select * from branch");
                                        if ($arr->num_rows > 0)
                                        {
                                            while ($row = $arr->fetch_assoc())
                                            {
                                                echo "<option value='$row[branch_id]'>$row[branch_name]</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h4>Please fill in the data carefully</h4>
                            </div>
                            <div class="col">
                            </div>
                            <div class="col">
                            </div>
                            <div class="col">
                                <button type="submit" name="add_client" class="form-inputbar btn btn-view" id="btn-form-submit">Submit</button>
                            </div>
                            <div class="col">
                                <button type="reset" class="form-inputbar btn btn-delete" id="btn-form-reset" onclick='return checkDelete()'>Reset</button>
                            </div>
                        </form>                        
                    </div>

                    <input type="radio" id="tab-delete-client" name="tabs-clients">
                    <label class="tab-label label-delete" for="tab-delete-client">Remove Client</label>
                    <div class="tab-content tab-content-delete">
                        <h2>Remove Existing Client</h2>
                        <form action="" method="post" class="search-control">
                            <input type="number" class="search-bar" name="account_no_remove" placeholder="Enter Account Number" required/>
                            <button type="submit" class="btn btn-remove" name="remove-client" onclick='return checkDelete()'>Remove Client</button>
                        </form>
                        <?php
                            if (isset($_POST['remove-client']))
                            { 
                                $ar = $con->query("SELECT * FROM `clientAccounts` WHERE `clientAccounts`.`account_no` = '$_POST[account_no_remove]' LIMIT 1");
                                
                                if ($ar->num_rows > 0)
                                {
                                    $del = $con->query("DELETE FROM `clientAccounts` WHERE `account_no` = '$_POST[account_no_remove]' LIMIT 1");
                                    if ($con->affected_rows > 0)
                                    {
                                        echo "<script>alert('Client Deleted Successfully!');window.location.href='manager-dashboard.php'</script>";
                                    }
                                    else
                                        echo "<script>alert('Failed to Delete Client.');window.location.href='manager-dashboard.php'</script>";
                                }
                                else
                                    echo "<script>alert('Client Not Found.')</script>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <hr>
        <section>
            <h1>Manage Employee</h1>
            <div class="container">
                <div class="tabs">
                    <input type="radio" id="tab-view" name="tabs-employee" checked="checked">
                    <label class="tab-label label-view" for="tab-view">Find Employee</label>
                    <div class="tab-content tab-content-view">
                        <h2>Find Employee Details</h2>
                        <form action="" method="post" class="search-control">
                            <input type="number" class="search-bar" name="employeeid" placeholder="Enter Employee Id." required/>
                            <button class="btn btn-find" name="find-employee" type="submit">Find Details</button>
                        </form>
                        <?php
                            if (isset($_POST['find-employee']))
                            { 
                                $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `employeeAccounts`.`emp_id` = '$_POST[employeeid]' LIMIT 1");
                                $userData = $ar->fetch_assoc();
                             
                                if (isset($userData))
                                {
                                    ?>
                                    <h3>Employee Details</h3>
                                    <form class='form-control'>
                                        <div class='col'>
                                            <label class='form-label'>Employee Name</label>
                                            <input type='text' value='<?php echo $userData['first_name']." ".$userData['last_name']; ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Employee Id.</label>
                                            <input type='number' value='<?php echo $userData['emp_id'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Email Id.</label>
                                            <input type='email' value='<?php echo $userData['email'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Contact Number</label>
                                            <input type='number' value='<?php echo $userData['contact_no'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Date of Birth</label>
                                            <input type='text' value="<?php $dob = date("jS F, Y", strtotime($userData['dob'])); echo $dob; ?>" class='form-inputbar' style="text-transform: none;" readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Aadhaar Number</label>
                                            <input type='number' value='<?php echo $userData['aadhaar_no'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Date Joined</label>
                                            <input type='text' value="<?php $date = date("jS F, Y", strtotime($userData['date'])); echo $date; ?>" class='form-inputbar' style="text-transform: none;" readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Lenght of Service</label>
                                            <?php                                                    
                                                $date1 = new DateTime($userData['date']);
                                                $date2 = new DateTime("now");
                                                $interval = $date1->diff($date2);
    
                                                if ($interval->y > 0 && $interval->m > 0 && $interval->d > 0)
                                                    $servLen = $interval->y." Years, ".$interval->m." Months, ".$interval->d." Days";                                                
                                                
                                                elseif ($interval->y <= 0 && $interval->m > 0 && $interval->d > 0)
                                                    $servLen = $interval->m . " Months, " . $interval->d . " Days";
                                                
                                                elseif ($interval->y <= 0 && $interval->m > 0 && $interval->d <= 0)
                                                    $servLen = $interval->m . " Months";
                                                
                                                elseif ($interval->y > 0 && $interval->m <= 0 && $interval->d <= 0)
                                                    $servLen = $interval->y . " Years";
                                                    
                                                elseif ($interval->y > 0 && $interval->m <= 0 && $interval->d > 0)
                                                        $servLen = $interval->y . " Years, " . $interval->d . " Days";
                                                
                                                elseif ($interval->y > 0 && $interval->m > 0 && $interval->d <= 0)
                                                        $servLen = $interval->y . " Years, " . $interval->m . " Months";

                                                else
                                                    $servLen = $interval->d . " Days";

                                                echo "  <input type='text' value='".$servLen."' class='form-inputbar' style='text-transform: none;' readonly/>";
                                            ?>                                                 
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>State</label>
                                            <input type='text' value='<?php echo $userData['state'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>District</label>
                                            <input type='text' value='<?php echo $userData['district'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>City</label>
                                            <input type='text' value='<?php echo $userData['city'] ?>' class='form-inputbar' readonly/>
                                        </div>
                                        <div class='col'>
                                            <label class='form-label'>Address</label>
                                            <input type='text' value='<?php echo $userData['address'] ?>' class='form-inputbar' readonly/>
                                        </div>                                                
                                        <div class='col'>
                                        </div>
                                        <div class='col'>
                                        </div>
                                        <div class='col'>
                                            <a href='employee-details-edit.php?id=<?php echo $userData['id']?>'><div class='form-inputbar btn btn-view' id='btn-form-edit'>Edit Employee Details</div></a>
                                        </div>
                                    </form>
                                    <?php
                                }
                                else
                                    echo "<script>alert('Employee Not Found.');window.location.href='manager-dashboard.php'</script>";
                            }
                        ?>  
                    </div>

                    <input type="radio" id="tab-add" name="tabs-employee">
                    <label class="tab-label label-add" for="tab-add">Add Employee</label>
                    <div class="tab-content tab-content-add">
                        <h2>Add New Employee</h2>
                        <form action="../backend/form.php" method="post" class="form-control">
                            <div class="col">
                                <label for="" class="form-label">First Name</label>
                                <input type="text" name="first_name" value="dummy" class="form-inputbar" oninput="upperCaseF(this)" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" name="last_name" value="dummy" class="form-inputbar" oninput="upperCaseF(this)" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" value="2021-01-12" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Aadhaar Number</label>
                                <input type="number" name="aadhaar_no" value="789456" class="form-inputbar" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Email Id.</label>
                                <input type="email" name="email" value="dummy@dummy" class="form-inputbar" placeholder="eg. john@gmail.com" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Password</label>
                                <input type="password" name="password" value="dummy" class="form-inputbar" minlength="5" placeholder="Enter a strong password" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Confirm Password</label>
                                <input type="password" name="cpassword" value="dummy" class="form-inputbar" minlength="5" placeholder="Confirm your password" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Contact Number</label>
                                <input type="number" name="contact_no" value="789456" class="form-inputbar" placeholder="Enter valid contact number" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Employee Id.</label>
                                <?php
                                    $arr = $con->query("SELECT `emp_id` FROM `employeeAccounts` ORDER BY `id` DESC LIMIT 1");
                                    if ($arr->num_rows > 0)
                                    {
                                        $row = $arr->fetch_assoc();
                                        echo "<input type='number' name='emp_id' readonly min='100000' value='".($row['emp_id']+1)."' class='form-inputbar' required/>";
                                    }
                                ?>   
                            </div>
                            <div class="col">
                                <label for="" class="form-label">State</label>
                                <select name="state" id="" class="form-inputbar form-select" required>
                                    <option value="">Please Select..</option>
                                    <?php
                                        $arr = $con->query("select * from state");
                                        if ($arr->num_rows > 0)
                                        {
                                            while ($row = $arr->fetch_assoc())
                                            {
                                                echo "<option value='$row[state_name]'>$row[state_name]</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">District</label>
                                <input type="text" name="district" value="dummy" class="form-inputbar" oninput="upperCaseF(this)" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">City</label>
                                <input type="text" name="city" value="dummy" class="form-inputbar" placeholder="Enter City / Town" oninput="upperCaseF(this)" required/>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Permanent Address</label>
                                <input type="text" name="address" value="dummy" class="form-inputbar" oninput="upperCaseF(this)" required/>
                            </div>
                            <div class="col">
                            </div>
                            <div class="col">
                            </div>
                            <div class="col">
                            </div>
                           <div class="col">
                                <button type="submit" name="add_employee" class="form-inputbar btn btn-view" id="btn-form-submit">Submit</button>
                            </div>
                            <div class="col">
                                <button type="reset" class="form-inputbar btn btn-delete" id="btn-form-reset" onclick='return checkDelete()'>Reset</button>
                            </div>
                        </form>                        
                    </div>

                    <input type="radio" id="tab-delete" name="tabs-employee">
                    <label class="tab-label label-delete" for="tab-delete">Remove Employee</label>
                    <div class="tab-content tab-content-delete">
                        <h2>Remove Existing Employee</h2>
                        <form action="" method="post" class="search-control">
                            <input type="number" class="search-bar" name="emp_id_remove" placeholder="Enter Employee Id." required/>
                            <button type="submit" class="btn btn-remove" name="remove-employee" onclick='return checkDelete()'>Remove Employee</button>
                        </form>
                        <?php
                            if (isset($_POST['remove-employee']))
                            { 
                                $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `employeeAccounts`.`emp_id` = '$_POST[emp_id_remove]' LIMIT 1");
                                
                                if ($ar->num_rows > 0)
                                {
                                    $del = $con->query("DELETE FROM `employeeAccounts` WHERE `emp_id` = '$_POST[emp_id_remove]' LIMIT 1");
                                    if ($con->affected_rows > 0)
                                    {
                                        echo "<script>alert('Employee Deleted Successfully!');window.location.href='manager-dashboard.php'</script>";
                                    }
                                    else
                                        echo "<script>alert('Failed to Delete Employee.');window.location.href='manager-dashboard.php'</script>";
                                }
                                else
                                    echo "<script>alert('Employee Not Found.')</script>";
                            }
                        ?>
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
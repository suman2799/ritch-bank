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
    <title>RB | Edit Client Details</title>

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
        
        <section class="container-color-editform">
            <div class="container">                
                <?php

                    if (isset($_GET['id']))
                    {
                        $_SESSION['editIdEmployee'] = $_GET['id'];
                    }

                    $ar = $con->query("SELECT * FROM `clientAccounts`, `branch` WHERE `clientAccounts`.`id` = '$_SESSION[editIdEmployee]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                    $userData = $ar->fetch_assoc();
                    
                    if (isset($userData))
                    {
                        ?>
                            <h2>Edit Client Details</h2>
                            <form action="../backend/form.php?user=employee&editId=<?php echo $_SESSION['editIdEmployee'] ?>" method='POST' class='form-control'>
                                <div class='col'>
                                    <label class='form-label'>First Name</label>
                                    <input type='text' name='first_name' value="<?php echo $userData['first_name'] ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Last Name</label>
                                    <input type='text' name='last_name' value="<?php echo $userData['last_name'] ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Account Number</label>
                                    <input type='number' value="<?php echo $userData['account_no'] ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Account Type</label>
                                    <select name="account_type" class="form-inputbar" required>
                                        <option value="<?php echo $userData['account_type'] ?>"><?php echo $userData['account_type'] ?></option>
                                        <option value="CURRENT">CURRENT</option>
                                        <option value="SAVINGS">SAVINGS</option>
                                    </select>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Email Id.</label>
                                    <input type='email' name='email' value="<?php echo $userData['email'] ?>"  class='form-inputbar' placeholder='eg. john@gmail.com' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Contact Number</label>
                                    <input type='number' name='contact_no' value="<?php echo $userData['contact_no'] ?>" class='form-inputbar' placeholder='Enter valid contact number' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Date of Birth</label>
                                    <input type='text' value="<?php $dob = date("jS F, Y", strtotime($userData['dob'])); echo $dob; ?>" class='form-inputbar' style="text-transform: none;" readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Gender</label>
                                    <input type='text' value="<?php echo $userData['gender'] ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Source of Income</label>
                                    <input type='text' name='source' value="<?php echo $userData['source'] ?>" class='form-inputbar' placeholder='Enter NIL if none' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Aadhaar Number</label>
                                    <input type='number' value="<?php echo $userData['aadhaar_no'] ?>" class='form-inputbar' readonly/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>State</label>
                                    <select name='state' class='form-inputbar form-select' required>
                                        <option value="<?php echo $userData['state'] ?>"><?php echo $userData['state'] ?></option>
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
                                <div class='col'>
                                    <label class='form-label'>District</label>
                                    <input type='text' name='district' value="<?php echo $userData['district'] ?>" class='form-inputbar' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>City</label>
                                    <input type='text' name='city' value="<?php echo $userData['city'] ?>" class='form-inputbar' placeholder='Enter City / Town' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Permanent Address</label>
                                    <input type='text' name='address' value="<?php echo $userData['address'] ?>" class='form-inputbar' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Pincode</label>
                                    <input type='number' name='pincode' value="<?php echo $userData['pincode'] ?>" class='form-inputbar' placeholder='eg. 700144' required/>
                                </div>
                                <div class='col'>
                                    <label class='form-label'>Branch</label>
                                    <select name='branch_id' class='form-inputbar form-select' required>
                                        <option value="<?php echo $userData['branch_id'] ?>"><?php echo $userData['branch_name'] ?></option>
                                        <?php
                                            $arr = $con->query('SELECT * FROM `branch`');
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
                                <div class='col'>
                                </div>
                                <div class='col'>
                                </div>
                                <div class='col'>
                                    <a href="employee-dashboard.php"><div class='form-inputbar btn' id='btn-form-exit' onclick="return checkSubmit()">Exit</div></a>
                                </div>
                                <div class='col'>
                                    <button type='reset' class='form-inputbar btn btn-delete' id='btn-form-reset' onclick='return checkDelete()'>Reset</button>
                                </div>
                                <div class='col'>
                                    <button type='submit' name='edit_client' class='form-inputbar btn btn-view' id='btn-form-submit'>Submit</button>
                                </div>
                            </form>
                        <?php                                                
                    }
                    else
                        echo "<script>alert('Client Not Found.')</script>";
                ?>  
            </div>
        </section>
        <hr>
    </main>

    <footer></footer>
    
    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
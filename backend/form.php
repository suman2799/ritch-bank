<?php

    // very important to get the session variables 
    session_start();

    // if employee OR manager is logged off then redirect to login page 
    if (!isset($_SESSION['employeeId']) && !isset($_SESSION['managerId']))
        header('location:../index.php');

    // connection to database
    include "connect.php";



    // ------------------------------ start of add form ---------------------------------//

    // form request to add a client to db by employee OR manager
    if (isset($_POST['add_client']))
    {
        // convert the POST variables to uppercase
        $_POST['first_name'] = strtoupper($_POST['first_name']);
        $_POST['last_name'] = strtoupper($_POST['last_name']);
        $_POST['gender'] = strtoupper($_POST['gender']);
        $_POST['source'] = strtoupper($_POST['source']);
        $_POST['account_type'] = strtoupper($_POST['account_type']);
        $_POST['district'] = strtoupper($_POST['district']);
        $_POST['city'] = strtoupper($_POST['city']);
        $_POST['address'] = strtoupper($_POST['address']);

        // check if the email id. is already registered or not
        $ar = $con->query("SELECT * FROM `clientAccounts` WHERE `clientAccounts`.`email` = '$_POST[email]'");

        if ($ar->num_rows > 0)
        {
            if ($_GET['user'] == 'employee')
                echo "<script>alert('Email Id. Already Present.\\nFailed to Add Client.');window.location.href='../employee/employee-dashboard.php'</script>";
            else
                echo "<script>alert('Email Id. Already Present.\\nFailed to Add Client.');window.location.href='../manager/manager-dashboard.php'</script>";
        }
        else
        {  
            // check if password and confirm password fields match
            if ($_POST['password'] == $_POST['cpassword'])
            {
                // convert password to hash
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                
                if ($con->query("INSERT INTO `clientAccounts` (`first_name`, `last_name`, `gender`, `dob`, `balance`, `aadhaar_no`, `email`, `password`, `contact_no`, `source`, `account_no`, `account_type`, `state`, `district`, `city`, `address`, `pincode`, `branch_id`, `date`) values ('$_POST[first_name]','$_POST[last_name]','$_POST[gender]','$_POST[dob]','$_POST[deposit]','$_POST[aadhaar_no]','$_POST[email]','$hash','$_POST[contact_no]','$_POST[source]','$_POST[account_no]','$_POST[account_type]','$_POST[state]','$_POST[district]','$_POST[city]','$_POST[address]','$_POST[pincode]','$_POST[branch_id]', CURRENT_TIMESTAMP)"))
                {
                    // check if user is employee OR manager and redirect to dashbord accordingly
                    if ($_GET['user'] == 'employee')
                        echo "<script>alert('Client added Successfully!');window.location.href='../employee/employee-dashboard.php'</script>";
                    else
                        echo "<script>alert('Client added Successfully!');window.location.href='../manager/manager-dashboard.php'</script>";
                }
                else
                {
                    // check if user is employee OR manager and redirect to dashbord accordingly
                    if ($_GET['user'] == 'employee')
                        echo "<script>alert('Failed to Add Client.');window.location.href='../employee/employee-dashboard.php'</script>";
                    else
                        echo "<script>alert('Failed to Add Client.');window.location.href='../manager/manager-dashboard.php'</script>";              
                }
            }
            else
            {
                // check if user is employee OR manager and redirect to dashbord accordingly
                if ($_GET['user'] == 'employee')
                    echo "<script>alert('Confirmed Password Did Not Match.\\nFailed to Add Client.');window.location.href='../employee/employee-dashboard.php'</script>";
                else
                    echo "<script>alert('Confirmed Password Did Not Match.\\nFailed to Add Client.');window.location.href='../manager/manager-dashboard.php'</script>";            
            }
        }
    }
    
    // form request to add an employee to db by manager
    if (isset($_POST['add_employee']))
    {
        // convert the POST variables to uppercase
        $_POST['first_name'] = strtoupper($_POST['first_name']);
        $_POST['last_name'] = strtoupper($_POST['last_name']);
        $_POST['district'] = strtoupper($_POST['district']);
        $_POST['city'] = strtoupper($_POST['city']);
        $_POST['address'] = strtoupper($_POST['address']);

        // check if the email id. is already registered or not
        $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `employeeAccounts`.`email` = '$_POST[email]'");

        if ($ar->num_rows > 0)
        {
            echo "<script>alert('Email Id. Already Present.\\nFailed to Add Client.');window.location.href='../manager/manager-dashboard.php'</script>";
        }
        else
        {
            // check if password and confirm password fields match
            if ($_POST['password'] == $_POST['cpassword'])
            {
                // convert password to hash
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($con->query("INSERT INTO `employeeAccounts` (`first_name`, `last_name`, `dob`, `aadhaar_no`, `email`, `password`, `contact_no`, `emp_id`, `state`, `district`, `city`, `address`, `date`) VALUES ('$_POST[first_name]','$_POST[last_name]','$_POST[dob]','$_POST[aadhaar_no]','$_POST[email]','$hash','$_POST[contact_no]','$_POST[emp_id]','$_POST[state]','$_POST[district]','$_POST[city]','$_POST[address]', CURRENT_TIMESTAMP)"))
                {
                    echo "<script>alert('Employee added Successfully!');window.location.href='../manager/manager-dashboard.php'</script>";
                }
                else
                    echo "<script>alert('Failed to Add Employee.');window.location.href='../manager/manager-dashboard.php'</script>";
            }
            else
                echo "<script>alert('Confirmed Password Did Not Match.\\nFailed to Add Employee.');window.location.href='../manager/manager-dashboard.php'</script>";
        }
    }


    
    // ------------------------------ start of edit form ---------------------------------//
    
    // form request to edit a client in db by employee OR manager
    if (isset($_POST['edit_client']))
    {
        // convert the POST variables to uppercase
        $_POST['source'] = strtoupper($_POST['source']);
        $_POST['account_type'] = strtoupper($_POST['account_type']);
        $_POST['district'] = strtoupper($_POST['district']);
        $_POST['city'] = strtoupper($_POST['city']);
        $_POST['address'] = strtoupper($_POST['address']);

        // check if the email id. is already registered or not except his current email id.
        $ar = $con->query("SELECT * FROM `clientAccounts` WHERE `clientAccounts`.`email` = '$_POST[email]' AND `clientAccounts`.`id` <> '$_GET[editId]'");

        if ($ar->num_rows > 0)
        {
            if ($_GET['user'] == 'employee')
                echo "<script>alert('Email Id. Already Present.\\nFailed to Edit Client Details.');window.location.href='../employee/client-details-edit.php'</script>";
            else
                echo "<script>alert('Email Id. Already Present.\\nFailed to Edit Client Details.');window.location.href='../manager/client-details-edit.php'</script>";
        }
        else
        {  
            if ($con->query("UPDATE `clientAccounts` SET `email` = '$_POST[email]', `contact_no` = '$_POST[contact_no]', `source` = '$_POST[source]', `account_type` = '$_POST[account_type]', `state` = '$_POST[state]', `district` = '$_POST[district]', `city` = '$_POST[city]', `address` = '$_POST[address]', `pincode` = '$_POST[pincode]', `branch_id` = '$_POST[branch_id]' WHERE `id` = '$_GET[editId]'"))
                {
                    // check if user is employee OR manager and redirect to dashbord accordingly
                    if ($_GET['user'] == 'employee')
                        echo "<script>alert('Client Details Edited Successfully!');window.location.href='../employee/client-details-edit.php'</script>";
                    else
                        echo "<script>alert('Client Details Edited Successfully!');window.location.href='../manager/client-details-edit.php'</script>";
                }
                else
                {
                    // check if user is employee OR manager and redirect to dashbord accordingly
                    if ($_GET['user'] == 'employee')
                        echo "<script>alert('Failed to Edit Client Details.')</script>";
                    else
                        echo "<script>alert('Failed to Edit Client Details.');window.location.href='../manager/client-details-edit.php'</script>";              
                }
        }
    }


    // form request to edit a client in db by manager
    if (isset($_POST['edit_employee']))
    {
        // convert the POST variables to uppercase
        $_POST['district'] = strtoupper($_POST['district']);
        $_POST['city'] = strtoupper($_POST['city']);
        $_POST['address'] = strtoupper($_POST['address']);

        // check if the email id. is already registered or not except his current email id.
        $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `employeeAccounts`.`email` = '$_POST[email]' AND `employeeAccounts`.`id` <> '$_SESSION[editId]'");

        if ($ar->num_rows > 0)
        {
            echo "<script>alert('Email Id. Already Present.\\nFailed to Edit Employee Details.');window.location.href='../manager/employee-details-edit.php'</script>";
        }
        else
        {  
            if ($con->query("UPDATE `employeeAccounts` SET `email` = '$_POST[email]', `contact_no` = '$_POST[contact_no]', `state` = '$_POST[state]', `district` = '$_POST[district]', `city` = '$_POST[city]', `address` = '$_POST[address]' WHERE `id` = '$_SESSION[editId]'"))
                {
                    echo "<script>alert('Employee Details Edited Successfully!');window.location.href='../manager/employee-details-edit.php'</script>";
                }
                else
                {
                    echo "<script>alert('Failed to Edit Employee Details.');window.location.href='../manager/employee-details-edit.php'</script>";              
                }
        }
    }
?>
<?php

    // very important to get the session variables 
    session_start();

    // if client OR employee OR manager is logged off then redirect to login page 
    if(!isset($_SESSION['clientId']) && !isset($_SESSION['employeeId']) && !isset($_SESSION['managerId']))
        header('location:../index.php');

    // connection to database
    include "connect.php";



    // ------------------------------ start of client password reset ---------------------------------//

    if(isset($_POST['clientResetPass']))
    {
        $pass = $_POST['current-password'];

        $ar = $con->query("SELECT * FROM `clientAccounts` WHERE `clientAccounts`.`id` = '$_SESSION[clientId]'"); 
        $data = $ar->fetch_assoc();

        // check if the password hash is equal or not
        if (password_verify($pass, $data['password']))
        {
            // check if password and confirm password fields match
            if ($_POST['password'] == $_POST['cpassword'])
            {
                // convert password to hash
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($con->query("UPDATE `clientAccounts` SET `password` = '$hash' WHERE `id` = '$_SESSION[clientId]'"))
                    echo "<script>alert('Password Reset Successful!');window.location.href='logout.php?clientLogout=clientLogout'</script>";
                else
                    echo "<script>alert('Failed To Reset Password.');window.location.href='logout.php?clientLogout=clientLogout'</script>";                
            }
            else
                echo "<script>alert('Confirmed Password Did Not Match.\\nFailed To Reset Password.');window.location.href='reset-password.php?userClient=".$_GET['userClient']."&clientName=".$_GET['clientName']."'</script>";
        }
        else
            echo "<script>alert('Password Did Not Match.\\nFailed To Reset Password.');window.location.href='reset-password.php?userClient=".$_GET['userClient']."&clientName=".$_GET['clientName']."'</script>";
    }



    // ------------------------------ start of employee password reset ---------------------------------//

    if(isset($_POST['employeeResetPass']))
    {
        $pass = $_POST['current-password'];

        $ar = $con->query("SELECT * FROM `employeeAccounts` WHERE `employeeAccounts`.`id` = '$_SESSION[employeeId]'"); 
        $data = $ar->fetch_assoc();

        // check if the password hash is equal or not
        if (password_verify($pass, $data['password']))
        {
            // check if password and confirm password fields match
            if ($_POST['password'] == $_POST['cpassword'])
            {
                // convert password to hash
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($con->query("UPDATE `employeeAccounts` SET `password` = '$hash' WHERE `id` = '$_SESSION[employeeId]'"))
                    echo "<script>alert('Password Reset Successful!');window.location.href='logout.php?employeeLogout=employeeLogout'</script>";
                else
                    echo "<script>alert('Failed To Reset Password.');window.location.href='logout.php?employeeLogout=employeeLogout'</script>";                
            }
            else
                echo "<script>alert('Confirmed Password Did Not Match.\\nFailed To Reset Password.');window.location.href='reset-password.php?userEmployee=".$_GET['userEmployee']."&employeeName=".$_GET['employeeName']."'</script>";
        }
        else
            echo "<script>alert('Password Did Not Match.\\nFailed To Reset Password.');window.location.href='reset-password.php?userEmployee=".$_GET['userEmployee']."&employeeName=".$_GET['employeeName']."'</script>";
    }



    // ------------------------------ start of manager password reset ---------------------------------//

    if(isset($_POST['managerResetPass']))
    {
        $pass = $_POST['current-password'];

        $ar = $con->query("SELECT * FROM `managerLogin` WHERE `managerLogin`.`id` = '$_SESSION[managerId]'"); 
        $data = $ar->fetch_assoc();

        // check if the password hash is equal or not
        if (password_verify($pass, $data['password']))
        {
            // check if password and confirm password fields match
            if ($_POST['password'] == $_POST['cpassword'])
            {
                // convert password to hash
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($con->query("UPDATE `managerLogin` SET `password` = '$hash' WHERE `id` = '$_SESSION[managerId]'"))
                    echo "<script>alert('Password Reset Successful!');window.location.href='logout.php?managerLogout=managerLogout'</script>";
                else
                    echo "<script>alert('Failed To Reset Password.');window.location.href='logout.php?managerLogout=managerLogout'</script>";                
            }
            else
                echo "<script>alert('Confirmed Password Did Not Match.\\nFailed To Reset Password.');window.location.href='reset-password.php?userManager=".$_GET['userManager']."&managerName=".$_GET['managerName']."'</script>";
        }
        else
            echo "<script>alert('Password Did Not Match.\\nFailed To Reset Password.');window.location.href='reset-password.php?userManager=".$_GET['userManager']."&managerName=".$_GET['managerName']."'</script>";
    }
?>
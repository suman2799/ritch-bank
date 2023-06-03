<?php

    // connection to database
    include 'connect.php';



    // ----------------------------- for client login ------------------------------//

    if(isset($_POST['clientLogin']))
    {
        $user = $_POST['email'];
        $pass = $_POST['password'];
        
        $result = $con->query( "SELECT * FROM `clientAccounts` WHERE `email` = '$user'");
        if($result->num_rows>0)
        {
            $data = $result->fetch_assoc();

            // check if the password hash is equal or not
            if (password_verify($pass, $data['password']))
            {
                session_start();
                $_SESSION['clientId']=$data['id'];
                header('location:../client/client-dashboard.php');
            }
            else
                echo "<script>alert('Invalid Credentials. Try again!');window.location.href='../index.php'</script>";
        }
        else
            echo "<script>alert('Invalid Credentials. Try again!');window.location.href='../index.php'</script>";
    }



    // ------------------------------- for employee login -------------------------------//
    
    if(isset($_POST['employeeLogin']))
    {
        $user = $_POST['email'];
        $pass = $_POST['password'];
        
        $result = $con->query( "SELECT * FROM `employeeAccounts` WHERE `email` = '$user'");
        if($result->num_rows>0)
        {
            $data = $result->fetch_assoc();

            // check if the password hash is equal or not
            if (password_verify($pass, $data['password']))
            {
                session_start();
                $_SESSION['employeeId'] = $data['id'];                    
                $_SESSION['employeeName'] = $data['first_name'];
                header('location:../employee/employee-dashboard.php');
            }
            else
                echo "<script>alert('Invalid Credentials. Try again!');window.location.href='../index.php'</script>";
        }
        else
            echo "<script>alert('Invalid Credentials. Try again!');window.location.href='../index.php'</script>";
    }



    // ------------------------------- for manager login -------------------------------//
    
    if(isset($_POST['managerLogin']))
    {
        $user = $_POST['email'];
        $pass = $_POST['password'];
        
        $result = $con->query( "SELECT * FROM `managerLogin` WHERE `email` = '$user'");
        if($result->num_rows>0)
        {
            $data = $result->fetch_assoc();

            // check if the password hash is equal or not
            if (password_verify($pass, $data['password']))
            {
                session_start();
                $_SESSION['managerId'] = $data['id'];                    
                $_SESSION['managerName'] = $data['first_name'];
                header('location:../manager/manager-dashboard.php');
            }
            else
                echo "<script>alert('Invalid Credentials. Try again!');window.location.href='../index.php'</script>";
        }
        else
            echo "<script>alert('Invalid Credentials. Try again!');window.location.href='../index.php'</script>";
    }
?>
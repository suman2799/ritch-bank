<?php

    // very important to get the session variables 
    session_start();



    // ------------------------------ for client logout ---------------------------------//
    if (isset($_GET['clientLogout']))
    {        
        unset($_SESSION['clientId']);
        unset($_SESSION['clientName']);
        unset($_SESSION['bal']);
    }
    // ------------------------------ for employee logout ---------------------------------//
    elseif (isset($_GET['employeeLogout']))
    {
        unset($_SESSION['employeeId']);
        unset($_SESSION['employeeName']);
    }
    // ------------------------------ for manager logout ---------------------------------//
    else
    {
        unset($_SESSION['managerId']);
        unset($_SESSION['managerName']);
    }

    // redirect to login page on logout
    header('location:../index.php');

?>
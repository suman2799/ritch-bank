<?php
    
    // very important to get the session variables
	session_start();

    // if employee is logged off then redirect to login page
	if (!isset($_SESSION['employeeId']))
	    header('location:../index.php');

    // connection to database
    include "connect.php";



    // ------------------------------ start of debit form ---------------------------------//

    if (isset($_POST['debit-fund']))
    {
        $ar = $con->query("SELECT * FROM `clientaccounts` WHERE account_no = '$_POST[account_no]' LIMIT 1");
        $userData = $ar->fetch_assoc();

        // check if client exists or not
        if ($ar->num_rows >0)
        {
            if ($userData['balance'] >= $_POST['amount'])
            {
                $amount = $userData['balance'] - $_POST['amount'];
                $result = $con->query("UPDATE `clientaccounts` SET balance = $amount WHERE account_no = '$_POST[account_no]' LIMIT 1");

                // check if client balance updated or not
                if ($con->affected_rows > 0)
                {
                    $tr = $con->query("INSERT INTO `transclient` (`action`,`from_account`,`trans_amount`) VALUES ('withdraw','$_POST[account_no]','$_POST[amount]')");

                    // check if transaction details recorded or not
                    if ($con->affected_rows > 0)
                    {
                        echo "<script>alert('Fund Debited Successfully!');window.location.href='../employee/employee-dashboard.php'</script>";
                    }
                    else
                        echo "<script>alert('Fund Debited but Transactions Not Updated.');window.location.href='../employee/employee-dashboard.php'</script>";
                }
                else
                    echo "<script>alert('Fund Not Debited.');window.location.href='../employee/employee-dashboard.php'</script>";
            }
            else 
                echo "<script>alert('Insufficient Balance.');window.location.href='../employee/employee-dashboard.php'</script>";
        }
        else
            echo "<script>alert('Client Not Found.');window.location.href='../employee/employee-dashboard.php'</script>";
    }
?>
<?php
    
    // very important to get the session variables 
	session_start();

    // if employee is logged off then redirect to login page
	if (!isset($_SESSION['employeeId']))
	    header('location:../index.php');

    // connection to database
    include "connect.php";



    // ------------------------------ start of credit form ---------------------------------//

    if (isset($_POST['credit-fund']))
    {
        // covert name & ifsc to uppercase
        $_POST['name'] = strtoupper($_POST['name']);
        $_POST['ifsc'] = strtoupper($_POST['ifsc']);

        // break ifsc into components
        $IFSC_bank_name = substr($_POST['ifsc'], 0, 4);
        $IFSC_control_no = substr($_POST['ifsc'], 4, 1);
        $IFSC_branch_code = substr($_POST['ifsc'], 5);
        
        // check if a valid ifsc entered or not
        if (ctype_alpha($IFSC_bank_name) && $IFSC_control_no == '0' && ctype_alnum($IFSC_branch_code))
        {
            // client details
            $arr = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `account_no` = '$_POST[account_no]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
            $userData = $arr->fetch_assoc();

            // client name and ifsc
            $name = $userData['first_name']." ".$userData['last_name'];
            $ifsc = "RTHB0".$userData['branch_code'];

            // check if the client exists for the given ifsc & name or not
            if ($arr->num_rows >0 && $_POST['ifsc'] == $ifsc && $_POST['name'] == $name)
            {
                $amount = $userData['balance'] + $_POST['amount'];
                $result = $con->query("UPDATE `clientaccounts` SET `balance` = $amount WHERE `account_no` = '$_POST[account_no]' LIMIT 1");
    
                // check if client balance updated or not
                if ($con->affected_rows > 0)
                {
                    $tr = $con->query("INSERT INTO `transclient` (`action`,`to_name`,`to_ifsc`,`to_account`,`trans_amount`) VALUES ('deposit','$_POST[name]','$_POST[ifsc]','$_POST[account_no]','$_POST[amount]')");
    
                    // check if transaction details recorded or not
                    if ($con->affected_rows > 0)
                        echo "<script>alert('Fund Credited Successfully!');window.location.href='../employee/employee-dashboard.php'</script>";
                    else
                        echo "<script>alert('Fund Credited but Transactions Not Updated.');window.location.href='../employee/employee-dashboard.php'</script>";
                }
                else
                    echo "<script>alert('Fund Not Credited.');window.location.href='../employee/employee-dashboard.php'</script>";
            }
            else
                echo "<script>alert('Client Not Found.');window.location.href='../employee/employee-dashboard.php'</script>";
        }
        else
            echo "<script>alert('Please Enter a Proper IFSC Code.');window.location.href='../employee/employee-dashboard.php'</script>";
    }
?>
<?php
    
    // very important to get the session variables 
	session_start();

    // if client OR employee is logged off then redirect to login page 
	if (!isset($_SESSION['employeeId']) && !isset($_SESSION['clientId']))
	    header('location:../index.php');

    // connection to database
    include "connect.php";



    // ------------------------------ start of employee fund transfer ---------------------------------//

    if (isset($_GET['employee']))
    {
        if (isset($_POST['transfer-fund']))
        {
            // covert name & ifsc to uppercase
            $_POST['from_name'] = strtoupper($_POST['from_name']);
            $_POST['from_ifsc'] = strtoupper($_POST['from_ifsc']);
            $_POST['to_name'] = strtoupper($_POST['to_name']);
            $_POST['to_ifsc'] = strtoupper($_POST['to_ifsc']);

            // break ifsc into components
            $IFSC_bank_name = substr($_POST['to_ifsc'], 0, 4);
            $IFSC_control_no = substr($_POST['to_ifsc'], 4, 1);
            $IFSC_branch_code = substr($_POST['to_ifsc'], 5);  

            // check if a valid ifsc entered or not
            if (ctype_alpha($IFSC_bank_name) && $IFSC_control_no == '0' && ctype_alnum($IFSC_branch_code))
            {
                // check if ifsc of RITCH bank or not
                if ($IFSC_bank_name == 'RTHB')
                {
                    // sender details
                    $from_acc = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `account_no` = '$_POST[from_account]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                    $userData_from = $from_acc->fetch_assoc();
        
                    // sender name and ifsc
                    $from_name = $userData_from['first_name']." ".$userData_from['last_name'];
                    $from_ifsc = "RTHB0".$userData_from['branch_code'];

                    // check if the 'from' client exists for the given ifsc & name or not
                    if ($from_acc->num_rows >0 && $_POST['from_ifsc'] == $from_ifsc && $_POST['from_name'] == $from_name)
                    {
                        // receiver details
                        $to_acc = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `account_no` = '$_POST[to_account]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                        $userData_to = $to_acc->fetch_assoc();

                        // receiver name and ifsc
                        $to_name = $userData_to['first_name']." ".$userData_to['last_name'];
                        $to_ifsc = "RTHB0".$userData_to['branch_code'];
                        
                        // check if the 'to' account exists for the given ifsc and name or not
                        if ($to_acc->num_rows >0 && $_POST['to_ifsc'] == $to_ifsc && $_POST['to_name'] == $to_name)
                        {                            
                            // check if transfering money to same account or not
                            if ($userData_from['account_no'] == $userData_to['account_no'])
                            {
                                echo "<script>alert('Cannot Transfer To Self.\\nFund Transfer Failed.');window.location.href='../employee/employee-dashboard.php'</script>";
                            }
                            // if transfering money to different account
                            else
                            {
                                // check if the user has insufficient balance for transfer
                                if ($userData_from['balance'] >= $_POST['amount'])
                                {
                                    // add fund to the receivier account
                                    $added_amount = $userData_to['balance'] + $_POST['amount'];
                                    $result_added = $con->query("UPDATE `clientaccounts` SET balance = $added_amount WHERE account_no = '$_POST[to_account]' LIMIT 1");
                                    
                                    // subtract fund from the sender account
                                    $subtracted_amount = $userData_from['balance'] - $_POST['amount'];
                                    $result_subtracted = $con->query("UPDATE `clientaccounts` SET balance = $subtracted_amount WHERE account_no = '$_POST[from_account]' LIMIT 1");
            
                                    // check if client balance updated or not
                                    if ($con->affected_rows > 0)
                                    {
                                        $tr = $con->query("INSERT INTO `transclient` (`action`,`from_name`,`from_ifsc`,`to_name`,`to_ifsc`,`from_account`,`to_account`,`trans_amount`) VALUES ('transfer','$_POST[from_name]','$_POST[from_ifsc]','$_POST[to_name]','$_POST[to_ifsc]','$_POST[from_account]','$_POST[to_account]','$_POST[amount]')");
            
                                        // check if transaction details recorded or not
                                        if ($con->affected_rows > 0)
                                        {
                                            echo "<script>alert('Fund Transfered Successfully!');window.location.href='../employee/employee-dashboard.php'</script>";
                                        }
                                        else
                                            echo "<script>alert('Fund Transfered but Transactions Not Updated.');window.location.href='../employee/employee-dashboard.php'</script>";
                                    }
                                    else
                                        echo "<script>alert('Fund Not Debited.');window.location.href='../employee/employee-dashboard.php'</script>";
                                }
                                // if the user has insufficient balance
                                else 
                                    echo "<script>alert('Insufficient Balance.');window.location.href='../employee/employee-dashboard.php'</script>";
                            }
                                                        
                        }
                        else
                            echo "<script>alert('Account Not Found To whom Funds are to be Transfered.');window.location.href='../employee/employee-dashboard.php'</script>";
                    }
                    else
                        echo "<script>alert('Account Not Found From whom Funds are to be Transfered.');window.location.href='../employee/employee-dashboard.php'</script>";
                }
                // transfer funds to a different bank
                else
                {
                    // sender details
                    $from_acc = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `account_no` = '$_POST[from_account]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                    $userData_from = $from_acc->fetch_assoc();

                    // sender name and ifsc
                    $from_name = $userData_from['first_name']." ".$userData_from['last_name'];
                    $from_ifsc = "RTHB0".$userData_from['branch_code'];

                    // check if the 'from' client exists for the given ifsc & name or not
                    if ($from_acc->num_rows >0 && $_POST['from_ifsc'] == $from_ifsc && $_POST['from_name'] == $from_name)
                    {
                        // check if the user has insufficient balance for transfer
                        if ($userData_from['balance'] >= $_POST['amount'])
                        {
                            // subtract fund from the sender account
                            $subtracted_amount = $userData_from['balance'] - $_POST['amount'];
                            $result_subtracted = $con->query("UPDATE `clientaccounts` SET balance = $subtracted_amount WHERE `account_no` = '$_POST[from_account]'");
    
                            // check if client balance updated or not
                            if ($con->affected_rows > 0)
                            {
                                $tr = $con->query("INSERT INTO `transclient` (`action`,`from_name`,`from_ifsc`,`to_name`,`to_ifsc`,`from_account`,`to_account`,`trans_amount`) VALUES ('transfer','$_POST[from_name]','$_POST[from_ifsc]','$_POST[to_name]','$_POST[to_ifsc]','$_POST[from_account]','$_POST[to_account]','$_POST[amount]')");
    
                                // check if transaction details recorded or not
                                if ($con->affected_rows > 0)
                                {
                                    echo "<script>alert('Fund Transfered Successfully!');window.location.href='../employee/employee-dashboard.php'</script>";
                                }
                                // if transaction details not recorded
                                else
                                {
                                    echo "<script>alert('Fund Transfered but Transactions Not Updated.');window.location.href='../employee/employee-dashboard.php'</script>";                                    
                                }
                            }
                            // if client balance not updated
                            else
                            {
                                echo "<script>alert('Fund Transfer Failed.');window.location.href='../employee/employee-dashboard.php'</script>";
                            }
                        }
                        // if the user has insufficient balance
                        else 
                        {
                            echo "<script>alert('Insufficient Balance.');window.location.href='../employee/employee-dashboard.php'</script>";
                        }                          
                    }
                    else
                        echo "<script>alert('Account Not Found From whom Funds are to be Transfered.');window.location.href='../employee/employee-dashboard.php'</script>";
                } 
            }
            else
                echo "<script>alert('Please Enter a Proper IFSC Code.');window.location.href='../employee/employee-dashboard.php'</script>";
        }            
    }



    // ------------------------------ start of client fund transfer ---------------------------------//

    if (isset($_GET['client']))
    {
        if (isset($_POST['transfer-fund']) || isset($_POST['transfer-fund-nav']))
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
                // check if ifsc of RITCH bank or not
                if ($IFSC_bank_name == 'RTHB')
                {
                    // sender details
                    $from_acc = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `id` = '$_SESSION[clientId]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id`");
                    $userData_from = $from_acc->fetch_assoc();
                    
                    // sender name and ifsc
                    $from_name = $userData_from['first_name']." ".$userData_from['last_name'];
                    $from_ifsc = "RTHB0".$userData_from['branch_code'];
        
                    // receiver details
                    $to_acc = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `account_no` = '$_POST[to_account]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id` LIMIT 1");
                    $userData_to = $to_acc->fetch_assoc();

                    // receiver name and ifsc
                    $to_name = $userData_to['first_name']." ".$userData_to['last_name'];
                    $to_ifsc = "RTHB0".$userData_to['branch_code'];
                    
                    // check if the 'to' account exists for the given ifsc and name or not
                    if ($to_acc->num_rows >0 && $_POST['ifsc'] == $to_ifsc && $_POST['name'] == $to_name)
                    {
                        // check if transfering money to same account or not
                        if ($userData_from['account_no'] == $_POST['to_account'])
                        {
                            if (isset($_POST['transfer-fund']))
                                echo "<script>alert('Cannot Transfer To Self.\\nFund Transfer Failed.');window.location.href='../client/client-dashboard.php'</script>";
                            else
                                echo "<script>alert('Cannot Transfer To Self.\\nFund Transfer Failed.');window.location.href='../client/client-transfer.php'</script>";
                        }
                        // if transfering money to different account
                        else
                        {
                            // check if the user has insufficient balance for transfer
                            if ($userData_from['balance'] >= $_POST['amount'])
                            {
                                // add fund to the receivier account
                                $added_amount = $userData_to['balance'] + $_POST['amount'];
                                $result_added = $con->query("UPDATE `clientaccounts` SET balance = $added_amount WHERE `account_no` = '$_POST[to_account]' LIMIT 1");
                                
                                // subtract fund from the sender account
                                $subtracted_amount = $userData_from['balance'] - $_POST['amount'];
                                $result_subtracted = $con->query("UPDATE `clientaccounts` SET balance = $subtracted_amount WHERE id = '$_SESSION[clientId]'");
        
                                // check if client balance updated or not
                                if ($con->affected_rows > 0)
                                {
                                    $tr = $con->query("INSERT INTO `transclient` (`action`,`from_name`,`from_ifsc`,`to_name`,`to_ifsc`,`from_account`,`to_account`,`trans_amount`) VALUES ('transfer','$from_name','$from_ifsc','$_POST[name]','$_POST[ifsc]','$userData_from[account_no]','$_POST[to_account]','$_POST[amount]')");
        
                                    // check if transaction details recorded or not
                                    if ($con->affected_rows > 0)
                                    {
                                        if (isset($_POST['transfer-fund']))
                                            echo "<script>alert('Fund Transfered Successfully!');window.location.href='../client/client-dashboard.php'</script>";
                                        else
                                            echo "<script>alert('Fund Transfered Successfully!');window.location.href='../client/client-transfer.php'</script>";
                                    }
                                    // if transaction details not recorded
                                    else
                                    {
                                        if (isset($_POST['transfer-fund']))
                                            echo "<script>alert('Fund Transfered but Transactions Not Updated.');window.location.href='../client/client-dashboard.php'</script>";
                                        else
                                            echo "<script>alert('Fund Transfered but Transactions Not Updated.');window.location.href='../client/client-transfer.php'</script>";                                    
                                    }
                                }
                                // if client balance not updated
                                else
                                {
                                    if (isset($_POST['transfer-fund']))
                                        echo "<script>alert('Fund Transfered Failed.');window.location.href='../client/client-dashboard.php'</script>";
                                    else
                                        echo "<script>alert('Fund Transfered Failed.');window.location.href='../client/client-transfer.php'</script>";
                                }
                            }
                            // if the user has insufficient balance
                            else 
                            {
                                if (isset($_POST['transfer-fund']))
                                    echo "<script>alert('Insufficient Balance.');window.location.href='../client/client-dashboard.php'</script>";
                                else
                                    echo "<script>alert('Insufficient Balance.');window.location.href='../client/client-transfer.php'</script>";
                            }                            
                        }
                    }
                    // if the 'to' account not found
                    else
                    {
                        if (isset($_POST['transfer-fund']))
                            echo "<script>alert('Account Not Found To whom Funds are to be Transfered.');window.location.href='../client/client-dashboard.php'</script>";
                        else
                            echo "<script>alert('Account Not Found To whom Funds are to be Transfered.');window.location.href='../client/client-transfer.php'</script>";
                    }          
                
                }
                // transfer funds to a different bank
                else
                {
                    // sender details
                    $from_acc = $con->query("SELECT * FROM `clientaccounts`,`branch` WHERE `id` = '$_SESSION[clientId]' AND `clientAccounts`.`branch_id` = `branch`.`branch_id`");
                    $userData_from = $from_acc->fetch_assoc();

                    // name and ifsc of the sender
                    $from_name = $userData_from['first_name']." ".$userData_from['last_name'];
                    $from_ifsc = "RTHB0".$userData_from['branch_code'];
        
                    // check if the user has insufficient balance for transfer
                    if ($userData_from['balance'] >= $_POST['amount'])
                    {
                        // subtract fund from the sender account
                        $subtracted_amount = $userData_from['balance'] - $_POST['amount'];
                        $result_subtracted = $con->query("UPDATE `clientaccounts` SET balance = $subtracted_amount WHERE id = '$_SESSION[clientId]'");

                        // check if client balance updated or not
                        if ($con->affected_rows > 0)
                        {
                            $tr = $con->query("INSERT INTO `transclient` (`action`,`from_name`,`from_ifsc`,`to_name`,`to_ifsc`,`from_account`,`to_account`,`trans_amount`) VALUES ('transfer','$from_name','$from_ifsc','$_POST[name]','$_POST[ifsc]','$userData_from[account_no]','$_POST[to_account]','$_POST[amount]')");

                            // check if transaction details recorded or not
                            if ($con->affected_rows > 0)
                            {
                                if (isset($_POST['transfer-fund']))
                                    echo "<script>alert('Fund Transfered Successfully!');window.location.href='../client/client-dashboard.php'</script>";
                                else
                                    echo "<script>alert('Fund Transfered Successfully!');window.location.href='../client/client-transfer.php'</script>";
                            }
                            // if transaction details not recorded
                            else
                            {
                                if (isset($_POST['transfer-fund']))
                                    echo "<script>alert('Fund Transfered but Transactions Not Updated.');window.location.href='../client/client-dashboard.php'</script>";
                                else
                                    echo "<script>alert('Fund Transfered but Transactions Not Updated.');window.location.href='../client/client-transfer.php'</script>";                                    
                            }
                        }
                        // if client balance not updated
                        else
                        {
                            if (isset($_POST['transfer-fund']))
                                echo "<script>alert('Fund Transfer Failed.');window.location.href='../client/client-dashboard.php'</script>";
                            else
                                echo "<script>alert('Fund Transfer Failed.');window.location.href='../client/client-transfer.php'</script>";
                        }
                    }
                    // if the user has insufficient balance
                    else 
                    {
                        if (isset($_POST['transfer-fund']))
                            echo "<script>alert('Insufficient Balance.');window.location.href='../client/client-dashboard.php'</script>";
                        else
                            echo "<script>alert('Insufficient Balance.');window.location.href='../client/client-transfer.php'</script>";
                    }                          
                } 
            }
            else
            {
                if (isset($_POST['transfer-fund']))
                    echo "<script>alert('Please Enter a Proper IFSC Code.');window.location.href='../client/client-dashboard.php'</script>";
                else
                    echo "<script>alert('Please Enter a Proper IFSC Code.');window.location.href='../client/client-transfer.php'</script>";
            }
        }
    }
?>
<?php 
    session_start();
    require_once('connection.php');
    require_once('middleware.php');

    if(!isset($_SESSION['user_role'])){ // all access
        $_SESSION['error_msg'] = 'Sign In to view that resource';
        header('Location: login.php');
        exit;
    }

    date_default_timezone_set("Asia/Kolkata");
    $epoch_time = time();
    $timestamp = date("y-m-d h:i:sa", $epoch_time);

    $case_date = '';
    $bank_name = '';
    $home_branch = '';
    $account_number = '';
    $customer_name = '';
    $npa_date = '';
    $outstanding = '';
    $arr_co_nd = '';
    $notice13_sent_on = '';
    $principal_outstanding = '';
    $bounce_charges = '';
    $overdue_charges = '';
    $other_charges = '';
    $loan_emi_amount = '';
    $no_of_emi_outstanding = '';
    $reg_no = '';
    $residence_address = '';
    $residence_contact_no = '';
    $office_address = '';
    $office_contact_no = '';
    $make = '';
    $engine_no = '';
    $chassis_no = '';
    $tenure = '';
    $co_applicant_name = '';
    $co_applicant_mobile = '';
    $co_applicant_address = '';
    $employer_name = '';
    $employer_mobile = '';
    $employer_address = '';
    $amount_recovered = '';
    $bill_raised = '';
    $payment_received = '';
    // errors
    $case_date_error = '';
    $bank_name_error = '';
    $home_branch_error = '';
    $account_number_error = '';
    $customer_name_error = '';
    $npa_date_error = '';
    $outstanding_error = '';
    $arr_co_nd_error = '';
    $notice13_sent_on_error = '';
    $principal_outstanding_error = '';
    $bounce_charges_error = '';
    $overdue_charges_error = '';
    $other_charges_error = '';
    $loan_emi_amount_error = '';
    $no_of_emi_outstanding_error = '';
    $reg_no_error = '';
    $residence_address_error = '';
    $residence_contact_no_error = '';
    $office_address_error = '';
    $office_contact_no_error = '';
    $make_error = '';
    $engine_no_error = '';
    $chassis_no_error = '';
    $tenure_error = '';
    $co_applicant_name_error = '';
    $co_applicant_mobile_error = '';
    $co_applicant_address_error = '';
    $employer_name_error = '';
    $employer_mobile_error = '';
    $employer_address_error = '';
    $amount_recovered_error = '';
    $bill_raised_error = '';
    $payment_received_error = '';


    if(isset($_POST['caseDate']) && isset($_POST['bankName']) && isset($_POST['homeBranch']) && isset($_POST['accountNo']) && isset($_POST['customerName']) && isset($_POST['npaDate']) && isset($_POST['outstanding']) && isset($_POST['arrCoNd']) && isset($_POST['notice13SentOn']) && isset($_POST['principalOutstanding']) && isset($_POST['bounceCharges']) && isset($_POST['overdueCharges']) && isset($_POST['otherCharges']) && isset($_POST['loanEmiAmount']) && isset($_POST['noOfEmiOutstanding']) && isset($_POST['regNo']) && isset($_POST['residenceAddress']) && isset($_POST['residenceContactNo']) && isset($_POST['officeAddress']) && isset($_POST['officeContactNo']) && isset($_POST['make']) && isset($_POST['engineNo']) && isset($_POST['chassisNo']) && isset($_POST['tenure']) && isset($_POST['coApplicantName']) && isset($_POST['coApplicantMobile']) && isset($_POST['coApplicantAddress']) && isset($_POST['employerName']) && isset($_POST['employerMobile']) && isset($_POST['employerAddress']) && isset($_POST['amountRecovered']) && isset($_POST['billRaised']) && isset($_POST['paymentReceived'])){
        // initialize variables with loan data
        $control = 1;
        $case_date = cleanInput($_POST['caseDate']);
        $bank_name = cleanInput($_POST['bankName']);
        $home_branch = cleanInput($_POST['homeBranch']);
        $account_number = cleanInput($_POST['accountNo']);
        $customer_name = cleanInput($_POST['customerName']);
        $npa_date = cleanInput($_POST['npaDate']);
        $outstanding = cleanInput($_POST['outstanding']);
        $arr_co_nd = cleanInput($_POST['arrCoNd']);
        $notice13_sent_on = cleanInput($_POST['notice13SentOn']);
        $principal_outstanding = cleanInput($_POST['principalOutstanding']);
        $bounce_charges = cleanInput($_POST['bounceCharges']);
        $overdue_charges = cleanInput($_POST['overdueCharges']);
        $other_charges = cleanInput($_POST['otherCharges']);
        $loan_emi_amount = cleanInput($_POST['loanEmiAmount']);
        $no_of_emi_outstanding = cleanInput($_POST['noOfEmiOutstanding']);
        $reg_no = cleanInput($_POST['regNo']);
        $residence_address = cleanInput($_POST['residenceAddress']);
        $residence_contact_no = cleanInput($_POST['residenceContactNo']);
        $office_address = cleanInput($_POST['officeAddress']);
        $office_contact_no = cleanInput($_POST['officeContactNo']);
        $make = cleanInput($_POST['make']);
        $engine_no = cleanInput($_POST['engineNo']);
        $chassis_no = cleanInput($_POST['chassisNo']);
        $tenure = cleanInput($_POST['tenure']);
        $co_applicant_name = cleanInput($_POST['coApplicantName']);
        $co_applicant_mobile = cleanInput($_POST['coApplicantMobile']);
        $co_applicant_address = cleanInput($_POST['coApplicantAddress']);
        $employer_name = cleanInput($_POST['employerName']);
        $employer_mobile = cleanInput($_POST['employerMobile']);
        $employer_address = cleanInput($_POST['employerAddress']);
        $amount_recovered = cleanInput($_POST['amountRecovered']);
        $bill_raised = cleanInput($_POST['billRaised']);
        $payment_received = cleanInput($_POST['paymentReceived']);

        if(!empty($case_date)){
            if(!dateValidation($case_date)){
                $case_date_error = 'Invalid Date';
                $control = 0;
            }
        }
        else{
            $case_date_error = 'Required';
            $control = 0;
        }

        if(!empty($bank_name)){
            if(!alphaSpaceValidation($bank_name)){
                $bank_name_error = 'Invalid Name';
                $control = 0;
            }
            else{
              $bank_name = strtoupper($bank_name);
            }
        }
        else{
            $bank_name_error = 'Required';
            $control = 0;
        }

        if(!empty($home_branch)){
            if(!alphaSpaceValidation($home_branch)){
                $home_branch_error = 'Invalid Name';
                $control = 0;
            }
        }
        else{
            $home_branch_error = 'Required';
            $control = 0;
        }

        if(!empty($account_number)){
            if(!ctype_digit($account_number)){
                $account_number_error = 'Invalid account number';
            }
        }
        else{
            $account_number_error = 'Required';
            $control = 0;
        }

        if(!empty($customer_name)){
            if(!alphaSpaceValidation($customer_name)){
                $customer_name_error = 'Invalid Name';
                $control = 0;
            }
        }
        else{
            $customer_name_error = 'Required';
            $control = 0;
        }

        if(!empty($npa_date)){
            if(!dateValidation($npa_date)){
                $npa_date_error = 'Invalid date';
                $control = 0;
            }
        }
        else{
            $npa_date_error = 'Required';
            $control = 0;
        }

        if($outstanding != ''){
            if(!dateValidation($outstanding)){
                $outstanding_error = 'Invalid date';
                $control = 0;
            }
        }
        // else{
        //     $outstanding_error = 'Required';
        //     $control = 0;
        // }

        if($arr_co_nd != ''){
        }
        // else{
        //     $arr_co_nd_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($notice13_sent_on)){
            if(!dateValidation($notice13_sent_on)){
                $notice13_sent_on_error = 'Invalid date';
                $control = 0;
            }
        }
        // else{
        //     $notice13_sent_on_error = 'Required';
        //     $control = 0;
        // }

        if($principal_outstanding != ''){
            if(!amountValidation($principal_outstanding)){
                $principal_outstanding = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $principal_outstanding_error = 'Required';
        //     $control = 0;
        // }

        if($bounce_charges != ''){
            if(!amountValidation($bounce_charges)){
                $bounce_charges_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $bounce_charges_error = 'Required';
        //     $control = 0;
        // }

        if($overdue_charges != ''){
            if(!amountValidation($overdue_charges)){
                $overdue_charges_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $overdue_charges_error = 'Required';
        //     $control = 0;
        // }

        if($other_charges != ''){
            if(!amountValidation($other_charges)){
                $other_charges_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $other_charges_error = 'Required';
        //     $control = 0;
        // }

        if($loan_emi_amount != ''){
            if(!amountValidation($loan_emi_amount)){
                $loan_emi_amount_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $loan_emi_amount_error = 'Required';
        //     $control = 0;
        // }

        if($no_of_emi_outstanding != ''){
            if(!ctype_digit($no_of_emi_outstanding)){
                $no_of_emi_outstanding_error = 'Only digits!';
                $control = 0;
            }
        }
        // else{
        //     $no_of_emi_outstanding_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($reg_no)){
            if(!ctype_digit($reg_no)){
                $reg_no_error = 'Only digits!';
                $control = 0;
            }
        }
        // else{
        //     $reg_no_error = 'Required';
        //     $control = 0;
        // }
        
        if(!empty($residence_address)){
            if(!addressValidation($residence_address)){
                $residence_address_error = 'Invalid address';
                $control = 0;
            }
        }
        // else{
        //     $residence_address_error = 'Required';
        //     $control = 0;
        // }

        
        if(!empty($residence_contact_no)){
            if(!contactValidation($residence_contact_no)){
                $residence_contact_no_error = 'Invalid contact';
                $control = 0;
            }
        }
        // else{
        //     $residence_contact_no_error = 'Required';
        //     $control = 0;
        // }
        
        if(!empty($office_address)){
            if(!addressValidation($office_address)){
                $office_address_error = 'Invalid address';
                $control = 0;
            }
        }
        // else{
        //     $office_address_error = 'Required';
        //     $control = 0;
        // }

        
        if(!empty($office_contact_no)){
            if(!contactValidation($office_contact_no)){
                $office_contact_no_error = 'Invalid contact';
                $control = 0;
            }
        }
        // else{
        //     $office_contact_no_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($make)){

        }
        // else{
        //     $make_error = 'Required';
        //     $control = 0;
        // }
        
        if(!empty($engine_no)){
            if(!alphaNumericSpaceValidation($engine_no)){
                $engine_no_error = 'Invalid number';
                $control = 0;
            }
        }
        // else{
        //     $engine_no_error = 'Required';
        //     $control = 0;
        // }
        
        if(!empty($chassis_no)){
            if(!alphaNumericSpaceValidation($chassis_no)){
                $chassis_no_error = 'Invalid number';
                $control = 0;
            }
        }
        // else{
        //     $chassis_no_error = 'Required';
        //     $control = 0;
        // }
        
        if($tenure != ''){
            if(!alphaNumericSpaceValidation($tenure)){
                $tenure_error = 'Invalid number';
                $control = 0;
            }
        }
        // else{
        //     $tenure_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($co_applicant_name)){
            if(!alphaSpaceValidation($co_applicant_name)){
                $co_applicant_name_error = 'Invalid name';
                $control = 0;
            }
        }
        // else{
        //     $co_applicant_name_error = 'Required';
        //     $control = 0;
        // }
        
        if(!empty($co_applicant_mobile)){
            if(!contactValidation($co_applicant_mobile)){
                $co_applicant_mobile_error = 'Invalid number';
                $control = 0;
            }
        }
        // else{
        //     $co_applicant_mobile_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($co_applicant_address)){
            if(!addressValidation($co_applicant_address)){
                $co_applicant_address_error = 'Invalid address';
                $control = 0;
            }
        }
        // else{
        //     $co_applicant_address_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($employer_name)){
            if(!alphaSpaceValidation($employer_name)){
                $employer_name_error = 'Invalid name';
                $control = 0;
            }
        }
        // else{
        //     $employer_name_error = 'Required';
        //     $control = 0;
        // }
        
        if(!empty($employer_mobile)){
            if(!contactValidation($employer_mobile)){
                $employer_mobile_error = 'Invalid number';
                $control = 0;
            }
        }
        // else{
        //     $employer_mobile_error = 'Required';
        //     $control = 0;
        // }

        if(!empty($employer_address)){
            if(!addressValidation($employer_address)){
                $employer_address_error = 'Invalid address';
                $control = 0;
            }
        }
        // else{
        //     $employer_address_error = 'Required';
        //     $control = 0;
        // }


        if($amount_recovered != ''){
            if(!amountValidation($amount_recovered)){
                $amount_recovered_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $amount_recovered_error = 'Required';
        //     $control = 0;
        // }

        if($bill_raised != ''){
            if(!amountValidation($bill_raised)){
                $bill_raised_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $bill_raised_error = 'Required';
        //     $control = 0;
        // }

        if($payment_received != ''){
            if(!amountValidation($payment_received)){
                $payment_received_error = 'Invalid amount';
                $control = 0;
            }
        }
        // else{
        //     $payment_received_error = 'Required';
        //     $control = 0;
        // }
        
        if($control){ // Insert data into database control = 1
            $residence_address = str_replace("\n", "<br/>", $residence_address);
            $office_address = str_replace("\n", "<br/>", $office_address);
            $employer_address = str_replace("\n", "<br/>", $employer_address);
            $co_applicant_address = str_replace("\n", "<br/>", $co_applicant_address);
            $sql = "INSERT INTO `car_loan` (`car_loan_cid`, `case_date`, `bank_name`, `home_branch`, `account_number`, `customer_name`, `npa_date`, `outstanding`, `arr_co_nd`, `notice13_sent_on`, `principal_outstanding`, `bounce_charges`, `overdue_charges`, `other_charges`, `loan_emi_amount`, `no_of_emi_outstanding`, `reg_no`, `residence_address`, `residence_contact_no`, `office_address`, `office_contact_no`, `make`, `engine_no`, `chassis_no`, `tenure`, `co_applicant_name`, `co_applicant_mobile`, `co_applicant_address`, `employer_name`, `employer_mobile`, `employer_address`, `amount_recovered`, `bill_raised`, `payment_received`, `case_status`) VALUES (NULL, '$case_date', '$bank_name', '$home_branch', '$account_number', '$customer_name', '$npa_date', '$outstanding', '$arr_co_nd', '$notice13_sent_on', '$principal_outstanding', '$bounce_charges', '$overdue_charges', '$other_charges', '$loan_emi_amount', '$no_of_emi_outstanding', '$reg_no', '$residence_address', '$residence_contact_no', '$office_address', '$office_contact_no', '$make', '$engine_no', '$chassis_no', '$tenure', '$co_applicant_name', '$co_applicant_mobile', '$co_applicant_address', '$employer_name', '$employer_mobile', '$employer_address', '$amount_recovered', '$bill_raised', '$payment_received', '0')";
            if($conn->query($sql) === TRUE){ 
                $case_id = $conn->insert_id;
                $sql = "INSERT INTO `user_activity` (`activity_id`, `loan`, `case_id`, `user_id`, `operation_id`, `timestamp`) VALUES (NULL, '2', '$case_id', '$_SESSION[user_id]', '1', '$timestamp')";
                $conn->query($sql);
                $_SESSION['success_msg'] = 'Added successfully';
                header('Location: car-loan.php');
                exit; 
            }
            else{
                $_SESSION['error_msg'] = $conn->error;
            }
        }
        else{
            $_SESSION['note_msg'] = 'Fill required fields and make sure they are valid';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require 'includes/layout.php'; ?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php require 'includes/dashboard-header.php'; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php require 'includes/side-navigation.php'; ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Car Loan</h4>

                    <!-- Flash Message  -->
                    <?php require 'includes/flash-message.php'; ?>

                    <form class="pt-3" method="POST">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Case Date</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="case-date" type="date" class="form-control form-input" name="caseDate" placeholder="Password" value="<?php  ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $case_date_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('case-date').defaultValue = '<?php echo $case_date; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Bank Name</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-university"></i>
                                        </span>
                                    </div>
                                    <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control form-input" name="bankName" placeholder="Name" value="<?php echo $bank_name; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $bank_name_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Home Branch</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fa fa-code-branch"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="homeBranch" placeholder="Name" value="<?php echo $home_branch; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $home_branch_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Account Number</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-credit-card"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control form-input" id="" name="accountNo" placeholder="Number" value="<?php echo $account_number; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $account_number_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Customer Name</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="customerName" placeholder="Name" value="<?php echo $customer_name; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $customer_name_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">NPA Date</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="npa-date" type="date" name="npaDate" class="form-control form-input">
                                    </div>   
                                    <div class="form-input-response">
                                        <?php echo $npa_date_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('npa-date').defaultValue = '<?php echo $npa_date; ?>'
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Outstanding</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="outstanding" name="outstanding" value="<?php echo $outstanding; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $outstanding_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('outstanding').defaultValue = '<?php echo $outstanding; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">ARR-CO ND</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-percent"></i>
                                        </span>
                                    </div>
                                    <input type="text" step="0.000001" class="form-control form-input"  name="arrCoNd"  value="<?php echo $arr_co_nd; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $arr_co_nd_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Notice 13(2) Sent On</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="notice-13" type="date" class="form-control form-input" id="" name="notice13SentOn" placeholder="Password" value="<?php  ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $notice13_sent_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('notice-13').defaultValue = '<?php echo $notice13_sent_on; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Principal Outstanding</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="principalOutstanding" placeholder="Amount" value="<?php echo $principal_outstanding; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $principal_outstanding_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Bounce Charges</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="bounceCharges" placeholder="Amount" value="<?php echo $bounce_charges; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $bounce_charges_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Overdue Charges</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="overdueCharges" placeholder="Amount" value="<?php echo $overdue_charges; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $overdue_charges_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Other Charges</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="otherCharges" placeholder="Amount" value="<?php echo $other_charges; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $other_charges_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Loan EMI Amount</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="loanEmiAmount" placeholder="Amount" value="<?php echo $loan_emi_amount; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $loan_emi_amount_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">No Of EMI Outstanding</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-sort-numeric-up"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control form-input" id="" name="noOfEmiOutstanding" placeholder="Number" value="<?php echo $no_of_emi_outstanding; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $no_of_emi_outstanding_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">REG No</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="far fa-registered"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control form-input" id="" name="regNo" placeholder="Number" value="<?php echo $reg_no; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $reg_no_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Residence Address</label>
                                    <div class="input-group">
                                    <textarea class="form-control form-input" name="residenceAddress" id="" cols="30" rows="10"><?php echo $residence_address; ?></textarea>
                                    </div>
                                    <div id="password-validate-response" class="form-input-response">
                                        <?php echo $residence_address_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Residence Contact No</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-primary text-white br">
                                                <i class="fas fa-phone-alt"></i>
                                            </span>
                                        </div>
                                        <input type="number" class="form-control form-input" id="" name="residenceContactNo" placeholder="Number" value="<?php echo $residence_contact_no; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $residence_contact_no_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Office Address</label>
                                    <div class="input-group">
                                    <textarea class="form-control form-input" name="officeAddress" id="" cols="30" rows="10"><?php echo $office_address; ?></textarea>
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $office_address_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Office Contact No</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-phone-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control form-input" id="" name="officeContactNo" placeholder="Number" value="<?php echo $office_contact_no; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $office_contact_no_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Make</label>
                                    <div class="input-group">
                                    <textarea class="form-control form-input" name="make" id="" cols="30" rows="10"><?php echo $make; ?></textarea>
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $make_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Engine Number</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-car"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="engineNo" value="<?php echo $engine_no; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $engine_no_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Chassis Number</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-car"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="chassisNo" value="<?php echo $chassis_no; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $chassis_no_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Tenure</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="tenure"  value="<?php echo $tenure; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $tenure_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Co Applicant Name</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="coApplicantName" placeholder="Name" value="<?php echo $co_applicant_name; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $co_applicant_name_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Co Applicant Mobile</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-phone-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control form-input" id="" name="coApplicantMobile" placeholder="Number" value="<?php echo $co_applicant_mobile; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $co_applicant_mobile_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Co Applicant Address</label>
                                    <div class="input-group">
                                    <textarea class="form-control form-input" name="coApplicantAddress" id="" cols="30" rows="10"><?php echo $co_applicant_address; ?></textarea>
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $co_applicant_address_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Employer Name</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-input" id="" name="employerName" placeholder="Name" value="<?php echo $employer_name; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $employer_name_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Employer Mobile</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-phone-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control form-input" id="" name="employerMobile" placeholder="Number" value="<?php echo $employer_mobile; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $employer_mobile_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Employer Address</label>
                                    <div class="input-group">
                                    <textarea class="form-control form-input" name="employerAddress" id="" cols="30" rows="10"><?php echo $employer_address; ?></textarea>
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $employer_address_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Amount Recovered</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="amountRecovered" placeholder="Amount" value="<?php echo $amount_recovered; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $amount_recovered_error; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Bill Raised</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="billRaised" placeholder="Amount" value="<?php echo $bill_raised; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $bill_raised_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Payment Received</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.000001" class="form-control form-input" id="" name="paymentReceived" placeholder="Amount" value="<?php echo $payment_received; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $payment_received_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-inline justify-content-end">
                            <button class="btn btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Create</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <!-- <footer class="footer">
          </footer> -->
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/file-upload.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
<?php 
    $conn->close();
?>
<?php 
    session_start();
    require_once('connection.php');

    if(!isset($_SESSION['user_role'])){ // all access
        $_SESSION['error_msg'] = 'Sign In to view that resource';
        header('Location: login.php');
        exit;
    }

    date_default_timezone_set("Asia/Kolkata");
    $epoch_time = time();
    $timestamp = date("y-m-d h:i:sa", $epoch_time);


    require_once('middleware.php');

    $db_error = '';
    if(isset($_GET['cid'])){
        $case_id = base64_decode($_GET['cid']);
        $sql = "SELECT home_loan_cid FROM home_loan WHERE home_loan_cid = '$case_id'";
        $result = $conn->query($sql);
        
        if($conn->error == ''){
            if($result->num_rows != 1){
                $_SESSION['error_msg'] = 'No comment with the given case ID';
                header('Location: view-home-loans.php');
                exit;
            }
            else{
                $valid_case = true;
            }
        }
        else{
            $_SESSION['error_msg'] = 'Something went wrong!';
            $db_error = $conn->error;
            header('Location: view-home-loans.php');
        }
    }

    $date_of_next_hearing = '';
    $order_received_on = '';
    $order_forwarded_to_bank_on = '';
    $lease_on = '';
    $physical_possession_on = '';
    $notice_of_physical_possession_on = '';
    $possession_taken_on = '';
    $possession_postpone_on = '';
    $postpone_reason = '';
    $property_on_auction = '';
    $reserve_price = '';
    $emd_amount = '';
    $property_visit_by_prospective_buyers_on = '';
    $auction_date = '';
    $auction_status = '-1';
    $doc_for_redirection_of_order_given_to_advocate_on = '';
    $redirection_order_filled_with_dm_cmm_on = '';
    $redirection_order_received_on = '';
    //errors

    $date_of_next_hearing_error = '';
    $order_received_on_error = '';
    $order_forwarded_to_bank_on_error = '';
    $lease_on_error = '';
    $physical_possession_on_error = '';
    $notice_of_physical_possession_on_error = '';
    $possession_taken_on_error = '';
    $possession_postpone_on_error = '';
    $postpone_reason_error = '';
    $property_on_auction_error = '';
    $reserve_price_error = '';
    $emd_amount_error = '';
    $property_visit_by_prospective_buyers_on_error = '';
    $auction_date_error = '';
    $auction_status_error = '';
    $doc_for_redirection_of_order_given_to_advocate_on_error = '';
    $redirection_order_filled_with_dm_cmm_on_error = '';
    $redirection_order_received_on_error = '';


    if(isset($_POST['dateOfNextHearing']) && isset($_POST['orderReceivedOn']) && isset($_POST['orderForwardedOn']) && isset($_POST['leaseOn']) && isset($_POST['physicalPossessionOn']) && isset($_POST['noticeOfPhysicalPossessionOn']) && isset($_POST['possessionTakenOn']) && isset($_POST['possessionPostponeOn']) && isset($_POST['postponeReason']) && isset($_POST['propertyOnAuction']) && isset($_POST['reservePrice']) && isset($_POST['emdAmount']) && isset($_POST['prospectiveBuyerOn']) && isset($_POST['auctionDate']) && isset($_POST['docRedirectionToAdvocateOn']) && isset($_POST['redirectionOrderWithDmCmmOn']) && isset($_POST['redirectionOrderReceivedOn'])){
        // initialize variables with loan data
        $control = 1;
        $date_of_next_hearing = cleanInput($_POST['dateOfNextHearing']);
        $order_received_on = cleanInput($_POST['orderReceivedOn']);
        $order_forwarded_to_bank_on = cleanInput($_POST['orderForwardedOn']);
        $lease_on = cleanInput($_POST['leaseOn']);
        $physical_possession_on = cleanInput($_POST['physicalPossessionOn']);
        $notice_of_physical_possession_on = cleanInput($_POST['noticeOfPhysicalPossessionOn']);
        $possession_taken_on = cleanInput($_POST['possessionTakenOn']);
        $possession_postpone_on = cleanInput($_POST['possessionPostponeOn']);
        $postpone_reason = cleanInput($_POST['postponeReason']);
        $property_on_auction = cleanInput($_POST['propertyOnAuction']);
        $reserve_price = cleanInput($_POST['reservePrice']);
        $emd_amount = cleanInput($_POST['emdAmount']);
        $property_visit_by_prospective_buyers_on = cleanInput($_POST['prospectiveBuyerOn']);
        $auction_date = cleanInput($_POST['auctionDate']);
        if(isset($_POST['auctionStatus'])){
            $auction_status = cleanInput($_POST['auctionStatus']);
            if($auction_status !='1' && $auction_status != '0' && $auction_status != '-1'){
                $auction_status_error = 'You tried Invalid status code';
                $control = 0;
                $auction_status = '-1';
            }
        }
        else{
            $auction_status = '-1';
        }
        $doc_for_redirection_of_order_given_to_advocate_on = cleanInput($_POST['docRedirectionToAdvocateOn']);
        $redirection_order_filled_with_dm_cmm_on = cleanInput($_POST['redirectionOrderWithDmCmmOn']);
        $redirection_order_received_on = cleanInput($_POST['redirectionOrderReceivedOn']);

        if(!empty($date_of_next_hearing)){
            if(!dateValidation($date_of_next_hearing)){
                $date_of_next_hearing_error = 'Invalid Date';
                $control = 0;
            }
        }
        else{
            $date_of_next_hearing_error = 'Required';
            $control = 0;
        }

        if($control){ // Insert data into database control = 1
            $postpone_reason = str_replace("\n", "<br/>", $postpone_reason);
            $sql = "INSERT INTO `home_loan_comments` (`comment_id`, `case_id`, `date_of_next_hearing`, `order_received_on`, `order_forwarded_to_bank_on`, `lease_on`, `physical_possession_on`, `notice_of_physical_possession`, `possession_taken_on`, `possession_postpone_on`, `possession_postpone_reason`, `property_on_auction`, `reserve_price`, `emd_amount`, `property_visit_by_prospective_buyers_on`, `auction_date`, `auction_status`, `doc_for_redirection_of_order_given_to_advocate_on`, `redirection_order_filled_with_dm_cmm_on`, `redirection_order_received_on`) VALUES (NULL, '$case_id', '$date_of_next_hearing', '$order_received_on', '$order_forwarded_to_bank_on', '$lease_on', '$physical_possession_on', '$notice_of_physical_possession_on', '$possession_taken_on', '$possession_postpone_on', '$postpone_reason', '$property_on_auction', '$reserve_price', '$emd_amount', '$property_visit_by_prospective_buyers_on', '$auction_date', '$auction_status', '$doc_for_redirection_of_order_given_to_advocate_on', '$redirection_order_filled_with_dm_cmm_on', '$redirection_order_received_on')";
            $conn->query($sql); 
            
            if($conn->error == ''){ 
                $_SESSION['success_msg'] = 'Added successfully';
                header('Location: view-home-loans.php');
                exit;   
            }   
            else{
                $_SESSION['error_msg'] = 'Something went wrong!';
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home Loan</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <script src="https://kit.fontawesome.com/196c90f518.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/home-loan.js"></script>
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
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
                    <h4 class="card-title">Add Status</h4>
                      <?php 
                          if(isset($_SESSION['success_msg'])){
                              ?>
                              <div class="success-msg">
                                  <i class="fa fa-check"></i>
                                  <span>
                                      <?php echo $_SESSION['success_msg']; ?>
                                  </span>
                              </div>
                              <?php
                              unset($_SESSION['success_msg']);
                          }
                      ?>
                      <?php 
                          if(isset($_SESSION['error_msg'])){
                              ?>
                              <div class="error-msg">
                                  <i class="fa fa-close"></i>
                                  <span>
                                      <?php echo $_SESSION['error_msg']; ?>
                                  </span>
                              </div>
                              <?php
                              unset($_SESSION['error_msg']);
                          }
                      ?>
                      <?php 
                          if(isset($_SESSION['note_msg'])){
                              ?>
                              <div class="note-msg">
                                  <i class="far fa-comment-dots"></i>
                                  <span>
                                      <?php echo $_SESSION['note_msg']; ?>
                                  </span>
                              </div>
                              <?php
                              unset($_SESSION['note_msg']);
                          }
                      ?>
                      

                    <!-- Home loan form -->
                    <form class="pt-3" method="POST">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Date of Next Hearing</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="date-of-next-hearing" type="date" class="form-control form-input" name="dateOfNextHearing">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $date_of_next_hearing_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('date-of-next-hearing').defaultValue = '<?php echo $date_of_next_hearing; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Order received on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="order-received-on" type="date" class="form-control form-input" name="orderReceivedOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $order_received_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('order-received-on').defaultValue = '<?php echo $order_received_on; ?>'
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Order forwarded to bank on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="order-forwarded-on" type="date" class="form-control form-input" name="orderForwardedOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $order_forwarded_to_bank_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('order-forwarded-on').defaultValue = '<?php echo $order_forwarded_to_bank_on; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Lease on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="lease-on" type="date" class="form-control form-input" name="leaseOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $lease_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('lease-on').defaultValue = '<?php echo $lease_on; ?>'
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Physical Possession on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="physical-possession-on" type="date" class="form-control form-input" name="physicalPossessionOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $physical_possession_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('physical-possession-on').defaultValue = '<?php echo $physical_possession_on; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Notice of physical possession on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="notice-of-physical-possession-on" type="date" class="form-control form-input" name="noticeOfPhysicalPossessionOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $notice_of_physical_possession_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('notice-of-physical-possession-on').defaultValue = '<?php echo $notice_of_physical_possession_on; ?>'
                                </script>
                            </div>
                        </div>
                        <div class="form-group postpone-part">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Possession taken on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="possession-taken-on" type="date" class="form-control form-input" name="possessionTakenOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $possession_taken_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('possession-taken-on').defaultValue = '<?php echo $possession_taken_on; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Possession postpone on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input id="possession-postpone-on" type="date" class="form-control form-input" name="possessionPostponeOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $possession_postpone_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('possession-postpone-on').defaultValue = '<?php echo $possession_postpone_on; ?>'
                                </script>
                            </div>
                        </div>
                        <div class="form-group postpone-part">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Postpone reason</label>
                                    <div class="input-group">
                                    <textarea class="form-control form-input" name="postponeReason" id="bank-address" cols="30" rows="10"><?php echo $postpone_reason; ?></textarea>
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $postpone_reason_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Property on Auction</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="property-on-auction" name="propertyOnAuction">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $property_on_auction_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('property-on-auction').defaultValue = '<?php echo $property_on_auction; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Reserve Price</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step=".01" class="form-control form-input" name="reservePrice" placeholder="Amount" value="<?php echo $reserve_price; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $reserve_price_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">EMD Amount</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-rupee-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step=".01" class="form-control form-input" name="emdAmount" placeholder="Amount" value="<?php echo $emd_amount; ?>">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $emd_amount_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Property visit by prospective buyers on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="prospective-buyer-on" name="prospectiveBuyerOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $property_visit_by_prospective_buyers_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('prospective-buyer-on').defaultValue = '<?php echo $property_visit_by_prospective_buyers_on_error; ?>'
                                </script>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Auction Date</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="auction-date" name="auctionDate">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $auction_date_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('auction-date').defaultValue = '<?php echo $auction_date; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label class="exampleInputCity1">Auction Status</label>
                                    <div class="radio-inputs">
                                        <label>
                                            <input type="radio" name="auctionStatus" value="1" <?php if($auction_status == '1') echo 'checked'; ?>>
                                            <span>
                                                <i class="fa fa-check radio-check-icon"></i>
                                                Success
                                            </span>
                                        </label>
                                        <label>
                                        <input type="radio" name="auctionStatus" value="0" <?php if($auction_status == '0') echo 'checked'; ?>>
                                            <span>
                                                <i class="fa fa-close radio-cross-icon"></i>
                                                Fail
                                            </span>
                                        </label>
                                        <label>
                                        <input type="radio" name="auctionStatus" value="-1" <?php if($auction_status == '-1') echo 'checked'; ?>>
                                            <span>
                                                None
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $auction_status_error; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Documents for redirection of order given to advocate on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="doc-to-advocate-on" name="docRedirectionToAdvocateOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $doc_for_redirection_of_order_given_to_advocate_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('doc-to-advocate-on').defaultValue = '<?php echo $doc_for_redirection_of_order_given_to_advocate_on; ?>'
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Redirection order filled with DM/CMM on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="dm-cmm-on" name="redirectionOrderWithDmCmmOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $redirection_order_filled_with_dm_cmm_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('dm-cmm-on').defaultValue = '<?php echo $redirection_order_filled_with_dm_cmm_on; ?>'
                                </script>
                                <div class="col-md-6">
                                    <label for="exampleInputCity1">Redirection order received on</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-gradient-primary text-white br">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control form-input" id="redirection-order-received-on" name="redirectionOrderReceivedOn">
                                    </div>
                                    <div class="form-input-response">
                                        <?php echo $redirection_order_received_on_error; ?>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('redirection-order-received-on').defaultValue = '<?php echo $redirection_order_received_on; ?>'
                                </script>
                            </div>
                        </div>

                        <div class="mt-3 form-inline justify-content-end">
                            <button class="btn btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Add</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates </a> from Bootstrapdash.com</span>
            </div>
          </footer>
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
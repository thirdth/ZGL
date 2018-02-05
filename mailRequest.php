<?php
/* Template Name: mailRequest */
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$busName = $_POST['busName'];
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$comments = filter_var($_POST['comments'], FILTER_UNSAFE_RAW, 'FILTER_FLAG_HIGH');
$to = 'zack@zackglaserlegal.com';
$subject = 'Zack Glaser Legal Request';
$from = $email;
$message = "Name: " . $fName . " " . $lName . "\r\n Business: " . $busName . "\r\n Street: " . $street . "\r\n City, ST, Zip: " . $city . ", " . $state . ", " . $zip . "\r\n Comments: " . $comments;

if (mail ($to , $subject , $message, $from, '-fzack@zackglaserlegal.com')) {
          echo "<div class='col-md-12 text-center'>
                  <h3>Thank you for your interest. Your request was sent successfully. Our office will contact you shortly to set-up a consultation.</h3>
                   </div>";
        } else {
          echo "<div class='col-md-12 text-center'>Something went wrong. Please send your request again. If you continue to have trouble, please contact our office directly.</div>";
        };

 ?>

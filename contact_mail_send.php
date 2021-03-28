<?php 
    include_once('fronttop.php');
    $aryData =  array(
        'name'         =>  trim($_POST['userName']),
        'email'             =>  trim($_POST['userEmail']),
        'company'           =>  $_POST['subject'], 
        'cover'             => $_POST['content']
    );

    $flgIn = $db->insertAry("contactfile_cms",$aryData);   

    $toEmail = "rajbharathmail@gmail.com";
    $mailHeaders = "From: " . $_POST["userName"] . "<". $_POST["userEmail"] .">\r\n";

    mail("rajbharathmail@gmail.com","Enquiry Mail Hausmannquartet",$mailHeaders.':'.$_POST["content"]); 
    // if(mail($toEmail, "Enquiry Mail Inofosol tech", $_POST["content"], $mailHeaders)) {
    //     print "<p class='success'>Mail Sent.</p>";
    // } else {
    //     print "<p class='Error'>Problem in Sending Mail.</p>"; 
    // }

    print "<p class='Error'>We will get back to you shortly</p>";   
?>
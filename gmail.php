<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'phpmailer/PHPMailerAutoload.php';
require 'phpmailer/class.phpmailer.php';


$objConnect = mysqli_connect("localhost",'thaihotels','Thahr30','thaihotels_tel');
$resultArray = array();
$objQuery = mysqli_query($objConnect,"Select * From email Where group1 = '".$_GET['smGroup']."' Order By email");
$cnt=0;
while($row = mysqli_fetch_array($objQuery)){
    //$tmp = array();
    $cnt++;
    $resultArray[$cnt] = $row["email"];
    //$tmp["prov_name"] = $row["prov_name"];
    //array_push($resultArray,$tmp);
}

mysqli_close($objConnect);


//$_GET['prov_id']

//require_once ("phpmailer/class.phpmailer.php");
//Create a new PHPMailer instance


//Tell PHPMailer to use SMTP


//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages


//Ask for HTML-friendly debug output

//Set the hostname of the mail server

// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission

//$mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls

//$mail->SMTPSecure = 'ssl';

//Whether to use SMTP authentication


//Username to use for SMTP authentication - use full email address for gmail
//$mail->Username = "ekapop@nakoyagarden.com";info@thaihotels.org.in



//Password to use for SMTP authentication
//$mail->Password = "eploentham";



//Set who the message is to be sent from

//Set the subject line

//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');



//Replace the plain text body with one created manually


//Attach an image file domains/thaihotels.org/public_html/send_email/assets/img/email/email_1


session_start();
//Set who the message is to be sent to
$add = array();
$row=0;
$div1 = sizeof($resultArray)/10;
$div = round($div1, 0, PHP_ROUND_HALF_DOWN);
$mod = sizeof($resultArray)%10;
$aaa="";
//for($i=0;i<$resultArray;$i++){
//    $mail->clearAddresses();
//    $mail->addAddress($resultArray[$row]);
//    if (!$mail->send()) {
        
//    }else {
//        echo "Message sent! ". "<br>";
//    }
//}
$ok="";
for($j=0;$j<$div;$j++){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->CharSet = "UTF-8";
    $mail->Host = 'smtp-relay.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    
    $mail->Username = $_GET['smUser'];
    if($_GET['smUser']=="info@thaihotels.org.in"){
        $mail->Password = "Thahr30*";
    }else{
        $mail->Password = "thamarketingtha";
    }
    $mail->setFrom('info@thaihotels.org.in', 'Info Thaihotels(news)');
    $subject = $_GET['smSubject'];
    $mail->Subject = $_GET['smSubject'];
    $mail->msgHTML(file_get_contents($_GET['smFileName'].'.html'), dirname(__FILE__));
    $mail->AltBody = $_GET['smAltBody'];
    if(!$_GET['smAttachFile1']==NULL){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/send_email/assets/img/email/'.$_GET['smFileName'].'/'.$_GET['smAttachFile1'])){
            $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/send_email/assets/img/email/'.$_GET['smFileName'].'/'.$_GET['smAttachFile1']);
        }
    }
    if(!$_GET['smAttachFile2']==NULL){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/send_email/assets/img/email/'.$_GET['smFileName'].'/'.$_GET['smAttachFile2'])){
            $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/send_email/assets/img/email/'.$_GET['smFileName'].'/'.$_GET['smAttachFile2']);
        }
    }
    if(!$_GET['smAttachFile3']==NULL){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/send_email/assets/img/email/'.$_GET['smFileName'].'/'.$_GET['smAttachFile3'])){
            $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/send_email/assets/img/email/'.$_GET['smFileName'].'/'.$_GET['smAttachFile3']);
        }
    }
    
    $ok="";
    if($j!=($div-1)){
        $cnt=10;
    }else{
        $cnt=$mod;
    }
    //$mail->clearAddresses();
    $aaa="";
    for ($i = 0; $i < $cnt; $i++) {
        $row++;
        if(($resultArray[$row]!="-") && ($resultArray[$row]!="")) {
            $mail->addAddress($resultArray[$row]);
            $ok="ok";
            $add[$row]=$resultArray[$row];
            $aaa = $aaa.$resultArray[$row].'<br>';
        }
    }
    flush();
    $_SESSION["process"] = $i;
    echo "<script type='text/javascript'>$('#divView').append(".$i.");</script>";
    if($ok=="")        continue;
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo."<br>";
        echo "Password " .$mail->Password." [j = ".$j."] [i = ".$i."] [div = ".$div."] [cnt = ".$cnt."] [mod = ".$mod."] [resultArray = ".sizeof($resultArray)."] [row = ".$row."] aaa ".$aaa."<br>";
    } else {
        echo "Message sent! ". "<br>";
    }
    sleep(1);
}
$bbb = $mail->getAllRecipientAddresses();
$ccc="";
//for($k=0;$k<sizeof($bbb);$k++){
//    $ccc = $bbb[$k]."#";
//}
//echo "<br>LOG ". $ccc ." size ".sizeof($bbb)."<br>".$aaa."<br> size db ". sizeof($resultArray[$row]);
//$mail->addAddress("eploentham@gmail.com');
//$mail->addAddress('info@thaihotels.org', 'Ekapop Ploentham');



//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('email_template_1.html'), dirname(__FILE__));

//                      /home/thaihotels/domains/thaihotels.org/public_html/send_email/assests/img/email/email_1/Seller-Indian_Wedding_Symposium2017.doc
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/block_img/picture_one.jpg');
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/block_img/picture_two.jpg');
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/headliner/headliner_blue.jpg');
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/block_img/middle_picture.jpg');
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/block_img/right_picture.jpg');
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/block_img/left_picture.jpg');
//$mail->addAttachment('http://nakoyasoft.com/tavon_web_site/assets/img/logo/logo_blue.png');



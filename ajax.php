<?php
include_once('fronttop.php');
$action = $_REQUEST['action'];
$validate = new Validation();
$stat = array();



switch($_REQUEST['action'])
{
 

	
	  case "send_message_email":
    {
    	 $sendUserData = $db->getRow("select email,firstname,lastname from users where id='".trim($_POST['touserid'])."'");
    	 $currentUserData = $db->getRow("select firstname,lastname from users where id='".$_SESSION[LOGIN_USER]['userid']."'"); 
    	 //$sederId = base64_encode($_SESSION[LOGIN_USER]['userid']);
    	 
    	
    	 
		$vars = ['user'=> trim($sendUserData['firstname'])." ".trim($sendUserData['lastname']),
				'sender'=>trim($currentUserData['firstname'])." ".trim($currentUserData['lastname']),
				'custid'=>base64_encode($_SESSION[LOGIN_USER]['userid']),   
				
		];   
		if(!empty($sendUserData['email'])){
			mail_template($sendUserData['email'],'user_messege_email',$vars); 
		}
		break;
	}
	
    case 'submit_signup':
    {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";
//        exit;
        $validate->addRule(trim($_POST['firstname']),'',$dashboard['fname_val'],true);
        $validate->addRule(trim($_POST['lastname']),'',$dashboard['lname_val'],true);
        $validate->addRule(trim($_POST['phone']),'',$dashboard['phone_num_val'],true);
        $validate->addRule(trim($_POST['password']),'',$dashboard['password'],true); 

        if($validate->validate() && count($stat)==0)
        {
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
            {
                //your site secret key
                $secret = '6LcmG4YUAAAAAJVw7rR70AO8aDfnL18Ld8nv9pr9';
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);

                if (strlen(trim($_POST['password']))>16 || strlen(trim($_POST['password']))<6)
                {
                    $stat["danger"] = CHANGEPASSWORD_LENGTH_BETWEEN;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Be Between 6 to 16 Characters.</div>';
                }
                else if( !preg_match("#[0-9]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_NUMBER;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Number.</div>';
                }
                else if( !preg_match("#[a-z]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_LOWERCASE;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Letter.</div>';
                }
                else if( !preg_match("#[A-Z]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_UPPERCASE;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Letter In Uppercase.</div>';
                }
                else if( !preg_match("#\W+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_SYMBOL;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Symbol.</div>';
                }
                /*if(is_numeric(trim($_POST['email_phone'])))
                {
                    $checkforplus=(string)$_POST['email_phone'];
                    if (preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $checkforplus))
                    {
                        $tousernumber=trim($_POST['email_phone']);
                    }
                    else
                    {
                        $tousernumber=trim("+".$_POST['email_phone']);
                    }
                    $phone=trim($_POST['email_phone']);
                    $email='';
                    $chkuser = $db->getVal("select count(id) from users where phone='".trim($_POST['email_phone'])."'");
                }
                else
                {
                    if (filter_var(trim($_POST['email_phone']), FILTER_VALIDATE_EMAIL))
                    {
                        $phone='';
                        $email=trim($_POST['email_phone']);
                        $chkuser = $db->getVal("select count(id) from users where email='".trim($_POST['email_phone'])."'");
                    }
                    else
                    {
                        $stat["danger"]='Please enter valide email address.';
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please enter valide email address.</div>';
                    }
                    $tousernumber='';

                }*/
                if(count($stat)==0)
                {
                    $chkuser = $db->getVal("select count(id) from users where phone='".trim($_POST['phone'])."'");
                    if(trim($_POST['email'])!='')
                    {
                        $chkemail = $db->getVal("select count(id) from users where email='".trim($_POST['email'])."'");
                    }
                    else
                    {
                        $chkemail=0;
                    }
                    if($chkuser == 0)
                    {
                        if($chkemail==0)
                        {
                            $phone = preg_replace('/(?<=\d)\s+(?=\d)/', '', trim($_POST['phone']));
                            $countrycode=explode(" ",trim($_POST['phonecodecountry']));
                            $aryData =  array(
                                                'firstname'         =>  trim($_POST['firstname']),
                                                'lastname'          =>  trim($_POST['lastname']),
                                                'email'             =>  trim($_POST['email']),
                                                'phonecodecountry'  =>  trim($countrycode[1]),
                                                'phonecode'         =>  trim($_POST['phonecode']),
                                                'phone'             =>  $phone,
                                                'password'          =>  trim($_POST['password']),
                                                'registration_date' =>  date("Y-m-d H:i:s"),
                                                'activation_status' =>  1,
                                                'status'            =>  1,
                                            );
                            $flgIn = $db->insertAry("users",$aryData);
                            /*$tousernumber=trim($_POST['phonecode']).trim($_POST['phone']);
                            if($tousernumber!='')
                            {
                                require_once 'sendsms.php';
                                $varotp=mt_rand(100000, 999999);
                                $smsstatus=otpsendsms($tousernumber,$varotp);
                                if($smsstatus==2)
                                {
                                   echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please add country code before phone Number.</div>';
                                }
                                else if($smsstatus==3)
                                {
                                   echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something went Wrong.</div>';
                                }
                                else
                                {
                                    $flgIn = $db->insertAry("users",$aryData);
                                    $aryotpData =  array(
                                                        'phoneopt'          =>  $varotp,
                                                        'phoneotpstatus'    =>  0,
                                                        'otpdatetime'       =>  date('Y-m-d H:i:s')
                                                    );
                                    $flg = $db->updateAry("users", $aryotpData, "where id='".$flgIn."'");
                                }
                            }*/
                            if(!is_null($flgIn))
                            {
                                $_SESSION[LOGIN_USER]['userid'] = $flgIn;
                                $_SESSION[LOGIN_USER]['email']  = trim($_POST['email']);
                                if($email!='')
                                {
                                    $vars = [
                                        'user'          => trim($_POST['firstname'])." ".trim($_POST['lastname']),
                                        'email_id'      => $email,
                                        'passwords'     => trim($_POST['password']),
                                    ];
                                    mail_template($email,'user_registration',$vars);
                                }
                                echo 1;
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['email_exist'].'</div>';
                        }
                    }
                    else
                    {
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['phone_exist'].'</div>';
                    }
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['please_recap'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
    
    
    //home page sign
     case 'submit_signup_home':
    {
    	
        $validate->addRule(trim($_POST['firstname']),'',$dashboard['fname_val'],true);
        $validate->addRule(trim($_POST['lastname']),'',$dashboard['lname_val'],true);
        $validate->addRule(trim($_POST['phone']),'',$dashboard['phone_num_val'],true);
        $validate->addRule(trim($_POST['password']),'',$dashboard['password'],true); 

        if($validate->validate() && count($stat)==0)
        {
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
            {
                //your site secret key
                $secret = '6LcmG4YUAAAAAJVw7rR70AO8aDfnL18Ld8nv9pr9';
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);

                if (strlen(trim($_POST['password']))>16 || strlen(trim($_POST['password']))<6)
                {
                    $stat["danger"] = CHANGEPASSWORD_LENGTH_BETWEEN;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Be Between 6 to 16 Characters.</div>';
                }
                else if( !preg_match("#[0-9]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_NUMBER;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Number.</div>';
                }
                else if( !preg_match("#[a-z]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_LOWERCASE;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Letter.</div>';
                }
                else if( !preg_match("#[A-Z]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_UPPERCASE;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Letter In Uppercase.</div>';
                }
                else if( !preg_match("#\W+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_SYMBOL;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Symbol.</div>';
                }
                
                if(count($stat)==0)
                {
                    $chkuser = $db->getVal("select count(id) from users where phone='".trim($_POST['phone'])."'");
                    if(trim($_POST['email'])!='')
                    {
                        $chkemail = $db->getVal("select count(id) from users where email='".trim($_POST['email'])."'");
                    }
                    else
                    {
                        $chkemail=0;
                    }
                    if($chkuser == 0)
                    {
                        if($chkemail==0)
                        {
                            $phone = preg_replace('/(?<=\d)\s+(?=\d)/', '', trim($_POST['phone']));
                            $countrycode=explode(" ",trim($_POST['phonecodecountry']));
                            $aryData =  array(
                                                'firstname'         =>  trim($_POST['firstname']),
                                                'lastname'          =>  trim($_POST['lastname']),
                                                'email'             =>  trim($_POST['email']),
                                                'phonecodecountry'  =>  trim($countrycode[1]),
                                                'phonecode'         =>  trim($_POST['phonecode']),
                                                'phone'             =>  $phone,
                                                'password'          =>  trim($_POST['password']),
                                                'registration_date' =>  date("Y-m-d H:i:s"),
                                                'activation_status' =>  1,
                                                'status'            =>  1,
                                            );
                            $flgIn = $db->insertAry("users",$aryData);
                            if(!is_null($flgIn))
                            {
                                $_SESSION[LOGIN_USER]['userid'] = $flgIn;
                                $_SESSION[LOGIN_USER]['email']  = trim($_POST['email']);
                                if($email!='')
                                {
                                    $vars = [
                                        'user'          => trim($_POST['firstname'])." ".trim($_POST['lastname']),
                                        'email_id'      => $email,
                                        'passwords'     => trim($_POST['password']),
                                    ];
                                    mail_template($email,'user_registration',$vars);
                                }
                                echo 1;
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['email_exist'].'</div>';
                        }
                    }
                    else
                    {
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['phone_exist'].'</div>';
                    }
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['please_recap'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
    
    
    
    
      case 'submit_signup_home_general':
    {
    
        $validate->addRule(trim($_POST['firstname']),'',$dashboard['fname_val'],true);
        $validate->addRule(trim($_POST['lastname']),'',$dashboard['lname_val'],true);
        $validate->addRule(trim($_POST['phone']),'',$dashboard['phone_num_val'],true);
        $validate->addRule(trim($_POST['password']),'',$dashboard['password'],true); 

        if($validate->validate() && count($stat)==0)
        {
            /*if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
            {*/
                //your site secret key
                $secret = '6LcmG4YUAAAAAJVw7rR70AO8aDfnL18Ld8nv9pr9';
                //get verify response data
                //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                //$responseData = json_decode($verifyResponse);

                if (strlen(trim($_POST['password']))>16 || strlen(trim($_POST['password']))<5)
                {
                    $stat["danger"] = CHANGEPASSWORD_LENGTH_BETWEEN;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Be Between 6 to 16 Characters.</div>';
                }  
               /* else if( !preg_match("#[0-9]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_NUMBER;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Number.</div>';
                }
                else if( !preg_match("#[a-z]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_LOWERCASE;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Letter.</div>';
                }
                else if( !preg_match("#[A-Z]+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_UPPERCASE;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Letter In Uppercase.</div>';
                }
                else if( !preg_match("#\W+#", trim($_POST['password'])) )
                {
                    $stat["danger"] = CHANGEPASSWORD_INCLUDE_SYMBOL;
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Must Include Atleast One Symbol.</div>';
                }*/
                
                if(count($stat)==0)
                {
                    $chkuser = $db->getVal("select count(id) from users where phone='".trim($_POST['phone'])."'");
                    if(trim($_POST['email'])!='')
                    {
                        $chkemail = $db->getVal("select count(id) from users where email='".trim($_POST['email'])."'");
                    }
                    else
                    {
                        $chkemail=0;
                    }
                    if($chkuser == 0)
                    {
                        if($chkemail==0)
                        {
                            $phone = preg_replace('/(?<=\d)\s+(?=\d)/', '', trim($_POST['phone']));
                            $countrycode=explode(" ",trim($_POST['phonecodecountry']));
                           
                            $aryData =  array(
                                                'firstname'         =>  trim($_POST['firstname']),
                                                'lastname'          =>  trim($_POST['lastname']),
                                                'email'             =>  trim($_POST['email']),
                                                'phonecodecountry'  =>  trim($countrycode[1]),
                                                'phonecode'         =>  trim($_POST['phonecode']),
                                                'phone'             =>  $phone,
                                                'password'          =>  trim($_POST['password']),
                                                'registration_date' =>  date("Y-m-d H:i:s"),
                                                'date_birth' 		=>  $_POST['date_birth'], 
                                                'designation' 		=>  $_POST['designation'], 
                                                'perhour_price_currency' =>  $_POST['currency'], 
                                                'perhour_price' =>  	$_POST['amount'],  
                                                'country'               =>  $autolocationary['country'],
                                                'city'                  =>  $autolocationary['city'],
                                                'activation_status' =>  1,
                                                'status'            =>  1, 
                                                'phoneotpstatus'        =>  1, 
                                                'emailotpstatus'        =>  1,
                                            );

                                            
                                            if($_POST['work_type']=='1'){
                                            	$aryData['full_work_type']= trim($_POST['pay_type']);
											}elseif($_POST['work_type']=='2'){
												$aryData['part_work_type']= trim($_POST['pay_type']);
											}elseif($_POST['work_type']=='3'){
												$aryData['fullpart_work_type']= trim($_POST['pay_type']);
											}elseif($_POST['work_type']=='4'){
												$aryData['freelance_work_type']= trim($_POST['pay_type']);
											}
                                            
                                      
                                      
                                            
                            $flgIn = $db->insertAry("users",$aryData);  
                            
                            include ('qr/qrlib.php');   
                            $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qr/temp'.DIRECTORY_SEPARATOR;
 							if (!file_exists($PNG_TEMP_DIR))
        					mkdir($PNG_TEMP_DIR);
    						$filename = $PNG_TEMP_DIR.base64_encode($flgIn).".png";
							QRcode::png(URL_ROOT."userprofile.php?id=".base64_encode($flgIn), $filename, "L", 4, 4); 

							$aryData = array('user_id'=>$flgIn,
								  'qr_image'=>base64_encode($flgIn).".png"); 
								  
							$flgUpqr = $db->insertAry("qr_user", $aryData); 
                           
                            if(!is_null($flgIn)) 
                            {
                               
                            	/*$newpas = '';
				                require_once 'sendsms.php';
				                $phone_num = $_POST['phonecode'].''.$phone;
				                $smsstatus=welcomemsge($phone_num,$newpas); */
				                
                                $_SESSION[LOGIN_USER]['userid'] = $flgIn;
                                $_SESSION[LOGIN_USER]['email']  = trim($_POST['email']);
                                if($_POST['email']!='') 
                                {
                                    $vars = [
                                        'user'          => trim($_POST['firstname'])." ".trim($_POST['lastname']), 
                                        'email_id'      => $_POST['email'],
                                        'passwords'     => trim($_POST['password']),
                                    ];
                                    mail_template($_POST['email'],'user_registration',$vars);
                                }
                                echo 1; 
                            }
                            
                        }
                        else
                        {
                            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['email_exist'].'</div>';
                        }
                    }
                    else
                    {
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['phone_exist'].'</div>';
                    }
                }
           /* }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['please_recap'].'</div>';
            }*/
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    case 'submit_signin':
    {
        $validate->addRule(trim($_POST['email_phone']),'',$dashboard['email_or_phno'],true); 
        $validate->addRule(trim($_POST['password']),'','Passowrd',true);
        if($validate->validate() && count($stat)==0)
        {
            if($_POST['rememberme']==1)
            {
                $email=trim($_POST['email_phone']);
                $pass=trim($_POST['password']);
                setcookie('c_email',$email,time()+60*60*24*15);
                setcookie('c_password',$pass,time()+60*60*24*15);
            }
            else
            {
                if(isset($_COOKIE['c_password']) && isset($_COOKIE['c_email']))
                {
                    setcookie('c_email','');
                    setcookie('c_password','');
                }
            }

            if(is_numeric(trim($_POST['email_phone'])))
            {
                $phone=trim($_POST['email_phone']);
                $email='';
                $check_login=$db->getRow("select activation_status,status,id,email from users where phone='".$phone."' && password='".trim($_POST['password'])."'");
            }
            else
            {
                $phone='';
                $email=trim($_POST['email_phone']);
                $check_login=$db->getRow("select activation_status,status,id,email from users where email='".$email."' && password='".$_POST['password']."'");
            }
            if(is_array($check_login) && count($check_login)>0)
            {
                if($check_login['activation_status']==1)
                {
                    if($check_login['status']==1)
                    {
                        $_SESSION[LOGIN_USER]['userid'] = $check_login['id'];
                        $_SESSION[LOGIN_USER]['email'] = $check_login['email'];
                        echo 1;

                    }
                    else
                    {
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['account_dect'].'</div>';
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['activate_account'].'</div>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['invalid_email'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }

       case 'submit_forget_password':
    {
    	
       
       $validate->addRule(trim($_POST['email_forget']), '', 'Email/Phone Number', true);
       
        if($validate->validate() && count($validate->errors())==0)
        {
        	
               
        	$check_login = $db->getRow("select * from users where email='".trim($_POST['email_forget'])."'");
        	
            if(is_array($check_login) && count($check_login)>0)
            {
               
                $newpas = randomFix(8);
                
                    $aryData = array(
                                        'password' => $newpas
                                    );
                                    
                	$flg = $db->updateAry("users", $aryData, "where email='".trim($_POST['email_forget'])."'");
                     
                    
                    if (!is_null($flg))
                    {
                        if($check_login['email']!='')
                        {
                            $vars = array(
                                            'user'      => ucfirst($check_login['firstname']." ".$check_login['lastname']),
                                            'pwd'       => $newpas,
                                            'email_id'  => trim($_POST['email_forget'])
                                        );
                            mail_template(trim($check_login['email']), "forgot_password", $vars);
                        }
                        //$stat['success'] = REST_PASSWORD_SEND_TOEMAIL_ADDRESS;
                        $message['status'] = 1;
                        if(trim($check_login['phone'])!='' && $check_login['email']!='') 
                        {
                            $message['msg'] = $dashboard['new_pass_sent'];
                        }
                        echo json_encode($message);
                    }
                
            }
            else 
            {
                $message['status'] = 0;
                $message['msg'] = $dashboard['user_not_exist'];
                echo json_encode($message);
            }
        }
        else
        {
            $message['status'] = 0;
            $message['msg'] = $validate->errors();
            echo json_encode($message);
        }
        break;
    }
    
    
    case 'profile_tab_company':
    {
		$aryData = array(
                        'is_company'  =>  '1');
                        
		$flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
        
                    if (!is_null($flgUp))
                    {
                        echo 1;
                    }
                    break;
	}
	
	case 'profile_tab_candidate':
    {
		$aryData = array(
                        'is_company'  =>  '0');
                        
		$flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
        
                    if (!is_null($flgUp))
                    {
                        echo 1;
                    }
                    break;
	}
    
    
    
    
    
     
    case 'submit_editprofile':
    {
        $validate->addRule($_POST['firstname'],'',$dashboard['fname_val'],true);
        $validate->addRule($_POST['lastname'],'',$dashboard['lname_val'],true);
        $validate->addRule($_POST['phone'],'',$dashboard['cont_det'],true); 

        if($validate->validate() && count($stat)==0)
        {
            $phone = preg_replace('/(?<=\d)\s+(?=\d)/', '', trim($_POST['phone']));
            $chkphone=$db->getVal("select id from users where phone='".trim($phone)."' && id!='".$_SESSION[LOGIN_USER]['userid']."'");

            if($chkphone=='')
            {
                if(trim($_POST['email'])!='')
                {
                    $chkemail=$db->getVal("select id from users where email='".trim($_POST['email'])."' && id!='".$_SESSION[LOGIN_USER]['userid']."'");
                }
                else
                {
                   $chkemail='';
                }
                if($chkemail=='')
                {
                    if($userdetails['phone']==trim($phone) && $userdetails['phoneotpstatus']==1)
                    {
                        $otpstatus=1;
                    }
                    else
                    {
                        $otpstatus=0;
                    }
                    $countrycode=explode(" ",trim($_POST['phonecodecountry']));
                    /*$chknewphone=$db->getVal("select id from users where phone='".trim($_POST['phone'])."' && id='".$_SESSION[LOGIN_USER]['userid']."'");
                    if($chknewphone=='')
                    {
                        $tousernumber=trim($_POST['phonecode']).trim($_POST['phone']);
                        if($tousernumber!='')
                        {
                            require_once 'sendsms.php';
                            $varotp=mt_rand(100000, 999999);
                            $smsstatus=otpsendsms($tousernumber,$varotp);

                            if($smsstatus==2)
                            {
                               echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please add country code before phone Number.</div>';
                               exit;

                            }
                            else if($smsstatus==3)
                            {
                               echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something went Wrong.</div>';
                               exit;
                            }
                            else
                            {
                                $aryotpData =  array(
                                                    'phoneopt'          =>  $varotp,
                                                    'phoneotpstatus'    =>  0,
                                                    'otpdatetime'       =>  date('Y-m-d H:i:s'),
                                                );
                                $flg = $db->updateAry("users", $aryotpData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                                $aryData = array(
                                            'firstname'                 =>  trim($_POST['firstname']),
                                            'lastname'                  =>  trim($_POST['lastname']),
                                            'phonecodecountry'          =>  trim($countrycode[1]),
                                            'phonecode'                 =>  trim($_POST['phonecode']),
                                            'phone'                     =>  trim($_POST['phone']),
                                            'address'                   =>  trim(addslashes($_POST['address'])),
                                            'lastupdate_date'           => date("Y-m-d H:i:s"),
                                        );
                                $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                            }
                        }

                    }
                    else
                    {*/

                        $aryData = array(
                                            'firstname'                 =>  trim($_POST['firstname']),
                                            'lastname'                  =>  trim($_POST['lastname']),
                                            'phonecodecountry'          =>  trim($countrycode[1]),
                                            'phonecode'                 =>  trim($_POST['phonecode']),
                                            'phone'                     =>  $phone,
                                            'email'                     =>  trim($_POST['email']),
                                            'gender'                    =>  $_POST['gender'],
                                            'show_phone'                =>  $_POST['show_phone'],
                                            'phoneotpstatus'            =>  $otpstatus,
                                            'address'                   =>  trim(addslashes($_POST['address'])),
                                            'lastupdate_date'           => date("Y-m-d H:i:s"),
                                        );
                        $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                    //}
                    if (!is_null($flgUp))
                    {
                        echo 1;
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['email_addrs_exist'].'</div>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['phone_exist'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger" id="errormsg"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
		case 'changelanguage':
		{
				$_SESSION['language']=$_POST['language']; 
				echo "1";

		}

    case 'submit_changepassword':
    {
        $validate->addRule($_POST['currentpassword'],'',$dashboard['current_pass'],true);
        $validate->addRule($_POST['newpassword'],'',$dashboard['new_pass_small'],true);
        if($validate->validate() && count($stat)==0)
        {
            $check_password=$db->getRow("select password from users where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if($check_password['password'] ==  $_POST['currentpassword'])
            {
                if (strlen (trim($_POST['newpassword']))>16 || strlen(trim($_POST['newpassword']))<6)
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pass_word_limit'].'</div>';
                }
              /*  else if( !preg_match("#[0-9]+#", trim($_POST['newpassword'])) )
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pass_word_num'].'</div>';
                }
                else if( !preg_match("#[a-z]+#", trim($_POST['newpassword'])) )
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pass_word_latter'].'</div>';
                }
                else if( !preg_match("#[A-Z]+#", trim($_POST['newpassword'])) )
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pass_word_up_low'].'</div>';
                }
                else if( !preg_match("#\W+#", trim($_POST['newpassword'])) )
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pass_word_simb'].'</div>';
                }*/
                else
                {
                    $arydata = array(
                                        'password' => $_POST['newpassword'],
                                    );
                    $flgUp = $db->updateAry('users',$arydata,'where id='.$_SESSION[LOGIN_USER]['userid']);
                    if($flgUp)
                    {
                        echo 1;
                    }
                    else
                    {
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['some_wrong'].'</div>';
                    }
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pass_curr_inval'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'submit_description':
    {
        $validate->addRule($_POST['industry'],'',$dashboard['industry_val'],true);

        if($validate->validate() && count($stat)==0)
        {
            $aryData = array(
                                'designation'              =>  trim($_POST['designation']),
                                'company_name'             =>  trim($_POST['company_name']),
                                'experience_year'          =>  trim($_POST['experience_year']),
                                'experience_month'         =>  trim($_POST['experience_month']),
                                'industry_id'              =>  trim($_POST['industry']),
                                'summary'                  =>  trim(addslashes($_POST['summary'])),
                                'education'                =>  trim($_POST['education']),
                            );
            $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if (!is_null($flgUp))
            {
                echo 1;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
    
     case 'submit_summery':
    {
       
       
            $aryData = array(
                               
                                'summary'   =>  trim(addslashes($_POST['summary']))
                                
                            );
            $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if (!is_null($flgUp))
            {
                echo 1;
            }
          
        break;
    }
    
    
     case 'submit_profile':
    {
    
        $validate->addRule(trim($_POST['firstname']),'',$dashboard['fname_val'],true);
        $validate->addRule(trim($_POST['lastname']),'',$dashboard['lname_val'],true);
        $validate->addRule(trim($_POST['phone']),'',$dashboard['phone_num_val'],true);
        

        if($validate->validate() && count($stat)==0)
        {
                if(count($stat)==0)
                {
                    $chkuser = $db->getVal("select count(id) from users where phone='".trim($_POST['phone'])."' AND id!= '".$userdetails['id']."' ");
                   
                    if(trim($_POST['email'])!='')
                    {
                        $chkemail = $db->getVal("select count(id) from users where email='".trim($_POST['email'])."' AND email!= '".$userdetails['email']."' ");
                    }
                    else
                    {
                        $chkemail=0;
                    }
                    if($chkuser == 0)
                    {
                        if($chkemail == 0)
                        {
                        	
                            $phone = preg_replace('/(?<=\d)\s+(?=\d)/', '', trim($_POST['phone']));
                            //$countrycode=explode(" ",trim($_POST['phonecodecountry']));
                           
                            $aryData =  array(
                                                'firstname'         =>  trim($_POST['firstname']),
                                                'lastname'          =>  trim($_POST['lastname']),
                                                'email'             =>  trim($_POST['email']),
                                               // 'phonecodecountry'  =>  trim($countrycode[1]),
                                                //'phonecode'         =>  trim($_POST['phonecode']),
                                                'phone'             =>  $phone,
                                               // 'date_birth' 		=>  $_POST['date_birth'], 
                                                'designation' 		=>  $_POST['designation'], 
                                                'perhour_price_currency' =>  $_POST['currency'], 
                                                'perhour_price' =>  	$_POST['amount'],  
                                                'gender'=> $_POST['gender'],     
                                                'industry_id'=> $_POST['industry'],     
                                                'show_phone'=> $_POST['show_phone'],  
                                            );
  
                                            
                                            if($_POST['work_type']=='1'){
                                            	$aryData['full_work_type']= trim($_POST['pay_type']);  
											}elseif($_POST['work_type']=='2'){
												$aryData['part_work_type']= trim($_POST['pay_type']);
											}elseif($_POST['work_type']=='3'){
												$aryData['fullpart_work_type']= trim($_POST['pay_type']);
											}elseif($_POST['work_type']=='4'){
												$aryData['freelance_work_type']= trim($_POST['pay_type']);
											} 
											 
                                  $aryDataWorkType = array(	'full_work_type' =>0,
                                                			'part_work_type' => 0,
                                                			'fullpart_work_type'=>0,
                                                			'freelance_work_type'=>0,
                                                			);
                                               // 'phonecodecountry'  =>  trim($countrycode[1]));          
                            $db->updateAry("users", $aryDataWorkType, "where id='".$_SESSION[LOGIN_USER]['userid']."'");                
                            $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                            if(!is_null($flgUp)) 
                            {
                              
                                echo 1; 
                            }
                            
                        }
                        else
                        {
                            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['email_exist'].'</div>';
                        }
                    }
                    else
                    {
                        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['phone_exist'].'</div>';
                    }
                }
          
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
     
    
    
    
    
    
        case 'submit_company_form':
    	{
    	
        $validate->addRule($_POST['industry'],'',$dashboard['industry_val'],true);

        if($validate->validate() && count($stat)==0)
        {
            $aryData = array(  
                                'pro_company_overview'         =>  trim($_POST['over_view']),
                                'pro_company_industry'         =>  trim($_POST['industry']),
                                'pro_company_size'             =>  trim($_POST['company_size']),
                                'pro_company_founded'          =>  trim($_POST['company_founded']),
                                'comp_name'          		   =>  trim($_POST['comp_name']), 
                                'pro_company_type'         	   =>  trim($_POST['company_type'])
                            );
            $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if (!is_null($flgUp)) 
            {
                echo 1;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
    
    
    case 'updateprofilepic':
    {
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '')
        {
            $filename = str_replace(" ",'_',basename($_FILES['file']['name']));
            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            if($ext != '' && !in_array($ext,array('jpg','jpeg','png','gif','bmp','mp4','avi')))
            {
                echo 2;
                break;
            }
            /*if ($_FILES["file"]["size"] >= 5000000000000)
            {
                echo 3;
                break;
                //$validate->error[] = 'File size should be less then 500KB';
            }*/
        }
        if($validate->validate() && count($stat)==0)
        {
            $filename = basename($_FILES['file']['name']);
            $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
            if(in_array($ext,array('jpeg','jpg','gif','png')))
            {
                $newfile=md5(microtime()).".".$ext;
                $destination = "uploads/users/".$newfile;
                
                if(move_uploaded_file($_FILES['file']['tmp_name'],$destination))
                {
                    $getoldimg = $db->getVal("SELECT profile_image FROM users where id=".$_SESSION[LOGIN_USER]['userid']);
                    //$oldimage = "uploads/users/".$getoldimg;
                    @unlink("uploads/users/".$getoldimg);
                    @unlink("uploads/users/resize/".$getoldimg);
                    $aryData['profile_image'] = $newfile;
                    $aryData['profile_image_verified'] = 1;
                    $flgUp = $db->updateAry('users',$aryData,'where id='.$_SESSION[LOGIN_USER]['userid']);
                    echo 1;
                }
            }
        }
        break;
    }
    
    case 'updateprofilepic_story':
    {
    	$qr = $db->getRow("select qr_image from qr_user where user_id=".$_SESSION[LOGIN_USER]['userid']);
    	$watermarkImagePath = URL_ROOT.'qr/temp/'.$qr['qr_image'];     
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '')
        {
            $filename = str_replace(" ",'_',basename($_FILES['file']['name']));
            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            if($ext != '' && !in_array($ext,array('jpg','jpeg','png','gif','bmp','mp4','mp3')))
            { 
                echo 2;
                break;
            }
            /*if ($_FILES["file"]["size"] >= 5000000000000)
            {
                echo 3;
                break;
                //$validate->error[] = 'File size should be less then 500KB';
            }*/
        }
        if($validate->validate() && count($stat)==0)
        {
            $filename = basename($_FILES['file']['name']);
            $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
            if(in_array($ext,array('jpg','jpeg','png','gif','bmp','mp4','mp3')))
            {
                $newfile=md5(microtime()).".".$ext;
                $destination = "uploads/users/story/".$newfile;
                if(move_uploaded_file($_FILES['file']['tmp_name'],$destination))
                { 
                
                
                $watermarkImg = imagecreatefrompng($watermarkImagePath); 
                switch($fileType){ 
                    case 'jpg': 
                        $im = imagecreatefromjpeg($destination); 
                        break; 
                    case 'jpeg': 
                        $im = imagecreatefromjpeg($destination); 
                        break; 
                    case 'png': 
                        $im = imagecreatefrompng($destination); 
                        break; 
                    default: 
                        $im = imagecreatefromjpeg($destination); 
                } 
                
                $marge_right = 12; 
                $marge_bottom = 12; 
                
                 $sx = imagesx($watermarkImg); 
                $sy = imagesy($watermarkImg); 
                
                imagecopy($im, $watermarkImg, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 3, 2, imagesx($watermarkImg), imagesy($watermarkImg));
                
               
                
                 imagepng($im, $destination); 
                imagedestroy($im); 
                
                    $aryData = array('media_name'=>$newfile,
                    				 'user_id'=>$_SESSION[LOGIN_USER]['userid']
                    				);
                    				
            		$flgUp = $db->insertAry('story',$aryData);
                    echo 1;
                }
            } 
        }
        break;
    }
    
    
    
    
    
    
    case 'submit_worktype':
    {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";
//        exit;

        if(trim($_POST['price_type'])==1)
        {
            $validate->addRule($_POST['fixed_price'],'',$dashboard['payment_val'],true);
        }
        else
        {
           $validate->addRule($_POST['perhour_price'],'',$dashboard['payment_val'],true); 
        }
        if($validate->validate() && count($stat)==0)
        {
            if(trim($_POST['price_type'])==1)
            {
                $aryData = array(
                                    'full_work_type'                 =>  trim($_POST['full_work_type']),
                                    'part_work_type'                 =>  trim($_POST['part_work_type']),
                                    'fullpart_work_type'             =>  trim($_POST['fullpart_work_type']),
                                    'freelance_work_type'            =>  trim($_POST['freelance_work_type']),
                                    'fixed_price'                    =>  trim($_POST['fixed_price']),
                                    'fixed_price_currency'           =>  trim($_POST['fixed_price_currency']),
                                    'perhour_price'                  =>  '',
                                    'perhour_price_currency'         =>  0,

                            );
            }
            else
            {
                $aryData = array(
                                    'full_work_type'                 =>  trim($_POST['full_work_type']),
                                    'part_work_type'                 =>  trim($_POST['part_work_type']),
                                    'fullpart_work_type'             =>  trim($_POST['fullpart_work_type']),
                                    'freelance_work_type'            =>  trim($_POST['freelance_work_type']),
                                    'perhour_price'                  =>  trim($_POST['perhour_price']),
                                    'perhour_price_currency'         =>  trim($_POST['perhour_price_currency']),
                                    'fixed_price'                    =>  '',
                                    'fixed_price_currency'           =>  0,
                                );

            }
            $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if (!is_null($flgUp))
            {
                echo 1;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'submit_saveprices':
    {
        if(trim($_POST['price_type'])==1)
        {
            $validate->addRule($_POST['fixed_price'],'',$dashboard['fix_price_cap'],true); 
        }
        else
        {
           $validate->addRule($_POST['perhour_price'],'',$dashboard['per_hour_price_cap'],true);
        }
        if($validate->validate() && count($stat)==0)
        {
            if(trim($_POST['price_type'])==1)
            {
                $aryData = array(
                                    'fixed_price'               =>  trim($_POST['fixed_price']),
                                    'fixed_price_currency'      =>  trim($_POST['fixed_price_currency']),
                                    'perhour_price'             =>  trim($_POST['perhour_price']),
                                    'perhour_price_currency'    =>  trim($_POST['perhour_price_currency']),

                            );
            }
            else
            {
                $aryData = array(
                                    'perhour_price'             =>  trim($_POST['perhour_price']),
                                    'perhour_price_currency'    =>  trim($_POST['perhour_price_currency']),
                                    'fixed_price'               =>  trim($_POST['fixed_price']),
                                    'fixed_price_currency'      =>  trim($_POST['fixed_price_currency']),
                                );

            }
            $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if (!is_null($flgUp))
            {
                echo 1;
            }

        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }

    case 'submit_expskills':
    {
        $getskillids=$db->getRows("select id from skills where status='1' order by id desc");
        $allskillsids=array_column($getskillids,'id');

        if(count($_POST['skills'])<0)
        {
           $validate->addRule($_POST['skills'],'',$dashboard['skill_val'],true);
        }
        if($validate->validate() && count($stat)==0)
        {
            $res=$db->delete('users_skills',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
            foreach($_POST['skills'] as $key=>$value)
            {
                if(in_array($value, $allskillsids))
                {
                    $skillsdata= array(
                                    'user_id'       =>  $_SESSION[LOGIN_USER]['userid'],
                                    'skill_id'      =>  $value,
                                );
                    $flgid = $db->insertAry("users_skills",$skillsdata);
                }
                else
                {
                    $skillsdata= array(
                                    'user_id'       =>  $_SESSION[LOGIN_USER]['userid'],
                                    'skill_id'      =>  0,
                                    'other_skill'   =>  $value,
                                );
                    $flgid = $db->insertAry("users_skills",$skillsdata);
                    $checkfornewskills=$db->getVal("select title from new_skills where title like '".'%'.trim(ucfirst($value)).'%'."'");
                    if(count($checkfornewskills)==0)
                    {
                        $newskillsdata= array(
                                                'title'   =>  trim(ucfirst($value)),
                                            );
                        $flgIn = $db->insertAry("new_skills",$newskillsdata);
                    }

                }
            }
            echo 1;
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'submit_experience':
    {
        $validate->addRule($_POST['exptitle'],'',$dashboard['title_val'],true);
        $validate->addRule($_POST['issuer'],'','Issuer',true);
        $validate->addRule($_POST['from_expmonth'],'',$dashboard['from_month'],true);
        $validate->addRule($_POST['from_expyear'],'',$dashboard['from_year_val'],true);
        $validate->addRule($_POST['to_expmonth'],'',$dashboard['to_month_val'],true);
        $validate->addRule($_POST['to_expyear'],'',$dashboard['to_year_val'],true); 
        if($validate->validate() && count($stat)==0)
        {

            if(trim($_POST['from_expmonth'])<=9)
            {
                $fromyearexp=date(trim($_POST['from_expyear'])."-0".trim($_POST['from_expmonth']));
            }
            else
            {
                $fromyearexp=date(trim($_POST['from_expyear'])."-".trim($_POST['from_expmonth']));
            }

            if(trim($_POST['to_expmonth'])<=9)
            {
                $toyearexp=date(trim($_POST['to_expyear'])."-0".trim($_POST['to_expmonth']));
            }
            else
            {
                $toyearexp=date(trim($_POST['to_expyear'])."-".trim($_POST['to_expmonth']));
            }
            if($toyearexp>=$fromyearexp)
            {
                $aryData = array(
                                    'user_id'           => $_SESSION[LOGIN_USER]['userid'],
                                    'title'             =>  trim($_POST['exptitle']),
                                    'issuer'            =>  trim($_POST['issuer']),
                                    'from_month'        =>  trim($_POST['from_expmonth']),
                                    'from_year'         =>  trim($_POST['from_expyear']),
                                    'to_month'          =>  trim($_POST['to_expmonth']),
                                    'to_year'           =>  trim($_POST['to_expyear']),
                                    'location'          =>  trim($_POST['explocation']),
                                    'headline'          =>  trim($_POST['expheadline']),
                                    'description'       =>  trim(addslashes($_POST['expdescription'])),
                                );
                $flgUp = $db->insertAry("users_experience", $aryData);

    //            else
    //            {
    //                $aryData = array(
    //                                    'title'             =>  trim($_POST['exptitle']),
    //                                    'issuer'            =>  trim($_POST['issuer']),
    //                                    'from_month'        =>  trim($_POST['from_expmonth']),
    //                                    'from_year'         =>  trim($_POST['from_expyear']),
    //                                    'to_month'          =>  trim($_POST['to_expmonth']),
    //                                    'to_year'           =>  trim($_POST['to_expyear']),
    //                                    'description'       =>  trim(addslashes($_POST['expdescription'])),
    //                                );
    //                $flgUp = $db->updateAry("users_experience", $aryData, "where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
    //                //echo $db->getLastquery();
    //            }
                if (!is_null($flgUp))
                {
                    echo 1;
                }
            }
            else
            {
               echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['valid_exp'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'deleteuser_experience':
    {
        $validate->addRule($_POST['userexperienceid'],'',$dashboard['experience'],true); 
        if($validate->validate() && count($stat)==0)
        {
            $delins = $db->delete('users_experience',"where id='".trim($_POST['userexperienceid'])."'");
            echo 1;
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    
    case 'delete_port':
    { 
    		$userimg = $db->getVal("SELECT media_name FROM port_media where id=".trim($_POST['id']));
        	$delins = $db->delete('port_media',"where id='".trim($_POST['id'])."'");
        	@unlink("uploads/users/".$userimg);  
            echo 1; 
       
      
        break;
    }
    
    
    
    case "submit_contactus":
    {
        $validate->addRule($_POST['fullname'],'',$dashboard['name'],true);
        $validate->addRule($_POST['email'],'',$dashboard['email'],true);
        $validate->addRule($_POST['phone'],'',$dashboard['Phone'],true);
        $validate->addRule($_POST['message'],'',$dashboard['message'],true);

        if($validate->validate() && count($stat)==0)
        {
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
            {
                //your site secret key
                $secret = '6LcmG4YUAAAAAJVw7rR70AO8aDfnL18Ld8nv9pr9';
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                $aryData = array(
                                    'fullname'          =>  trim($_POST['fullname']),
                                    'email'             =>  trim($_POST['email']),
                                    'phone'             =>  trim($_POST['phone']),
                                    'message'           =>  trim(stripslashes($_POST['message'])),
                                    "contacted_date"    => date("Y-m-d H:i:s"),
                                );

                $flgUp = $db->insertAry("user_contact", $aryData);
                if (!is_null($flgUp))
                {
                    $vars = array(
                                    'name'              =>  trim(ucfirst($_POST['fullname'])),
                                    'email'             =>  trim($_POST['email']),
                                    'mobile'            =>  trim($_POST['phone']),
                                    'message'           =>  trim(stripslashes(ucfirst($_POST['message']))),
                                );
                    $vars1 = array(
                                    'user'              =>  trim(ucfirst($_POST['fullname'])),
                                );
                    mail_template($arySetting['admin_email'],'contact_us_admin',$vars);
                    mail_template(trim($_POST['email']),'contact_us_user',$vars1);
                    echo 1;
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['click_re_captcha'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case "submit_subscribe":
    {
        $validate->addRule($_POST['sub_email'],'','Email',true);
        if($validate->validate() && count($stat)==0)
        {
            $checkemail=$db->getVal("select subscribe_id from subscribe where email='".$_POST['sub_email']."'");
            //echo "select subscribe_id from subscribe where email='".$_POST['sub_email']."'";
            //exit;
            if(count($checkemail)==0)
            {
                $aryData = array(
                                    'email'   =>  trim($_POST['sub_email']),
                                );

                $flgUp = $db->insertAry("subscribe", $aryData);
                if (!is_null($flgUp))
                {
                    echo 1;
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['already_sub'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'fetchskills':
        {
            $aryskills=$db->getRows("select id,title from skills where status='1' order by id desc");
            foreach ($aryskills as $key => $skill) {
                $aryskill = [
                    'value' => $skill['id'],
                    'text' => $skill['title'],
                ];
                echo json_encode($aryskill);
            }
            break;
        }

    case 'deletepost_action':
    {
        if (isset($_POST['postid'])) {
            $delete=$db->delete('manage_posts',"where post_id=".$_POST['postid']." and user_id='".$_SESSION[LOGIN_USER]['userid']."'");
            if ($delete != '') {
                $message['status'] = 1;
                echo json_encode($message);
            } else {
                $message['status'] = 0;
                echo json_encode($message);
            }

        } else {
            $message['status'] = 0;
            echo json_encode($message);
        }

        break;
    }

    case "submit_lookingcandidate":
    {

        $validate->addRule($_POST['candidate_title'],'',$dashboard['deseg'],true); 
        $validate->addRule($_POST['candidate_category'],'',$dashboard['cat_only'],true);
        $validate->addRule($_POST['candidate_description'],'',$dashboard['descs'],true); 
        if($_POST['pay_type']=='')
        {
            $validate->addRule($_POST['pay_amount'],'',$dashboard['fix_price_cap'],true);
        }
        else
        {
            $validate->addRule($_POST['pay_amount'],'',$dashboard['pay_hour_price'],true); 
        }

        $validate->addRule($_POST['pay_currency'],'',$dashboard['curr'],true); 
        $validate->addRule($_POST['candidate_expirydate'],'',$dashboard['job_exp_dates'],true);

        if($validate->validate() && count($validate->errors())==0)
        {
            $aryData = array(
                                'user_id'               =>  trim($_SESSION[LOGIN_USER]['userid']),
                                'post_type'             =>  trim($_POST['post_type']),
                                'title'                 =>  trim($_POST['candidate_title']),
                                'category'              =>  trim($_POST['candidate_category']),
                                'othercategory'         =>  trim($_POST['othercategory']),
                                'candidate_jobtype'     =>  trim($_POST['candidate_jobtype']),
                                'description'           =>  trim(stripslashes($_POST['candidate_description'])),
                                'pay_type'              =>  trim($_POST['pay_type']),
                                'pay_amount'            =>  trim($_POST['pay_amount']),
                                "pay_currency"          =>  trim($_POST['pay_currency']),
                                'experience'            =>  trim($_POST['candidate_experience']),
                                "country"               =>  $autolocationary['country'],
                                "city"                  =>  $autolocationary['city'],
                                "currency"              =>  trim($_POST['pay_currency']),
                                "created_at"            =>  date("Y-m-d H:i:s"),
                                "expirydate"            =>  date("Y-m-d",strtotime($_POST['candidate_expirydate'])),
                                "status"                =>  1, 
                                "lang_id"                =>  $_SESSION['language'],
                            );
            if (!empty($_FILES['candidate_file']['name']))
            {
                $filename = basename($_FILES['candidate_file']['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.')+1));
                if(in_array($ext,array('docx','doc','pdf','jpeg','jpg','gif','png')))
                {
                    $newfile=md5(microtime()).".".$ext;
                    $destination = "uploads/post_files/".$newfile;
                    if(move_uploaded_file($_FILES['candidate_file']['tmp_name'],$destination))
                    {
                        $aryData['uploaded_file'] = $newfile;
                    }
                }
                else
                {
                    $message['status'] = 0;
                    $message['msg'] = $dashboard['sorry_upload'];
                    echo json_encode($message);
                    die;
                }
            }
            $flgUp = $db->insertAry("manage_posts", $aryData);


            if (!is_null($flgUp))
            {
                if (count($_POST['candidate_skills'])>0)
                {
                    $getskillids=$db->getRows("select id from skills where status='1' order by id desc");
                    $allskillsids=array_column($getskillids,'id');

                    foreach ($_POST['candidate_skills'] as $skill)
                    {
                        if(in_array($skill, $allskillsids))
                        {
                            $skilldata = [
                                            'post_id' => $flgUp,
                                            'skill_id' => $skill,
                                        ];
                            $db->insertAry("post_skills",$skilldata);
                        }
                        else
                        {
                            $skilldata = [
                                            'post_id'       => $flgUp,
                                            'skill_id'      => $skill,
                                            'other_skill'   => trim(ucfirst(($skill))),
                                        ];
                            $db->insertAry("post_skills",$skilldata);
                            $checkfornewskills=$db->getVal("select title from new_skills where title like '".'%'.trim(ucfirst(($skill))).'%'."'");
                            if(count($checkfornewskills)==0)
                            {
                                $newskillsdata= array(
                                                        'title'   =>  trim(ucfirst(($skill))),
                                                    );
                                $flgIn = $db->insertAry("new_skills",$newskillsdata);
                            }
                        }
                    }
                }
                if(trim($_POST['post_type'])==1)
                {
                    $getmyfollowers=$db->getRows("select user_id from users_followers where follower_id='".$_SESSION[LOGIN_USER]['userid']."' && status='1'");
                    if(count($getmyfollowers)>0)
                    {
                        foreach($getmyfollowers as $getmyfollowersi)
                        {
                            send_notification(6,$_SESSION[LOGIN_USER]['userid'],$flgUp,trim($getmyfollowersi['user_id']));
                        }
                    }

                }
                $message['status'] = 1;
                $message['msg'] = $dashboard['post_added'];
                echo json_encode($message);
            }
            else
            {
                $message['status'] = $dashboard['some_wrong'];

                echo json_encode($message);

            }
        }
        else
        {
            $message['status'] = 0;
            $message['msg'] = $validate->errors();
            echo json_encode($message);
        }
        break;
    }

    case 'apply_job':
    {

        $validate->addRule($_POST['post_id'],'','',true);
        if($validate->validate())
        {
            $checkapplied=$db->getVal("select post_id from user_apply_job where post_id='".trim($_POST['post_id'])."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
            if(count($checkapplied)==0)
            {
                $aryData = array(
                                    "post_id"       => trim($_POST['post_id']),
                                    "user_id"       => $_SESSION[LOGIN_USER]['userid'],
                                    "applied_date"  => date("Y-m-d H:i:s")
                                );
                $flgIn = $db->insertAry("user_apply_job",$aryData);
                if (!is_null($flgIn))
                {
                    $otheruserid=$db->getVal("select user_id from manage_posts where post_id='".trim($_POST['post_id'])."'");
                    echo 1;
                    send_notification(7,$_SESSION[LOGIN_USER]['userid'],$flgIn,$otheruserid);
//                    $postuserid=$db->getRow("select user_id,title from manage_posts where post_id='".trim($_POST['post_id'])."'");
//                    $arydetails=$db->getRow("select firstname,lastname,email from users where id='".$postuserid['user_id']."'");
//                    $vars = array(
//                                    'appliername'       => ucfirst($userdetails['firstname']." ".$userdetails['lastname']),
//                                    'jobownername'      => ucfirst($arydetails['firstname']." ".$arydetails['lastname']),
//                                    'jobownermail'      => $arydetails['email'],
//                                    'appliedjobname'    => ucfirst($postuserid['title']),
//                                    "applieddate"       => date("d F Y H:i A")
//                                );
//                    $vars1 = array(
//                                    'ownername'         => ucfirst($arydetails['firstname']." ".$arydetails['lastname']),
//                                    'appliername'       => ucfirst($userdetails['firstname']." ".$userdetails['lastname']),
//                                    'applieremail'      => $userdetails['email'],
//                                    'appliedjobname'    => ucfirst($postuserid['title']),
//                                    "applieddate"       => date("d F Y H:i A")
//                                );
//                    //print_r($vars);
//                    mail_template($userdetails['email'],'user_applied_job',$vars);
//                    mail_template($arydetails['email'],'applied_job',$vars1);

                }
                else
                {
                   echo 2;
                }
            }
            else
            {
              echo 4;
            }
        }
        else
        {
            echo 3;
        }
        break;
    }
    case 'clear_apply_job':
    {
        $validate->addRule($_POST['apply_job_id'],'','',true);
        if($validate->validate())
        {
            $del=$db->delete("user_apply_job","where apply_job_id='".trim($_POST['apply_job_id'])."'");
            if (!is_null($del))
            {
                echo 1;
            }
            else
            {
               echo 2;
            }

        }
        else
        {
            echo 3;
        }
        break;
    }
    case 'addfavorite_job':
    {
        $validate->addRule($_POST['post_id'],'','',true);
        if($validate->validate())
        {
            $checkapplied=$db->getVal("select post_id from user_favorites_job where post_id='".trim($_POST['post_id'])."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
            if(count($checkapplied)==0)
            {
                $aryData = array(
                                    "post_id"       => trim($_POST['post_id']),
                                    "user_id"       => $_SESSION[LOGIN_USER]['userid'],
                                );
                $flgIn = $db->insertAry("user_favorite_job",$aryData);
                if (!is_null($flgIn))
                {
                    echo 1;
                }
                else
                {
                   echo 2;
                }
            }
            else
            {
              echo 4;
            }
        }
        else
        {
            echo 3;
        }
        break;
    }
    case 'removefavorite_job':
    {
        $validate->addRule($_POST['post_id'],'','',true);
        if($validate->validate())
        {
            $checkid=$db->getVal("select favorite_id from user_favorite_job where post_id='".trim($_POST['post_id'])."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
            $del=$db->delete("user_favorite_job","where favorite_id='".$checkid."'");
            if (!is_null($del))
            {
                echo 1;
            }
            else
            {
               echo 2;
            }

        }
        else
        {
            echo 3;
        }
        break;
    }
    case "sortjobs":
    {
        $locationcheck=explode("-",$_POST['locationdata']);
        $jobtypecheck=explode("-",$_POST['jobtypedata']);
        $categorycheck=explode("-",$_POST['categorydata']);
        $sortby=trim($_POST['sortby']);

        $advcatcon='';
        $advjobtypecon='';
        $advexpcon='';
        $advdatecon='';
        $advsalarycon='';

        $searchparamcon='';
        $locationcon='';
        $categorycon='';
        $lookingforcon='';

        if(trim($_POST['advcategory_param'])!='' || trim($_POST['advjobtype_param'])!='' || trim($_POST['advexp_param'])!='' || trim($_POST['advdate_param'])!='' || trim($_POST['advsalary_param'])!='' || trim($_POST['search_param'])!='' || trim($_POST['location_param'])!='' || trim($_POST['category_param'])!='' || trim($_POST['lookingfor_param'])!='' )
        {
            if(trim($_POST['advcategory_param'])!='')
            {
               $advcatcon.=" && category='".trim($_POST['advcategory_param'])."'";
            }
            if(trim($_POST['advjobtype_param'])!='')
            {
               $advjobtypecon.=" && candidate_jobtype='".trim($_POST['advjobtype_param'])."'";
            }
            if(trim($_POST['advexp_param'])!='')
            {
               $advexpcon.=" && experience like '".'%'.trim($_POST['advexp_param']).'%'."' ";
            }
            if(trim($_POST['advdate_param'])!='')
            {
               $alldates=explode("- ",trim($_POST['advdate_param']));
               $advdatecon.=" && expirydate between '".trim(date("Y-m-d",strtotime($alldates[0])))."' AND '".trim(date("Y-m-d",strtotime($alldates[1])))."'";
            }
            if(trim($_POST['advsalary_param'])!='')
            {
               $advsalarycon.=" && pay_amount ='".trim($_POST['advsalary_param'])."' ";
            }


            if(trim($_POST['search_param'])!='')
            {
                $aKeyword = explode(",", trim($_POST['search_param']));
                if(count($aKeyword)>0)
                {
                    for($i = 0; $i < count($aKeyword); $i++)
                    {
                        if(!empty($aKeyword[$i]))
                        {
                            if($i==0)
                            {
                                $searchparamcon .=" && (title LIKE '%".trim($aKeyword[$i])."%')";
                            }
                            else
                            {
                                $searchparamcon .=" || (title LIKE '%".trim($aKeyword[$i])."%')";
                            }
                        }
                    }
                }
            }

            if(trim($_POST['location_param'])!='')
            {
                if(trim($_POST['city_param'])!='' || trim($_POST['country_param'])!='')
                {
                   $locationcon.=" && city like '".'%'.trim($_POST['city_param']).'%'."' && country like '".'%'.trim($_POST['country_param']).'%'."' ";
                }
                else
                {
                  $locationcon.=" && country like '".'%'.trim($_POST['location_param']).'%'."' ";
                }
            }
            else
            {
              $locationcon.=" && country='".$autolocationary['country']."' ";
            }
            if(trim($_POST['category_param'])!='')
            {
               $categorycon.=" && category IN(".trim($_POST['category_param']).")";
            }
            if(trim($_POST['lookingfor_param'])!='')
            {
               $lookingforcon.=" && post_type='".trim($_POST['lookingfor_param'])."'";
            }
        }
        if($locationcheck[1]!='')
        {
            $alllocation=explode(",",$locationcheck[1]);
            $i=1;
            foreach($alllocation as $key=>$value)
            {

                if(count($alllocation)==$i)
                {
                    $addcomal=")";
                }
                if($i==1)
                {
                    $morecondition .=" && (city like '".'%'.trim($value).'%'."'$addcomal";
                }
                else
                {
                    $morecondition .=" || city like '".'%'.trim($value).'%'."'$addcomal";
                }
                $i++;
            }
        }
        if($jobtypecheck[1]!='')
        {
            $morecondition .=" && candidate_jobtype IN(".$jobtypecheck[1].")";
        }
        if($categorycheck[1]!='')
        {
            $morecondition .=" && category IN(".$categorycheck[1].")";
        }

        if(isset($_SESSION[LOGIN_USER]['userid']) && $_SESSION[LOGIN_USER]['userid']!='')
        {
            $logincon.= "&& user_id!='".$_SESSION[LOGIN_USER]['userid']."'";
        }
        if($sortby==1)
        {
            $selected1="selected='selected'";
            $allposts=$db->getRows("select * from manage_posts where status='1' ".$advcatcon." ".$advjobtypecon." ".$advexpcon." ".$advdatecon." ".$advsalarycon." ".$searchparamcon." ".$locationcon." ".$categorycon." ".$lookingforcon." ".$morecondition." ".$logincon." order by post_id desc");
            //echo "select * from manage_posts where status='1' ".$advcatcon." ".$advjobtypecon." ".$advexpcon." ".$advdatecon." ".$advsalarycon." ".$searchparamcon." ".$locationcon." ".$categorycon." ".$lookingforcon." ".$morecondition." ".$logincon." order by post_id desc";
        }
        else
        {
            $selected2="selected='selected'";
            $allposts=$db->getRows("select * from manage_posts where status='1' ".$advcatcon." ".$advjobtypecon." ".$advexpcon." ".$advdatecon." ".$advsalarycon." ".$searchparamcon." ".$locationcon." ".$categorycon." ".$lookingforcon." ".$morecondition." ".$logincon." order by post_id asc");
            //echo "select * from manage_posts where status='1' ".$searchparamcon." ".$locationcon." ".$categorycon." ".$lookingforcon." ".$morecondition." ".$logincon." order by post_id asc";

        }
        if(count($allposts)>0)
        {
            $data_array .='<div class="softbyresult">';
            $data_array .='<h3>'.count($allposts).' JOBS Found In '.$autolocationary['country'].'</h3>';
            $data_array .='<div class="form-group">';

            $data_array .='<select class="sortby" id="sortby" onchange="sortjobs(this.value)">';
            $data_array .='<option value="1" '.$selected1.'>'.$dashboard['sort_recent'].'</option>';
            $data_array .='<option value="2" '.$selected2.'>'.$dashboard['sort_oldest'].'</option>';
            $data_array .='</select>';
            $data_array .='</div>';
            $data_array .='</div>';

            foreach ($allposts as $key => $post)
            {
                $postusername=$db->getRow("select firstname,lastname,phoneotpstatus,company_name from users where id='".$post['user_id']."'");

                $postcurrency=$db->getVal("select code from currency where currency_id='".$post['pay_currency']."'");
                $data_array .='<div class="boxcontent my-postsRow m-0">';

                $data_array .='<div class="postinnerconfillter">';
                $data_array .='<div class="mypostCol-Lt">';
                if($post['post_type']==1)
                {
                    $data_array .='<div class="job-title"><a href="'.href("jobdetail.php","id=". base64_encode($post['post_id'])).'">'.$post['title'].'</a></div>';
                    $data_array .='<p>'.ucfirst(stripslashes(substr($post['description'],0,60)));
                    if(strlen($post['description'])>60)
                    {
                        $data_array .='....';

                    }
                    $data_array .='</p>';
                }
                else
                {
                    $data_array .='<div class="job-title"><a href="'.href("userprofile.php","id=".base64_encode($post['user_id'])).'">'.ucfirst($postusername['firstname']." ".$postusername['lastname']).'</a></div>';
                    $data_array .='<p><span class="cand-designation">'.ucfirst($post['title']).'</span> - '.ucfirst(stripslashes(substr($post['description'],0,50)));
                    if(strlen($post['description'])>50)
                    {
                        $data_array .='....';

                    }
                    $data_array .='</p>';
                }

                if ($post['pay_type'] == 0)
                {
                    $paytype = "Fixed";
                }
                else
                {
                    $paytype = $arygetpaid[$post['pay_type']];
                }
                if(!isset($_SESSION[LOGIN_USER]['userid']) && $_SESSION[LOGIN_USER]['userid'] == '')
                {
                  $data_array .='<div class="rffbtn" data-toggle="modal" data-target="#signin" ><i class="far fa-star" aria-hidden="true"></i> '.$dashboard['add_fav'].'</div>';
                }
                else
                {
                    $checkfavorite=$db->getVal("select favorite_id from user_favorite_job where post_id='".$post['post_id']."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
                    if(count($checkfavorite)==0)
                    {
                        $data_array .='<div class="rffbtn" id="favoritespostid'.$post['post_id'].'" onclick="addfavorite_job('.$post['post_id'].')"><i class="far fa-star" aria-hidden="true"></i> '.$dashboard['add_fav'].' </div>';
                        $data_array .=' <span id="favoritespostspan'.$post['post_id'].'"></span> ';
                    }
                    else
                    {
                        $data_array .='<div class="rffbtn" id="favoritespostid'.$post['post_id'].'" onclick="removefavorite_job('.$post['post_id'].')"><i class="fa fa-star"></i> '.$dashboard['remove_fav'].'</div>';
                        $data_array .=' <span id="favoritespostspan'.$post['post_id'].'"></span> ';
                    }
                }
                $data_array .='<ul>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-1.png"></div><div class="list-data"><span>'.$paytype.'</span><br>'.$post['pay_amount'].' '.$postcurrency.'</div></li>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-2.png"> </div><div class="list-data"><span>'.$dashboard['job_type'].'</span><br>';
                if($aryjobtype[$post['candidate_jobtype']]!='')
                {
                    $data_array .=$aryjobtype[$post['candidate_jobtype']];
                }
                else
                {
                    $data_array .="N/A";

                }
                $data_array .='</div></li>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-3.png"> </div><div class="list-data"><span>'.$dashboard['company_only'].'</span><br>';
                if($postusername['company_name']!='')
                {
                  $data_array .=$postusername['company_name'];
                }
                else
                {
                    $data_array .='N/A';
                }
                $data_array .='</div></li>';
                /*$data_array .='<li><div class="list-icon"><img src="'. URL_ROOT.'img/mp-icon-4.png"> </div><div class="list-data"><span>EXPERIENCE</span><br>';
                if($post['experience']!='')
                {
                  $data_array .=$post['experience'];
                }
                else
                {
                    $data_array .='N/A';
                }
                $data_array .='</div></li>';*/
                $data_array .='</ul>';

                $data_array .='<ul class="postedlist">';
                $data_array .='<li><span>'.$dashboard['location'].':</span>'.$post['city'].', '.$post['country'].'</li>';
                $data_array .='<li><span>'.$dashboard['posted_on'].'</span> '.date('d M Y', strtotime($post['created_at'])).'</li>';
                $data_array .='<li><span>'.$dashboard['exp_date'].'</span> ';
                if($post['expirydate']!='0000-00-00')
                {
                    $data_array .=date('d M Y', strtotime($post['created_at']));
                }
                else
                {
                    $data_array .='N/A';
                }
                $data_array .='</li>';
                if($post['post_type']==1)
                {
                    $data_array .='<li><span>'.$dashboard['ps_by'].'</span>';
                    if($postusername['firstname']!='')
                    {
                        $data_array .='<a href="'.href("userprofile.php","id=".base64_encode($post['user_id'])).'">'.ucfirst($postusername['firstname']." ".$postusername['lastname']).'</a>';
                    }
                    else
                    {
                        $data_array .='N/A';
                    }
                    $data_array .='</li>';
                }
                $data_array .='</ul>';
                $data_array .='</div>';

                $data_array .='<div class="mypostCol-Rt">';
                $data_array .='<div class="list-info">';

               /* if($postusername['phoneotpstatus']==1)
                {
                	$data_array .='<h5>'.$dashboard['ph_ver'].'</h5>';
                }*/
                $data_array .='<div class="ratings" id="posts'.$post['post_id'].'">';
                $starNumber=avgrating($post['user_id']);
                for($x=1;$x<=$starNumber;$x++)
                {
                    $data_array .='<i class="fa fa-star" aria-hidden="true" ></i> ';
                }
                if (strpos($starNumber,'.'))
                {
                    $data_array .='<i class="fa fa-star-half-o" aria-hidden="true"></i> ';
                    $x++;
                }
                while ($x<=5)
                {
                    $data_array .='<i class="fas fa-star"></i> ';
                    $x++;
                }
                $data_array .='</div>';
                $data_array .='<div class="clearfix"></div>';

                if($post['post_type']==1)
                {
                    $checkapplied=$db->getVal("select post_id from user_apply_job where post_id='".$post['post_id']."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
                    if(count($checkapplied)>0)
                    {
                        $data_array .='<a href="javascript:void(0);" class="appliedbtn">Applied <i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                    else
                    {
                        $data_array .='<a href="javascript:void(0);" id="applyjobbtn'.$post['post_id'].'" onclick="apply_job('.$post['post_id'].')" class="applyBtn">'.$dashboard['apply'].'</a>';
                        $data_array .='<span id="applyjobspan'.$post['post_id'].'" ></span>';
                        $data_array .='<span id="whileapplingjob'.$post['post_id'].'"></span>';
                    }
                }
                else
                {
                    $data_array .='<a href="'.href("jobdetail.php","id=". base64_encode($post['post_id'])).'" class="applyBtn">'.$dashboard['view_detail'].'</a>';
                }
                $data_array .='</div>';
                $data_array .='</div>';
                $data_array .='</div>';
                $data_array .='</div>';
            }
            //$data_array .='<div class="tabinputrow m-50">';
            //$data_array .='<a href="#" class="myaddBtn w-20">Load More</a>';
            //$data_array .='</div>';
        }
        else
        {
            $data_array .='<div class="my-postsRow">';
                $data_array .='<center class="noresult"><img class="img-load" src="'.URL_ROOT.'img/noresult.png">';
                $data_array .='<p class="m-4">'.$dashboard['no_result_found'].'</p>';
                $data_array .='</center>';
            $data_array .='</div>';
        }
        $data = array(
                        'data'      => $data_array,
                    );
        echo json_encode($data);
        break;
    }
    case 'setlocationformaction':
    {
        $country = $_POST['country'];
        $city = ($_POST['city'] != '') ? $_POST['city'] : "N/A";
        $currencydata = $db->getRow('select * from currency where name="'.trim($country).'"');
        $currency_code = $currencydata['code'];
        $currency_sym = $currencydata['currency_symbol'];

        $_SESSION['country_data'] = [
                                        'country'       => $country,
                                        'city'          => $city,
                                        'currency'      => $currency_code,
                                        'currency_id'   => $currencydata['currency_id'],
                                        'currency_sym'  => $currency_sym,
                                    ];

        if ($_SESSION['country_data'] != '')
        {
            echo 1;
        }
        else
        {
            echo 2;
        }
        break;
    }
    case "delete_attachment":
    {
        $img = $db->getVal("select uploaded_file from manage_posts where post_id='".$_REQUEST['postid']."'");
        @unlink("uploads/post_files/$img");
        $aryData=array(
                        'uploaded_file' =>'',
            );
        $flgUp = $db->updateAry("manage_posts", $aryData,"where post_id='".$_REQUEST['postid']."'");
        echo 1;
        break;
    }
    case 'submit_verifyphone':
    {
        $validate->addRule($_POST['verifyotp'],'','OTP',true);
        if($validate->validate() && count($stat)==0)
        {
            $checkveriotp=$db->getVal("select id from users where id='".$_SESSION[LOGIN_USER]['userid']."' && phoneopt='".trim($_POST['verifyotp'])."' && phoneotpstatus ='1' ");
            if($checkveriotp=='')
            {
                $checkotp=$db->getVal("select id from users where id='".$_SESSION[LOGIN_USER]['userid']."' && phoneopt='".trim($_POST['verifyotp'])."' && phoneotpstatus ='0' ");
                if(count($checkotp)>0)
                {
                    $aryData = array(
                                        'phoneotpstatus '   =>  1,
                                        'otpdatetime'       =>  date('Y-m-d H:i:s')
                                    );
                    $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                    if (!is_null($flgUp))
                    {
                        echo 1;
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['val_otp'].'</div>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['ph_al_vrd'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pl_otp'].'</div>';
            }
        }
        break;
    }
    case 'submit_verifyemail':
    {
        $validate->addRule($_POST['verifyotpemail'],'','OTP',true);
        if($validate->validate() && count($stat)==0)
        {
            $checkveriotp=$db->getVal("select id from users where id='".$_SESSION[LOGIN_USER]['userid']."' && emailotp='".trim($_POST['verifyotpemail'])."' && emailotpstatus ='1' ");

            if($checkveriotp=='')
            {
                $checkotp=$db->getVal("select id from users where id='".$_SESSION[LOGIN_USER]['userid']."' && emailotp='".trim($_POST['verifyotpemail'])."' && emailotpstatus ='0' ");
                if(count($checkotp)>0)
                {
                    $aryData = array(
                                        'emailotpstatus '   =>  1,
                                        'emailotpdatetime'  =>  date('Y-m-d H:i:s')
                                    );
                    $flgUp = $db->updateAry("users", $aryData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                    if (!is_null($flgUp))
                    {
                        echo 1;
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['val_otp'].'</div>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['email_var_alrdy'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['pl_otp'].'</div>';
            }
        }
        break;
    }
    case 'resend_otp':
    {
        if($userdetails['phonecode']!='' && $userdetails['phone']!='')
        {
            $tousernumber=trim($userdetails['phonecode']).trim($userdetails['phone']);
            if($tousernumber!='')
            {
                require_once 'sendsms.php';
                $varotp=mt_rand(100000, 999999);
                $smsstatus=otpsendsms($tousernumber,$varotp);
                if($smsstatus==2)
                {
                   echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['unable_send'].'</div>';
                   exit;

                }
                else if($smsstatus==3)
                {
                   echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['some_wrong'].'</div>';
                   exit;

                }
                else
                {
                    //$varotp='1234';
                    $aryotpData =  array(
                                            'phoneopt'          =>  $varotp,
                                            'phoneotpstatus'    =>  0,
                                            'otpdatetime'       =>  date('Y-m-d H:i:s')
                                        );
                        $flgup = $db->updateAry("users", $aryotpData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
                        if(!is_null($flgup))
                        {
                           echo 1;
                        }
                }
            }
        }
        else
        {
             echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['update_phone'].'</div>';
        }
        break;
    }
    case 'resend_otpemail':
    {

        if($userdetails['email']!='')
        {
            $varotp=mt_rand(100000, 999999);
            $aryotpData =  array(
                                    'emailotp'          =>  $varotp,
                                    'emailotpstatus'    =>  0,
                                    'emailotpdatetime'  =>  date('Y-m-d H:i:s')
                                );

            $flgup = $db->updateAry("users", $aryotpData, "where id='".$_SESSION[LOGIN_USER]['userid']."'");
            if(!is_null($flgup))
            {
                $vars = [
                            'user'          => ucfirst($userdetails['firstname']." ".$userdetails['lastname']),
                            'emailopt'      => $varotp,
                        ];
                        
                        
                        
                mail_template($userdetails['email'],'user_emailotp',$vars);
                echo 1;
            }
        }
        else
        {
             echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['update_email'].'</div>';
        }
        break;
    }
    case 'loginsend_otp':
    {
        $validate->addRule(trim($_POST['phone']),'','Phone',true);
        if($validate->validate() && count($stat)==0)
        {
            $check_phone=$db->getVal("select id from users where phone='".trim($_POST['phone'])."'");
            if(count($check_phone)>0)
            {
                $checkforplus=(string)trim($_POST['phone']);
                if (preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $checkforplus))
                {
                    $tousernumber=trim($_POST['phone']);
                }
                else
                {
                    $tousernumber=trim("+".$_POST['phone']);
                }
                if($tousernumber!='')
                {
                    require_once 'sendsms.php';
                    $varotp=mt_rand(100000, 999999);
                    $smsstatus=otpsendsms($tousernumber,$varotp);
                    if($smsstatus==2)
                    {
                       echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['unable_send'].'</div>';
                       exit;

                    }
                    else if($smsstatus==3)
                    {
                       echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['some_wrong'].'</div>';
                       exit;

                    }
                    else
                    {
                        $aryotpData =  array(
                                            'phoneopt'          =>  $varotp,
                                            'phoneotpstatus'    =>  0,
                                            'otpdatetime'       =>  date('Y-m-d H:i:s')
                                        );
                        $flgup = $db->updateAry("users", $aryotpData, "where phone='".trim($_POST['phone'])."'");
                        if(!is_null($flgup))
                        {
                           echo 1;
                        }
                    }
                }
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['phone_not_exist'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case "mypost_loadmore":
    {
        $row = trim($_POST['row']);
        $allmyposts=$db->getRows("select * from manage_posts where user_id='".$_SESSION[LOGIN_USER]['userid']."' order by post_id desc limit $row,$rowperpage");
        //echo "select * from manage_posts where user_id='".$_SESSION[LOGIN_USER]['userid']."' order by post_id desc limit $row,$rowperpage";
        if(count($allmyposts)>0)
        {
            foreach ($allmyposts as $key => $post)
            {
                $postcurrency=$db->getVal("select code from currency where currency_id='".$post['pay_currency']."'");

                $data_array .='<div class="boxcontent my-postsRow post" id="post_'.$post["post_id"].'" data-post="'.$post['post_id'].'">';
                $data_array .='<div class="mypostCol-Lt">';
                $data_array .='<div class="job-title"><a href="'.href("jobdetail.php","id=". base64_encode($post['post_id'])).'">'.$post['title'].'</a></div>';
                if ($post['pay_type'] == 0)
                {
                    $paytype = "Fixed";
                }
                else
                {
                    $paytype = $arygetpaid[$post['pay_type']];
                }
                $data_array .='<ul>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-1.png"></div><div class="list-data"><span>'.$paytype.'</span><br>'.$post['pay_amount']." ".$postcurrency.'</div></li>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-2.png"></div> <div class="list-data"><span>'.$dashboard['job_type'].'</span><br>';
                if($aryjobtype[$post['candidate_jobtype']]!='')
                {
                    $data_array .=$aryjobtype[$post['candidate_jobtype']];
                }
                else
                {
                    $data_array .="N/A";

                }
                $data_array .='</div></li>';

                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-3.png"></div> <div class="list-data"><span>'.$dashboard['company_only'].'</span><br>';
                if($userdetails['company_name']!='')
                {
                    $data_array .=$userdetails['company_name'];
                }
                else
                {
                    $data_array .="N/A";
                }
                $data_array .='</div></li>';
                /*$data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-4.png"></div> <div class="list-data"><span>EXPERIENCE</span><br>';
                if($post['experience'])
                {
                    $data_array .=$post['experience'];

                }
                else
                {
                    $data_array .="N/A";

                }
                $data_array .='</div></li>';*/
                $data_array .='</ul>';
                if($post['post_type'] ==1)
                {
                    $appliedcandidate=$db->getVal("select count(apply_job_id) from user_apply_job where post_id='".$post['post_id']."'");
                    $checkforview=$db->getVal("select count(jobpost_viewers_id) from jobpost_viewers where post_id='".$post['post_id']."'");

                    $data_array .='<ul class="postedlist view-list">';
                    $data_array .='<li><a href="'.href("jobapplicanthistory.php","post_id=".base64_encode($post['post_id'])).'"><span><img src="'.URL_ROOT.'img/mp-icon-2.png"> Job Applicants :</span> '.$appliedcandidate.'</a></li>';
                    $data_array .='<li><span><i class="fa fa-eye" aria-hidden="true"></i> Job Views :</span> '.$checkforview.'</li>';
                    $data_array .='</ul>';
                }
                $data_array .='</div>';

                $data_array .='<div class="mypostCol-Rt">';
                $data_array .='<div class="actionbtn">';

                $data_array .='<a href="javascript:void(0)" ><img class="deletepost" onclick="deletepost('.$post['post_id'].')" data-postid="'.$post['post_id'].'" src="'.URL_ROOT.'img/deleteicon.png" height="27"></a>';
                $data_array .='<a href="'.href("editjobpost.php","id=". base64_encode($post['post_id'])).'"><img src="'.URL_ROOT.'img/editicon1.png" height="27"></a>';
                $data_array .='</div>';

                $data_array .='<ul>';
                $data_array .='<li><span>'.$dashboard['loc'].'</span>'.$post['city'].', '.$post['country'].'</li>';
                $data_array .='<li><span>'.$dashboard['posted_on'].'</span>'.date('d M Y',strtotime($post['created_at'])).'</li>';
                $data_array .='<li><span>'.$dashboard['exp_date'].'</span> <span';
                if($post['status']==2)
                {
                    $data_array .='class="post-exp"';
                }
                $data_array .='>';
                if($post['status']==1 || $post['status']==3)
                {
                    if($post['expirydate']!='0000-00-00')
                    {
                        $data_array.=date('d M Y',strtotime($post['expirydate']));
                    }
                    else
                    {
                        $data_array .="N/A";
                    }
                }
                else
                {
                    $data_array .="Post Expired";

                }
                $data_array .='</ul>';
                $data_array .='</div>';
                $data_array .='</div>';
            }
        }

        $data = array(
                        'data'      => $data_array,
                    );
        echo json_encode($data);
        break;
    }
    case 'follow_user':
    {
        $validate->addRule(trim($_POST['otheruserid']),'','User',true);
        if($validate->validate() && count($stat)==0)
        {
            $var = array(
                            'user_id'         => $_SESSION[LOGIN_USER]['userid'],
                            'follower_id'    => trim($_POST['otheruserid']),
                            'status'         => 0,
                    );
            $flagin=$db->insertAry("users_followers",$var);
            if ($flagin != '')
            {
                echo 1;
                send_notification(1,$_SESSION[LOGIN_USER]['userid'],$flagin,trim($_POST['otheruserid']));
            }
            else
            {
                echo 2;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'unfollow_user':
    {
        $validate->addRule(trim($_POST['otheruserid']),'','User',true);
        if($validate->validate() && count($stat)==0)
        {
            $getdetails=$db->getRows("select users_followers_id from users_followers where (user_id='".$_SESSION[LOGIN_USER]['userid']."' && follower_id='".trim($_POST['otheruserid'])."') || (user_id='".trim($_POST['otheruserid'])."' && follower_id='".$_SESSION[LOGIN_USER]['userid']."')");
            foreach($getdetails as $getdetailsi)
            {
                $fornotificationids=$db->getRow("select notification_id from notification where triggered_id='".$getdetailsi['users_followers_id']."' && (notification_type=1 || notification_type=2 || notification_type=3)");
//                echo "select notification_id from notifications where triggered_id='".$getdetailsi['users_followers_id']."' && (notification_type=1 || notification_type=2 || notification_type=3)";
//                echo "<br/>";
                $del1=$db->delete("notification","where notification_id='".$fornotificationids['notification_id']."'");
                $del=$db->delete("users_followers","where users_followers_id='".$getdetailsi['users_followers_id']."'");

            }
            if ($del != '')
            {
                echo 1;
            }
            else
            {
                echo 2;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'acceptfollow_request':
    {
        $validate->addRule(trim($_POST['user_id']),'','User',true);
        if($validate->validate() && count($stat)==0)
        {
            $notivar = array(
                        'is_read' => 0,
                    );
            $upnoti=$db->updateAry("notification",$notivar, "where notification_id='".trim($_POST['notificationid'])."'");

            $getfollowid=$db->getVal("select triggered_id from notification where notification_id='".trim($_POST['notificationid'])."'");
            $followvar = array(
                                'status' => 1,
                            );
            $upnoti=$db->updateAry("users_followers",$followvar,"where users_followers_id='".$getfollowid."'");
            $var = array(
                            'user_id'        => $_SESSION[LOGIN_USER]['userid'],
                            'follower_id'    => trim($_POST['user_id']),
                            'status'         => 1,
                    );
            $flagin=$db->insertAry("users_followers",$var);
            if ($flagin != '')
            {
                echo 1;
                send_notification(2,$_SESSION[LOGIN_USER]['userid'],$flagin,trim($_POST['user_id']));
            }
            else
            {
                echo 2;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'rejectfollow_request':
    {
        $validate->addRule(trim($_POST['user_id']),'','User',true);
        if($validate->validate() && count($stat)==0)
        {
            $notivar = array(
                        'is_read' => 0,
                    );
            $upnoti=$db->updateAry("notification",$notivar, "where notification_id='".trim($_POST['notificationid'])."'");

            $getfollowid=$db->getVal("select triggered_id from notification where notification_id='".trim($_POST['notificationid'])."'");

            $del=$db->delete("users_followers","where users_followers_id='".$getfollowid."'");

            if ($del != '')
            {
                echo 1;
                send_notification(3,$_SESSION[LOGIN_USER]['userid'],'',trim($_POST['user_id']));
            }
            else
            {
                echo 2;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case "send_message":
    {
        $validate->addRule($_POST['messagetext'],'','Message',true);
        $validate->addRule($_POST['fromuserid'],'','From User',true);
        $validate->addRule($_POST['touserid'],'','TO User',true);
        $sendUserData = $db->getRow("select email,firstname,lastname from users where id='".trim($_POST['touserid'])."'");

        if($validate->validate() && count($stat)==0)
        {
            $aryData = array(
                                'sender_id'         =>  trim($_POST['fromuserid']),
                                'sender_message'    =>  trim(addslashes($_POST['messagetext'])),
                                'receiver_id'       =>  trim($_POST['touserid']),
                                'status'            =>  0,
                                'sendmessage_date'  => date("Y-m-d H:i:s"),
                            );

                            $vars = [
                                'user'          => trim($sendUserData['firstname'])." ".trim($sendUserData['lastname']),
                                'messege'      => trim(addslashes($_POST['messagetext'])),
                            ];


            $flgUp = $db->insertAry("messages", $aryData);
            mail_template($sendUserData['email'],'user_messege_email',$vars);
            if (!is_null($flgUp))
            {
                echo 1;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case "replyto_message":
    {
        $validate->addRule($_POST['messagetext'],'','Message',true);
        $validate->addRule($_POST['fromuserid'],'','From User',true);
        $validate->addRule($_POST['touserid'],'','TO User',true);
        if($validate->validate() && count($stat)==0)
        {
            $aryData = array(
                                'receiver_message'      =>  trim(addslashes($_POST['messagetext'])),
                                'status'                =>  1,
                                'replymessage_date'     => date("Y-m-d H:i:s"),
                            );
            $flgUp = $db->updateAry("messages", $aryData,"where message_id='".trim($_POST['messageid'])."'");
            if (!is_null($flgUp))
            {
                echo 1;
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case "deletemessage":
    {
        $validate->addRule(trim($_POST['messageid']),'','Message ID',true);
        if($validate->validate() && count($stat)==0)
        {
            $chkfordelete=$db->getRow("select * from messages where message_id='".trim($_POST['messageid'])."'");
            //echo "select * from messages where message_id='".trim($_POST['messageid'])."'";
            if($_POST['msgtype']==1)
            {
                if($chkfordelete['receiver_message']=='' && $chkfordelete['sender_message']!='')
                {
                    $del=$db->delete("messages","where message_id='".trim($_POST['messageid'])."'");
                }
                else
                {
                    $aryData = array(
                                    'sender_message'      =>  '',
                                    'status'              =>  1,
                                );
                }

            }
            else
            {
                if($chkfordelete['sender_message']=='' && $chkfordelete['receiver_message']!='')
                {
                    $del=$db->delete("messages","where message_id='".trim($_POST['messageid'])."'");
                }
                else
                {
                    $aryData = array(
                                    'receiver_message'      =>  '',
                                    'status'              =>  1,
                                );
                }
            }
            $flgUp = $db->updateAry("messages", $aryData,"where message_id='".trim($_POST['messageid'])."'");
            if (!is_null($flgUp) || !is_null($del))
            {
                echo 1;
            }
            else
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['some_wrong'].'</div>';
            }
        }
        else
        {
            if(count($stat)==0)
            {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$validate->errors().'</div>';
            }
        }
        break;
    }
    case 'shortlistusers':
    {
        $validate->addRule($_POST['applyjobid'],'','applyjobid',true);
        if($validate->validate())
        {
            $otherdetails=$db->getRow("select * from user_apply_job where apply_job_id='".trim($_POST['applyjobid'])."'");

            $aryData = array(
                                "is_shortlisted" => 1,
                            );
            $flgUp = $db->updateAry("user_apply_job", $aryData,"where apply_job_id='".trim($_POST['applyjobid'])."'");
            if (!is_null($flgUp))
            {
                send_notification(4,$_SESSION[LOGIN_USER]['userid'],$otherdetails['post_id'],$otherdetails['user_id']);
                echo 1;

            }
            else
            {
               echo 2;
            }
        }
        else
        {
            echo 3;
        }
        break;
    }
    case 'finalizeusers':
    {
        $validate->addRule($_POST['applyjobid'],'','applyjobid',true);
        if($validate->validate())
        {
            $otherdetails=$db->getRow("select * from user_apply_job where apply_job_id='".trim($_POST['applyjobid'])."'");
            $arypostData = array(
                                "status"       => 3,
                            );
            $flgupn = $db->updateAry("manage_posts", $arypostData,"where post_id='".trim($otherdetails['post_id'])."'");
            $aryData = array(
                                "is_finalized"       => 1,
                                "finalized_date"     => date("Y-m-d H:i:s"),
                            );
            $flgUp = $db->updateAry("user_apply_job", $aryData,"where apply_job_id='".trim($_POST['applyjobid'])."'");

            if (!is_null($flgUp))
            {
                echo 1;
                send_notification(5,$_SESSION[LOGIN_USER]['userid'],$otherdetails['post_id'],$otherdetails['user_id']);
            }
            else
            {
               echo 2;
            }
        }
        else
        {
            echo 3;
        }
        break;
    }
    case "submit_reviewrating":
    {
        $chkreviewed=$db->getRow("select review_rating_id from review_rating where reviewby_id='".trim($_POST['fromuserid'])."' && reviewto_id='".trim($_POST['touserid'])."' ");
        if(count($chkreviewed)==0)
        {
            if(trim($_POST['rating'])==0)
            {
                $rating=1;
            }
            else
            {
                $rating=trim($_POST['rating']);
            }

            $aryData = array(
                                'reviewby_id'       =>  trim($_POST['fromuserid']),
                                'reviewto_id'       =>  trim($_POST['touserid']),
                                'rating'            =>  $rating,
                                'review'            =>  trim(addslashes($_POST['reviewtext'])),
                                'review_date'       => date("Y-m-d H:i:s"),
                            );
            $flgUp = $db->insertAry("review_rating", $aryData);
            if (!is_null($flgUp))
            {
                send_notification(8, trim($_POST['fromuserid']), '', trim($_POST['touserid']));
                echo 1;
            }
        }
        else
        {
            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$dashboard['look_like'].'</div>';
        }
        break;
    }
    case "myfavourites_loadmore":
    {
        $row = trim($_POST['row']);
        $favjobs = $db->getRows("select * from user_favorite_job where user_id='".$_SESSION[LOGIN_USER]['userid']."' order by favorite_id desc limit $row,$rowperpage");
        //echo "select * from user_favorite_job where user_id='".$_SESSION[LOGIN_USER]['userid']."' order by favorite_id desc limit $row,$rowperpage";
        if(count($favjobs)>0)
        {
            foreach ($favjobs as $key => $favjob)
            {
                $post=$db->getRow("select * from manage_posts where post_id='".$favjob['post_id']."'");
                $postusername=$db->getRow("select firstname,lastname,phoneotpstatus,company_name from users where id='".$post['user_id']."'");
                $postusercompany=$db->getRow("select issuer from users_experience where user_id='".$post['user_id']."'");
                $postcurrency=$db->getVal("select code from currency where currency_id='".$post['pay_currency']."'");

                $data_array .='<div class="boxcontent my-postsRow m-0 post" data-favpost="'.$favjob['post_id'].'">';
                $data_array .='<div class="postinnerconfillter">';
                $data_array .='<div class="mypostCol-Lt">';
                $data_array .='<div class="job-title"><a href="'.href("jobdetail.php","id=".base64_encode($post['post_id'])).'">'.$post['title'].'</a></div>';
                if ($post['pay_type'] == 0)
                {
                    $paytype = "Fixed";
                }
                else
                {
                    $paytype = $arygetpaid[$post['pay_type']];
                }
                $checkfavorite=$db->getVal("select favorite_id from user_favorite_job where post_id='".$post['post_id']."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
                if(count($checkfavorite)==0)
                {
                    $data_array .='<div class="rffbtn" id="favoritespostid'.$post['post_id'].'" onclick="addfavorite_job('.$post['post_id'].')"><i class="far fa-star"></i>'.$dashboard['add_fav'].'</i></div>';
                    $data_array .='<span id="favoritespostspan'.$post['post_id'].'"></span>';
                }
                else
                {
                    $data_array .='<div class="rffbtn" id="favoritespostid'.$post['post_id'].'" onclick="removefavorite_job('.$post['post_id'].')"><i class="fa fa-star"></i>'.$dashboard['remove_fav'].'</div>';
                    $data_array .='<span id="favoritespostspan'.$post['post_id'].'"></span>';
                }
                $data_array .='<ul>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-1.png"></div> <div class="list-data"><span>'.$paytype.'</span><br>'.$post['pay_amount']." ".$postcurrency.'</div></li>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/fullpart.png"></div> <div class="list-data"><span>'.$dashboard['job_type'].'</span><br>';
                if($aryjobtype[$post['candidate_jobtype']]!='')
                {
                   $data_array .=$aryjobtype[$post['candidate_jobtype']];
                }
                else
                {
                    $data_array .='-';
                }
                $data_array .='</div></li>';

                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-3.png"></div><div class="list-data"> <span>'.$dashboard['company_only'].'</span><br>';
                if($postusername['company_name']!='')
                {
                    $data_array .=ucfirst($postusername['company_name']);
                }
                else
                {
                    $data_array .="N/A";
                }
                $data_array .='</div></li>';
                $data_array .='</ul>';

                $data_array .='<ul class="postedlist">';
                $data_array .='<li><span>'.$dashboard['loc'].'</span>'.$post['city'].', '.$post['country'].'</li>';
                $data_array .='<li><span>'.$dashboard['posted_on'].'</span>'.date('d M Y', strtotime($post['created_at'])).'</li>';
                $data_array .='<li><span>'.$dashboard['exp_date'].'</span> <span';
                if($post['status']==2)
                {
                    $data_array .='class="post-exp"';
                }
                $data_array .='>';
                if($post['status']==1 || $post['status']==3)
                {
                    if($post['expirydate']!='0000-00-00')
                    {
                        $data_array .=date('d M Y',strtotime($post['expirydate']));
                    }
                    else
                    {
                        $data_array .='N/A';
                    }
                }
                else
                {
                    $data_array .='Post Expired';
                }
                $data_array .='</span></li>';

                $data_array .='<li><span>Posted By :</span>';
                if($postusername['firstname']!='')
                {
                    $data_array .='<a href="'.href("userprofile.php","id=".base64_encode($post['user_id'])).'">'.ucfirst($postusername['firstname']." ".$postusername['lastname']).'</a>';
                }
                else
                {
                    $data_array .='N/A';
                }
                $data_array .='</li>';
                $data_array .='</ul>';
                $data_array .='</div>';
                $data_array .='<div class="mypostCol-Rt">';
                $data_array .='<div class="list-info">';
                if($postusername['phoneotpstatus']==1)
                {
                    $data_array .='<h5>'.$dashboard['ph_ver'].'</h5>';
                }

                $checkapplied=$db->getRow("select post_id,is_shortlisted,is_finalized from user_apply_job where post_id='".$post['post_id']."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
                if(count($checkapplied)>0)
                {
                    if($checkapplied['is_shortlisted']==0 && $checkapplied['is_finalized']==0 && $checkapplied['post_id']!='')
                    {
                        $data_array .='<a href="javascript:void(0);" class="appliedbtn">'.$dashboard['applied'].'<i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                    else if($checkapplied['is_shortlisted']==1 && $checkapplied['is_finalized']==0)
                    {
                        $data_array .='<a href="javascript:void(0);" class="appliedbtn">'.$dashboard['short'].' <i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                    else if($checkapplied['is_shortlisted']==1 && $checkapplied['is_finalized']==1)
                    {
                        $data_array .='<a href="javascript:void(0);" class="appliedbtn">'.$dashboard['finalized'].'<i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                }
                else
                {
                    $data_array .='<a href="javascript:void(0);" id="applyjobbtn'.$post['post_id'].'" onclick="apply_job('.$post['post_id'].')" class="applyBtn">'.$dashboard['apply'].'</a>';
                    $data_array .='<span id="applyjobspan'.$post['post_id'].'" ></span>';
                    $data_array .='<span id="whileapplingjob'.$post['post_id'].'"></span>';
                }

                $data_array .='</div></div></div></div>';

        }
        }
        $data = array(
                        'data'      => $data_array,
                    );
        echo json_encode($data);
        break;
    }
    case "appliedjobhistory_loadmore":
    {
        $row = trim($_POST['row']);
        $appliedjobs = $db->getRows("select * from user_apply_job where user_id='".$_SESSION[LOGIN_USER]['userid']."' order by apply_job_id desc limit $row,$rowperpage");
        //echo "select * from user_apply_job where user_id='".$_SESSION[LOGIN_USER]['userid']."' order by apply_job_id desc limit $row,$rowperpage";
        if(count($appliedjobs)>0)
        {
            foreach ($appliedjobs as $key => $appliedjob)
            {
                $appliedjobpost=$db->getRow("select * from manage_posts where post_id='".$appliedjob['post_id']."'");
                $appliedjobpostusername=$db->getRow("select firstname,lastname,phoneotpstatus,company_name from users where id='".$appliedjobpost['user_id']."'");
                $postcurrency=$db->getVal("select code from currency where currency_id='".$appliedjobpost['pay_currency']."'");

                $data_array .='<div class="boxcontent my-postsRow m-0 post">';
                $data_array .='<div class="postinnerconfillter">';
                $data_array .='<div class="mypostCol-Lt">';
                $data_array .='<div class="job-title"><a href="'.href("jobdetail.php","id=". base64_encode($appliedjobpost['post_id'])).'">'.$appliedjobpost['title'].'</a></div>';
                if ($appliedjobpost['pay_type'] == 0)
                {
                    $paytype = "Fixed";
                }
                else
                {
                    $paytype = $arygetpaid[$appliedjobpost['pay_type']];
                }

                $data_array .='<ul>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-1.png"></div><div class="list-data"> <span>'.$paytype.'</span><br>'.$appliedjobpost['pay_amount']." ".$postcurrency.'</div></li>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-2.png"></div><div class="list-data"> <span>JOB TYPE</span><br>';
                if($aryjobtype[$appliedjobpost['candidate_jobtype']]!='')
                {
                    $data_array .=$aryjobtype[$appliedjobpost['candidate_jobtype']];
                }
                else
                {
                    $data_array .='-';
                }
                $data_array .='</div></li>';
                $data_array .='<li><div class="list-icon"><img src="'.URL_ROOT.'img/mp-icon-3.png"></div><div class="list-data"> <span>COMPANY</span><br>';
                if($appliedjobpostusername['company_name']!='')
                {
                    $data_array .=ucfirst($appliedjobpostusername['company_name']);

                }
                else
                {
                    $data_array .='N/A';

                }
                $data_array .='</div></li>';
                $data_array .='</ul>';

                $data_array .='<ul class="postedlist">';
                $data_array .='<li><span>'.$dashboard['loc'].'</span>'.$appliedjobpost['city'].', '.$appliedjobpost['country'].'</li>';
                $data_array .='<li><span>'.$dashboard['posted_on'].'</span>'.date('d M Y', strtotime($appliedjobpost['created_at'])).'</li>';
                $data_array .='<li><span>'.$dashboard['exp_date'].'</span> <span';
                if($appliedjobpost['status']==2)
                {
                    $data_array .=' class="post-exp"';
                }
                $data_array .='>';
                if($appliedjobpost['status']==1 || $appliedjobpost['status']==3)
                {
                    if($appliedjobpost['expirydate']!='0000-00-00')
                    {
                        $data_array .=date('d M Y',strtotime($appliedjobpost['expirydate']));
                    }
                    else
                    {
                        $data_array .='N/A';
                    }
                }
                else
                {
                    $data_array .='Post Expired';
                }
                $data_array .='</span></li>';

                $data_array .='<li><span>'.$dashboard['ps_by'].'</span>';
                if($appliedjobpostusername['firstname']!='')
                {
                    $data_array .='<a href="'.href("userprofile.php","id=".base64_encode($appliedjobpost['user_id'])).'">'.ucfirst($appliedjobpostusername['firstname']." ".$appliedjobpostusername['lastname']).'</a>';
                }
                else
                {
                    $data_array .='N/A';
                }
                $data_array .='</li>';
                $data_array .='</ul>';
                $data_array .='</div>';
                $data_array .='<div class="mypostCol-Rt">';

                if($appliedjobpostusername['phoneotpstatus']==1)
                {
                    $data_array .='<h5>Phone Verified</h5>';
                }

                $checkapplied=$db->getRow("select post_id,is_shortlisted,is_finalized from user_apply_job where post_id='".$appliedjobpost['post_id']."' && user_id='".$_SESSION[LOGIN_USER]['userid']."'");
                if(count($checkapplied)>0)
                {
                    if($checkapplied['is_shortlisted']==0 && $checkapplied['is_finalized']==0 && $checkapplied['post_id']!='')
                    {
                       $data_array .='<a href="javascript:void(0);" class="appliedbtn">Applied <i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                    else if($checkapplied['is_shortlisted']==1 && $checkapplied['is_finalized']==0)
                    {
                      $data_array .='<a href="javascript:void(0);" class="appliedbtn">Shortlisted <i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                    else if($checkapplied['is_shortlisted']==1 && $checkapplied['is_finalized']==1)
                    {
                       $data_array .='<a href="javascript:void(0);" class="appliedbtn">Finalized <i class="far fa-check-circle" aria-hidden="true"></i></a>';
                    }
                }
                else
                {
                    $data_array .='<a href="javascript:void(0);" id="apllyjobbtn'.$appliedjobpost['post_id'].'" onclick="apply_job('.$appliedjobpost['post_id'].');" class="applyBtn">'.$dashboard['apply'].'</a>';
                    $data_array .='<span id="apllyjobspan'.$appliedjobpost['post_id'].'" ></span>';
                    $data_array .='<span id="whileapplingjob'.$appliedjobpost['post_id'].'"></span>';
                }
                if($appliedjobpost['status']==2)
                {
                    $data_array .='<a href="javascript:void(0);" id="clearjobbtn'.$appliedjob['apply_job_id'].'" onclick="clear_apply_job('.$appliedjob['apply_job_id'].');" class="applyBtn">'.$dashboard['clear'].'</a>';
                }

                $data_array .='</div></div></div>';
            }
        }
        $data = array(
                        'data'      => $data_array,
                    );
        echo json_encode($data);
        break;
    }
    case "msg_notification_count":
    {
        $notificationscount=$db->getVal("select count(notification_id) from notification where notify='".$_SESSION[LOGIN_USER]['userid']."' && is_read='1' order by notification_id desc");
        $receivemsgcount=$db->getVal("select count(message_id) from messages where receiver_id='".$_SESSION[LOGIN_USER]['userid']."' && status='0' && is_read=0");
        $replymsgcount=$db->getVal("select count(message_id) from messages where sender_id='".$_SESSION[LOGIN_USER]['userid']."' &&  status='1' && is_read=0");
        $messagecount=$receivemsgcount+$replymsgcount;
        //$messagecount=$db->getVal("select count(message_id) from messages where (sender_id='".$_SESSION[LOGIN_USER]['userid']."' || receiver_id='".$_SESSION[LOGIN_USER]['userid']."')  && (status='0' || status='1')");
        //echo "select count(message_id) from messages where (sender_id='".$_SESSION[LOGIN_USER]['userid']."' || receiver_id='".$_SESSION[LOGIN_USER]['userid']."')  && (status='0' || status='1')";
        $data = array(
                        'RESPONSECODE' => 1,
                        'noticount'    => $notificationscount,
                        'msgcount'     => $messagecount,
                    );
        echo json_encode($data);
        break;
    }
    case "setlocations":
    {
        $_SESSION['country_data'] = [
                                        'country'       => trim($_POST['country']),
                                        'city'          => trim($_POST['city']),
                                    ];
        break;
    }
    case 'deleteprofile':
    {
        $deljobviewer   = $db->delete('jobpost_viewers',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $deljobpost     = $db->delete('manage_posts',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delsendermsg = $db->delete('messages',"where sender_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delreceivermsg = $db->delete('messages',"where receiver_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $deltriggerednoti = $db->delete('notification',"where triggered_by='".$_SESSION[LOGIN_USER]['userid']."'");
        $delnotifynoti = $db->delete('notification',"where notify='".$_SESSION[LOGIN_USER]['userid']."'");
        $delreviewby = $db->delete('review_rating',"where reviewby_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delreviewto = $db->delete('review_rating',"where reviewto_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delprofileuser = $db->delete('userprofile_viewers',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delprofileviewer = $db->delete('userprofile_viewers',"where viewer_id='".$_SESSION[LOGIN_USER]['userid']."'");

        $userimg = $db->getVal("SELECT profile_image FROM users where id=".$_SESSION[LOGIN_USER]['userid']);
        @unlink("uploads/users/".$userimg);
        @unlink("uploads/users/resize/".$userimg);
        $deluser = $db->delete('users',"where id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delexp = $db->delete('users_experience',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");

        $delfollowerseuser = $db->delete('users_followers',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delfollowersfollower = $db->delete('users_followers',"where follower_id='".$_SESSION[LOGIN_USER]['userid']."'");

        $delskillsuser = $db->delete('users_skills',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $delapplyjobuser = $db->delete('user_apply_job',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        $deluserfavjob = $db->delete('user_favorite_job',"where user_id='".$_SESSION[LOGIN_USER]['userid']."'");
        unset($_SESSION[LOGIN_USER]['email']);
        unset($_SESSION[LOGIN_USER]['userid']);
        session_destroy();
        echo 1;
        break;
    }
}
   
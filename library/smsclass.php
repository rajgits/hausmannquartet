<?php
    include 'config.php';

    /**
     * Class to send sms
     */
    use Twilio\Rest\Client;
    class SMS
    {
        private $tonumber;

        private $smstype;

        private $vars;

        function __construct($tonumber,$smstype,$vars)
        {
            $this->tonumber = $tonumber;

            $this->smstype = $smstype;

            $this->vars = $vars;
        }

        public function SendSms(){
            $message = $this->BuildMessage();
            // Your Account SID and Auth Token from twilio.com/console
            $sid = 'ACd439fa652c489ab101a6da92ea229f00';
            $token = 'f94afa253fab0774b3deb855fa78f525';
            $client = new Client($sid, $token);

            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
                // the number you'd like to send the message to
                $tonumber,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => 'sahmrs',
                    // the body of the text message you'd like to send
                    'body' => $message
                )
            );
        }

        protected function BuildMessage(){
            global $db;
            $message = $db->getVal("select body from manage_sms_content where type='".$this->smstype."'");
            $vars = $this->vars;
            if($vars!="")
            {
                if(count($vars))
                {
                    foreach($vars as $key => $val)
                    {
                        if($key=='url'){$val="<a href='".$val."'>Click Here</a></h1>";}
                        $message=str_replace($key,$val,$message);
                    }
                    $message = str_replace("{","",$message);
                    $message = str_replace("}","",$message);
                }
            }
        }
    }
 ?>

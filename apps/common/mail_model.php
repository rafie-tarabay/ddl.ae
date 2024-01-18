<?php

class Mail extends base{


    public function send_email_verification($params){                                

        $url = base_url(front_base."join/2/".$params["reference"]."?code=".$params["email_code"]);

        $msg = '<p>';
        $msg .= "Please use this code to verify your Account";        
        $msg .= '<h2>'.$params["email_code"].'</h2>';                 
        $msg .= '</p>';

        $msg .= '<p>';
        $msg .= 'You can use the following link to complete your registeration at any time<br>';                 
        $msg .= '<a href="'.$url.'">'.$url.'</a>';         
        $msg .= '</p>';

        $data = array(
            "to" => $params["email"],
            "from" => "info@ddl.ae",
            "subject" => "Verify Account",
            "message" => $msg,
        );              
        $this->send($data);        
    }    


    public function send_fp_email($params){                                

        $url = base_url(front_base."reset-password/".$params["code"]);

        $msg = '<p>';
        $msg .= "Please use this code to reset your password";        
        $msg .= '<h2>'.$params["code"].'</h2>';                 
        $msg .= '</p>';

        $msg .= '<p>';
        $msg .= 'You can use the following link<br>';                 
        $msg .= '<a href="'.$url.'">'.$url.'</a>';         
        $msg .= '</p>';

        $data = array(
            "to" => $params["email"],
            "from" => "info@ddl.ae",
            "subject" => "Forget Password",
            "message" => $msg,
        );              
        $this->send($data);        
    }    


    public function payment_error($paylog){                                

        $msg = "Payment was successfull but error occoured while saving Payment in Databse";
        $msg .= "UserID:   ".$paylog["payment_u_id"]."<br>";
        $msg .= "OrderID:  ".$paylog["payment_order_id"]."<br>";
        $msg .= "Method:   ".$paylog["payment_method"]."<br>";
        $msg .= "Account:  ".$paylog["payment_account"]."<br>";
        $msg .= "Ref_id:   ".$paylog["payment_ref_id"]."<br>";
        $msg .= "Amount:   ".$paylog["payment_currency"].$paylog["payment_amount"]."<br>";
        
        $data = array(
            "to" => "support@ddl.ae",
            "from" => "tech@ddl.ae",
            "subject" => "Payment Error Order #".$paylog["payment_order_id"],
            "message" => $msg,
        );              
        $this->send($data);       
    }    




    public function send($data){                                

        //return true;

        $from    = $data["from"] ? $data["from"] : "info@ddl.ae";
        $to      = $data["to"] ? $data["to"] : "info@ddl.ae";
        $subject = $data["subject"];
        $message = $data["message"];        

        $this->load->library('email');

        


        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';        
     //   $config['smtp_host'] = 'smtp.sendgrid.net';//sendgrid
        $config['smtp_host'] = 'smtp.mandrillapp.com'; 
       // $config['smtp_user'] = 'apikey'; 
        $config['smtp_user'] = 'Mohammed bin Rashid Al Maktoum Knowledge Foundation';
        // $config['smtp_pass'] = 'SG.JYG40Jm4Su-gO5RhMJD3Yw.IzYt8DDXHjDn-u0TsDP83OS3dtJLL-2khsT3joOC-6Y';
        $config['smtp_pass'] = 'ZUQ-YQCAlDcIP2jhzm5aIg';
        $config['smtp_port'] = __ssl ? 465 : 25;        
        $config['charset'] = 'utf-8';        
        $config['newline'] = "\r\n";
        $config['crlf'] = "\r\n";        

        $this->email->initialize($config);        


        $this->email->to($to);
        $this->email->from($from);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();     

    }    

}
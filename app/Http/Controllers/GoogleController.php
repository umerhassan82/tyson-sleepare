<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop\Order;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class GoogleController extends Controller
{
    
    public function getClient(){
        $client = new \Google_Client();
        $client->setApplicationName('Gmail API PHP Quickstart');
        $client->setScopes(\Google_Service_Gmail::GMAIL_READONLY);
        $client->setAuthConfig(__DIR__.'/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $tokenPath = __DIR__.'/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    // public function trackOrder(){
    //     $orders = Order::where("tracking_receipt_status", "processed")->get(); 
    // }

    public function readEmails(){
        $client = $this->getClient();
        $service = new \Google_Service_Gmail($client);

        $user = 'me';
        $this->listMessages($service, $user);
    }


    public function sendReceipt(){

        //from:(sales@brooklynbeddingwholesale.com) gabrielle pyronneau after:2019/6/2 before:2019/6/5

        $client = $this->getClient();
        $service = new \Google_Service_Gmail($client);

        $orders = Order::where("receipt_status_gmail", "!=" , 1)->get();
        $date = date( 'Y/m/d', strtotime( '-1 day' ));
        
        $pageToken  = NULL;
        $messages   = array();
        $user     = 'me';

        foreach($orders as $order){

            $customerName = $order->first_name." ".$order->last_name;

            // echo($customerName);
            // echo("<br />");


            $queries = array(
                "brooklyn" => "from:(tracking@shipstation.com) ".$customerName." after:".$date,
                "bear"     => "from:(shanir@sleepare.com) Fwd: Bear Mattress Order ".$customerName." after:".$date
            );

            foreach($queries as $brand => $query){
                
                $opt_param = array(
                    'q' => $query
                );

                do {
                    try {
                        if ($pageToken) {
                            $opt_param['pageToken'] = $pageToken;
                        }
                        
                        $messagesResponse = $service->users_messages->listUsersMessages($user, $opt_param);
                        if ($messagesResponse->getMessages()) {
                            $messages = array_merge($messages, $messagesResponse->getMessages());
                            $pageToken = $messagesResponse->getNextPageToken();
                        }

                        $body = "";
                        foreach ($messages as $message) {
                            $mess = $this->getMessage($service, $user, $message->getId());
                            $thread = $this->getThread($service, $user, $mess->threadId);
    
                            switch($brand){
                                case "brooklyn":
                                    $body = $this->base64url_decode($thread->messages[0]->payload->body->data);

                                    if(!empty($body)){
                                        $body = preg_replace('#<div dir="ltr" class="gmail_attr">(.*?)</div>#', '', $body);
                                        $body = preg_replace('#<div dir="ltr" class="gmail_signature" data-smartmail="gmail_signature">(.*?)</div>#', '', $body);
                                        $body = str_replace('dir="rtl"', 'dir="ltr"', $body);
                                    } // end if

                                    $emailBody = $body;

                                    $empID = 'Sleepare';
                                    $emailFrom = 'info@sleepare.com';
                                    $password = 'z*S&E38CVtzA';
                                    $sendTo = $order->email;

                                    $txt = $emailBody;

                                    $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                    $mail->Username = $emailFrom;                		  // SMTP username
                                    $mail->Password = $password;              		 	  // SMTP password
                                    $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
                                    $mail->Port = 465;                                    // Set the SMTP port number - 587 for authenticated TLS
                                    $mail->setFrom($emailFrom, $empID);   	 	  		  // Set who the message is to be sent from
                                    $mail->addAddress($sendTo, $order->first_name);	  	  // Add a recipient
                                    // $mail->addCC($to);
                                    $mail->isHTML(true);                                  // Set email format to HTML
                                    $mail->Subject = $customerName.' your order has shipped!';
                                    $mail->Body    = $txt;

                                    if(!$mail->send()) {
                                        return '<h1>Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo.'</h1>';
                                    }

                                    $updateOrder = Order::find($order->id);
                                    $updateOrder->receipt_status_gmail = 1;
                                    $updateOrder->tracking_receipt_status = 'processed';
                                    $updateOrder->save();


                                break; //end brooklyn
                                // case "bear":
                                //     $body = $this->base64url_decode($thread->messages[0]->payload->parts[1]->body->data);
                                // break;
                            }
                        } // end foreach
                    } catch (\Exception $e) {
                        print 'An error occurred: ' . $e->getMessage();
                    }
                } while ($pageToken);
            } // end foreach

        }// end foreach
    }

    function getBetween($content,$start,$end){
        $r = explode($start, $content);
        if (isset($r[1])){
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    public function listMessages($service, $userId) {
        $pageToken = NULL;
        $messages = array();
        $opt_param = array(
            'q' => 'is:sent from:(roy@sleepare.com) to:(umerhassan82@gmail.com)',
            // 'q' => "Fwd: Bear Mattress Order Matt Kelpy after:2019/6/2",
        );
        do {
          try {
            if ($pageToken) {
              $opt_param['pageToken'] = $pageToken;
            }
            $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
            if ($messagesResponse->getMessages()) {
              $messages = array_merge($messages, $messagesResponse->getMessages());
              $pageToken = $messagesResponse->getNextPageToken();
            }
          } catch (\Exception $e) {
            print 'An error occurred: ' . $e->getMessage();
          }
        } while ($pageToken);
    
        $user = 'me';
      
        foreach ($messages as $message) {
        //   echo('Message with ID: ' . $message->getId() . '<br/>');
    
            $mess = $this->getMessage($service, $user, $message->getId());
            $thread = $this->getThread($service, $user, $mess->threadId);

            // $mess->payload->headers[14]->value  // subject, brooklan
            // echo($mess->snippet); // bear
        
            // dd($thread->messages[4]->payload->parts[0]->body->data);
            // $body = $this->base64url_decode($thread->messages[0]->payload->parts[1]->body->data);
            $body = $this->base64url_decode($thread->messages[0]->payload->body->data);

            $body = preg_replace('#<div dir="ltr" class="gmail_attr">(.*?)</div>#', '', $body);
            $body = preg_replace('#<div dir="ltr" class="gmail_signature" data-smartmail="gmail_signature">(.*?)</div>#', '', $body);
            $body = str_replace('dir="rtl"', 'dir="ltr"', $body);
            echo($body);

            // $empID = 'Sleepare';
            // $emailFrom = 'info@sleepare.com';
            // $password = 'z*S&E38CVtzA';

            // $sendTo = "roy@sleepare.com";
            // $useName = "Roy Yosef";

            // $txt = $body;

            // $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
            // $mail->isSMTP();                                      // Set mailer to use SMTP
            // $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
            // $mail->SMTPAuth = true;                               // Enable SMTP authentication
            // $mail->Username = $emailFrom;                		  // SMTP username
            // $mail->Password = $password;              		 	  // SMTP password
            // $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            // $mail->Port = 465;                                    // Set the SMTP port number - 587 for authenticated TLS
            // $mail->setFrom($emailFrom, $empID);   	 	  		  // Set who the message is to be sent from
            // $mail->addAddress($sendTo, $useName);	  	  // Add a recipient

            // // $mail->addCC($to);
            // $mail->isHTML(true);                                  // Set email format to HTML

            // $mail->Subject = 'Thank You Roy Yosef for Ordering Premium Shredded Foam Pillow';
            // $mail->Body    = $txt;

            // if(!$mail->send()) {
            //     return '<h1>Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo.'</h1>';
            // }
        }
        // return $messages;
    }


    function base64url_decode( $data ){
        return base64_decode( strtr( $data, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $data )) % 4 ));
    }

    function getThread($service, $userId, $threadId) {
        try {
            $thread = $service->users_threads->get($userId, $threadId);
            $messages = $thread->getMessages();
            $msgCount = count($messages);

            return $thread;
        } catch (Exception $e){
            print 'An error occurred: ' . $e->getMessage();
        }

    }


    function getMessage($service, $userId, $messageId) {
        $opt_param = array(
            'format' => 'metadata',
        );
        try {
          $message = $service->users_messages->get($userId, $messageId, $opt_param);
          return $message;
        } catch (\Exception $e) {
          print 'An error occurred: ' . $e->getMessage();
        }
    }

}
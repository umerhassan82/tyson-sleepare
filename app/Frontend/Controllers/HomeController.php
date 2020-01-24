<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Shop\ShopBrands;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = ShopBrands::all();
        return view('frontend.'.config('template').'.home', ['products' => Product::where('status', 1)->limit(3)->get(), 'breadcrumbs' => 'home', 'brands' => $brands]);
    }

    public function checkmail(Request $request){
        if(!empty($request->custemail)){
            $to		= $request->custemail;
            $url = 'https://api.hippoapi.com/v3/more/json';
            $apikey = '19B30B81'; // API Key
            $email = $to; // Email to test
            //$email = 'lahorewebdesign@gmail.com'; // Email to test
            // jSON String for request
            $url .= "/$apikey/$email";
            // Initializing curl
            $ch = curl_init($url);
            if($ch == false) {
                die ("Curl failed!");
            } else {
            // Configuring curl options
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json')
                );
                // Setting curl options
                curl_setopt_array( $ch, $options );
                // Getting results
                $result = curl_exec($ch); // Getting jSON result string
                // display JSON data
                $myResponse = json_decode($result);
                $myMailStatus = $myResponse->emailVerification->mailboxVerification->result;
                return $myMailStatus;
            }
        }// end not empty
                return true;
    }

    public function purchase(Request $request){
        if(!empty($request)){
            // echo '<pre>';print_r($_POST);echo '</pre>';
            // exit;
            $prodsContent = array();
            $prodsCompUrl = '';
            $myUserKey	  = '';
            $productsData = array();
            if(!empty($request->prodData)){
                $count	= 0;
                $to		= strtolower($request->custemail);
                $txt	= '';
                if(!isset($request->empID)){
                    $empID = 'Solee';
                    $emailFrom = 'solee@sleepare.com';
                }else{
                    if($request->empID === "Danny"){
                        $empID = 'Danny';
                        $emailFrom = 'danny@sleepare.com';
                    }else if($request->empID === "Roy"){
                        $empID = 'Roy';
                        $emailFrom = 'roy@sleepare.com';
                    }else{
                        $empID = 'Solee';
                        $emailFrom = 'solee@sleepare.com';
                    }
                }
                $productsData = $productsDataT = (isset($request->prodData[0]['prodsize'])?$request->prodData[0]['prodsize']:"").' '.(isset($request->prodData[0]['prodfirm'])? $request->prodData[0]['prodfirm'] : "").' '.(isset($request->prodData[0]['prodname']) ? $request->prodData[0]['prodname'] : "");
                $myProduct    = $request->prodData[0]['prodorgurl'];
                if($myProduct === "saatva")
			        $myProductUrl = 'https://refer.saatvamattress.com/s/sleeparesaatva';
                else if($myProduct === "purple-2")
                    $myProductUrl = 'https://purple.pxf.io/c/1221964/461691/8120?subId1=&subId2=email&subId3=';
                else if($myProduct === "purple-3")
                    $myProductUrl = 'https://purple.pxf.io/c/1221964/461691/8120?subId1=&subId2=email&subId3=';
                else if($myProduct === "purple-4")
                    $myProductUrl = 'https://purple.pxf.io/c/1221964/461691/8120?subId1=&subId2=email&subId3=';
                else if($myProduct === "leesa")
                    $myProductUrl = 'https://leesa-sleep.evyy.net/c/1239780/236769/4014?subId1=&subId2=email&subId3=';
                else if($myProduct === "layla")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=828972&u=1718190&m=63899&urllink=laylasleep%2Ecom%2Fproduct%2Flayla%2Dmattress&afftrack=';
                else if($myProduct === "sapira")
                    $myProductUrl = 'https://www.leesa.com/products/sapira-mattress?utm_source=sleepare&utm_medium=aff&utm_campaign=2018&utm_content=all&utm_term=general&referrer=sleepare&utm_general=';
                else if($myProduct === "airweave")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=965230&u=1718190&m=69909&urllink=&afftrack=';
                else if($myProduct === "muse")
                    $myProductUrl = 'https://shareasale.com/u.cfm?d=535031&m=69610&u=1718190&afftrack=';
                else if($myProduct === "winkbeds")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=737891&u=1718190&m=59174&urllink=&afftrack=';
                else if($myProduct === "spindle")
                    $myProductUrl = 'https://shop.spindlemattress.com/?aff=49';
                else if($myProduct === "loom-leaf")
                    $myProductUrl = 'https://refer.loomandleaf.com/s/sleepareloomandleaf';
                else if($myProduct === "tomorrow-hybrid")
                    $myProductUrl = 'https://click.linksynergy.com/deeplink?id=w9s/SuZO5*M&mid=42893&u1=sleepare&murl=https%3A%2F%2Fwww.tomorrowsleep.com%2Fhybrid-mattress&LSNSUBSITE=LSNSUBSITE';
                else if($myProduct === "puffy")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1044373&u=1718190&m=73372&urllink=puffy%2Ecom%2Fproducts%2Fpuffy%2Dmattress&afftrack=';
                else if($myProduct === "zenhaven")
                    $myProductUrl = 'https://refer.zenhaven.com/s/sleeparezenhaven';
                else if($myProduct === "nest-bedding-alexander-hybrid")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1123631&u=1718190&m=50539&urllink=&afftrack=';
                else if($myProduct === "nest-bedding-hybrid-latex")
                    $myProductUrl = 'https://shareasale.com/u.cfm?d=474388&m=50539&u=1718190&afftrack=';
                else if($myProduct === "brooklyn-bedding-aurora")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1096062&u=1718190&m=67286&urllink=&afftrack=';
                else if($myProduct === "brooklyn-bedding-signature-hybrid")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1096061&u=1718190&m=67286&urllink=&afftrack=';
                else if($myProduct === "brooklyn-bedding-bloom-hybrid")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1250105&u=1718190&m=67286&urllink=&afftrack=';
                else if($myProduct === "brooklyn-bedding-plank")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1231894&u=1718190&m=67286&urllink=&afftrack=';
                else if($myProduct === "brooklyn-bedding-bowery")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1133477&u=1718190&m=67286&urllink=&afftrack=';
                else if($myProduct === "helix-twilight")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1220801&u=1718190&m=60720&urllink=&afftrack=';
                else if($myProduct === "helix-moonlight")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1220798&u=1718190&m=60720&urllink=&afftrack=';
                else if($myProduct === "helix-dusk")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1220800&u=1718190&m=60720&urllink=&afftrack=';
                else if($myProduct === "helix-luxe")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=984984&u=1718190&m=60720&urllink=&afftrack=';
                else if($myProduct === "ecosa")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1208593&u=1718190&m=79934&urllink=&afftrack=';
                else if($myProduct === "bear")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1220420&u=1718190&m=60398&urllink=&afftrack=';
                else if($myProduct === "bear-hybrid")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1220421&u=1718190&m=60398&urllink=&afftrack=';
                else if($myProduct === "casper")
                    $myProductUrl = 'https://casper.pxf.io/c/1377308/398797/7235';
                else if($myProduct === "big-fig")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=1187541&u=1718190&m=80043&urllink=&afftrack=';
                else if($myProduct === "brentwood-home-oceano")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=894973&u=1718190&m=67066&urllink=www%2Ebrentwoodhome%2Ecom%2Fproducts%2Foceano%2Dmattress&afftrack=';
                else if($myProduct === "nectar")
                    $myProductUrl = 'http://nectar.pxf.io/c/1239780/489168/8338?subId1=&subId2=email&subId3=&prodsku=1&u=https%3A%2F%2Fwww.nectarsleep.com%2Fmattress%2Ftwin';
                else if($myProduct === "dreamcloud")
                    $myProductUrl = 'https://dreamcloudsleep.pxf.io/Da5Gq?subId1=&subId2=email&subId3=';
                else if($myProduct === "awara")
                    $myProductUrl = 'https://awara-sleep.pxf.io/QEBn6?subId1=&subId2=email&subId3=';
                else if($myProduct === "level-sleep")
                    $myProductUrl = 'https://levelsleep.pxf.io/LEeN0?subId1=&subId2=email&subId3=';
                else if($myProduct === "avocado")
                    $myProductUrl = 'https://shareasale.com/r.cfm?b=939087&u=1718190&m=68778&urllink=&afftrack=';

                $servername = "35.214.152.133";
                $username 	= "sleepmag_store";
                $passworddb = "(hS63x-p87";
                $dbname 	= "sleepmag_store";
                $db_port    = '3306';
                
                //Create connection
                // $conn = new \mysqli($servername, $username, $passworddb, $dbname);
                $conn = mysqli_connect($servername, $username, $passworddb, $dbname, $db_port) or die ('I cannot connect to the database because');
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = 'INSERT INTO tbluser_info (cust_name, cust_email, cust_number, cust_comments, keyword, email_text, cust_date, employee) VALUES ("'.$request->custname.'", "'.$to.'", "'.$request->custphone.'", "'.$request->custcom.'", "'.$request->keyword.'", "'.$productsDataT.'", "'.date('Y-m-d H:i:s').'", "'.$empID.'")';
                //echo $sql;
                $conn->query($sql);
                $conn->close();
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://sleepare.user.com/api/public/users/search/?email=$to",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Token QLhvrwN3TiJfilv9vsbj8uK748QZLZvLWxX0qV9n9TurwfIZ07TzedIsdAt3Q7be",
                    ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                
                if ($err) {
                    return "cURL Error #:" . $err;
                } else {
                    //echo 'response: '.$response;
                    $myResponseT = json_decode($response);
                    //echo '<pre>';print_r($myResponseT);echo '</pre>';exit;
                    if(isset($myResponseT->detail) && ($myResponseT->detail === "You didn't pay... please pay for app..." || $myResponseT->detail === "Application is not active."))
                    //if($myResponseT->detail === "You didn't pay... please pay for app..." || $myResponseT->detail === "Application is not active.")
                    {
                        return $myProductUrl;
                    }
                    else{
                        if($response === ""){
                            $dataArray = array('email' => $to, 'first_name' => $request->custname);
                            $dataArray = json_encode($dataArray);
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://sleepare.user.com/api/public/users/",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => $dataArray,
                                CURLOPT_HTTPHEADER => array(
                                    "Authorization: Token QLhvrwN3TiJfilv9vsbj8uK748QZLZvLWxX0qV9n9TurwfIZ07TzedIsdAt3Q7be",
                                    "content-type: application/json"
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            
                            curl_close($curl);
                            
                            if ($err) {
                                return "cURL Error #:" . $err;
                            } else {
                                $myResponse = json_decode($response);
                                $myUserKey	= $myResponse->key;
                                $dataArraySub = array('name' => 'purchase_from_showroom', 'client' => $myResponse->id, 'data' => array('emailfrom' => $emailFrom, 'email' => $to, 'customer_name' => $request->custname, 'keyword' => $request->keyword, 'phone' => $request->custphone, 'comments' => $request->custcom, 'products' => $productsData, 'visit_date' => date('Y-m-d'), 'visit_time' => date('H:i:s'), 'product_link' => $myProductUrl));
                                $dataArraySub = json_encode($dataArraySub);
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => "https://sleepare.user.com/api/public/events/",
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "POST",
                                    CURLOPT_POSTFIELDS => $dataArraySub,
                                    CURLOPT_HTTPHEADER => array(
                                        "Authorization: Token QLhvrwN3TiJfilv9vsbj8uK748QZLZvLWxX0qV9n9TurwfIZ07TzedIsdAt3Q7be",
                                        "content-type: application/json"
                                    ),
                                ));
                                
                                $response = curl_exec($curl);
                                $err = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    return "cURL Error #:" . $err;
                                } else {
                                    //echo $response;
                                }
                            }	
                        }
                        else
                        {
                            $myResponse = json_decode($response);
                            $myUserKey	= $myResponse->key;
                            $dataArraySub = array('name' => 'purchase_from_showroom', 'client' => $myResponse->id, 'data' => array('emailfrom' => $emailFrom, 'email' => $to, 'customer_name' => $request->custname, 'keyword' => $request->keyword, 'phone' => $request->custphone, 'comments' => $request->custcom, 'products' => $productsData, 'visit_date' => date('Y-m-d'), 'visit_time' => date('H:i:s'), 'product_link' => $myProductUrl));
                            $dataArraySub = json_encode($dataArraySub);
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://sleepare.user.com/api/public/events/",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => $dataArraySub,
                                CURLOPT_HTTPHEADER => array(
                                    "Authorization: Token QLhvrwN3TiJfilv9vsbj8uK748QZLZvLWxX0qV9n9TurwfIZ07TzedIsdAt3Q7be",
                                    "content-type: application/json"
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            curl_close($curl);
                            if ($err) {
                                return "cURL Error #:" . $err;
                            } else {
                                //echo $response;
                                /*$myResponse = json_decode($response);
                                echo '<pre>';print_r($myResponse);echo '</pre>';exit;*/
                            }
                        }
                    }
                }
                
                if($myUserKey <> ""){
                    $shareSaleRegex	= '&afftrack=';
                    $shareSaleProds	= '?subId1=';
                    $shareSaleGenUt	= '&utm_general=';
                    $performHoriz	= '/camref:';
                    if (strpos($myProductUrl, $shareSaleRegex)) {
                        $redirectURL = $myProductUrl.$myUserKey;
                    }else if (strpos($myProductUrl, $shareSaleProds)) {
                        $redirectURL = str_replace('subId1=', 'subId1='.$myUserKey, $myProductUrl);
                        $redirectURL = str_replace('subId3=', 'subId3='.date('Y-m-d H:i:s'), $redirectURL);
                        //$redirectURL = $myProductUrl.$myUserKey;
                    }else if (strpos($myProductUrl, $shareSaleGenUt)) {
                        $redirectURL = $myProductUrl.$myUserKey;
                    }else if (strpos($myProductUrl, $performHoriz)) {
                        $redirectURL = str_replace('pubref:', 'pubref:'.$myUserKey.'/', $myProductUrl);
                    }else{
                        $redirectURL = $myProductUrl;
                    }
                }
                //echo $redirectURL;exit;
                return $redirectURL;
            }        
        }// end if
    }


    public function sendmail(Request $request){
        if(!empty($request)){
            $purchaseDate = '';
            if(!empty($request->purdate)){
                $purchaseDate = date('Y-m-d', strtotime($request->purdate));
            }
            // echo '$purchaseDate: '.$purchaseDate.'<br />';
            // echo '<pre>';print_r($_POST);echo '</pre>';
            // exit;
            $prodsContent = array();
            $prodsCompUrl = '';
            $myUserKey	  = '';
            $prodFrim	  = '';
            $innerData    = '';
            $productsData = array();
            $productsUrl  = array();
            $productsCop  = array();
            if(!empty($request->prodData)){
                $count	= 0;
                $to		= strtolower($request->custemail);
                $txt	= '';

                if(!isset($request->empID)){
                    $empID = 'Genero';
                    $empName = 'Genero';
                    $emailFrom = 'genaro@sleepare.com';
                    $password = 'genaro123';
                }else{
                    if($request->empID === "genero"){
                        $empID = 'Genero';
                        $empName = 'Genero';
                        $emailFrom = 'genaro@sleepare.com';
                        $password = 'genaro123';
                    }else if($request->empID === "dustin"){
                        $empID = 'Dustin';
                        $empName = 'Dustin Morgan';
                        $emailFrom = 'dustin@sleepare.com';
                        $password = 'Sleepare6996!';
                    }
                }
                
                $servername = "35.214.152.133";
                $username 	= "sleepmag_store";
                $passworddb = "(hS63x-p87";
                $dbname 	= "sleepmag_store";
                $db_port    = '3306';
                
                //Create connection
                // $conn = new \mysqli($servername, $username, $passworddb, $dbname);
                $conn = mysqli_connect($servername, $username, $passworddb, $dbname, $db_port) or die ('I cannot connect to the database because');
                //Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                foreach($request->prodData as $prodsData){
                    $myProduuctName = $prodsData['prodsize'].$prodFrim.' '.$prodsData['prodname'];
                    $myDiscCode     = $prodsData['disccode'];
                    $productsData[] = ' '.$myProduuctName;
                    $productsUrl[] = $prodsData['prodorgurl'];
                    //$innerArray = array();
                    $myURL = 'https://www.sleepare.com/us/thanks/?url='.$to.'&key='.$prodsData['prodorgurl'];
                    $prodFrim = '';
                    if(!empty($prodsData['prodfirm'])){
                        $prodFrim = ' '.$prodsData['prodfirm'];
                    }
                    if(!empty($prodsData['emailextra'])){
                        $productsCop[] = $myDiscCode;
                        $innerData .= 'Thank you for visiting the SleePare Showroom! Click <a href="'.$myURL.'" target="_blank">here</a> to purchase your '.$myProduuctName.'. '.$prodsData['emailextra'].'.<br /><br />';
                    }else{
                        if($myDiscCode === "VENMO"){
                            $productsCop[] = 'NoCode';
                            $innerData .= 'Thank you for visiting the SleePare Showroom! Click <a href="'.$myURL.'" target="_blank">here</a> to purchase your '.$myProduuctName.' and get $'.$prodsData['discamount'].' cash back through Venmo.<br /><br />';
                        }else{
                            $productsCop[] = $myDiscCode;
                            // $innerData .= 'Thank you for visiting the SleePare Showroom! Click <a href="'.$myURL.'" target="_blank">here</a> to apply the coupon code '.$myDiscCode.' and get $'.$prodsData['discamount'].' discount on your '.$myProduuctName.'.<br /><br />';
                            $innerData .= 'Thank you for visiting the SleePare Showroom! Click <a href="'.$myURL.'" target="_blank">here</a> to purchase your '.$myProduuctName.', and don\'t forget to type "'.$myDiscCode.'" in the discount code box on the checkout page to get $'.$prodsData['discamount'].' off your order!.<br /><br />';
                        }
                    }
                    // $innerData .= 'HOW TO GET YOUR DISCOUNT FOR '.$myProduuctName.':<br /><br />1. <a href="'.$myURL.'">Start here</a><br />2. Choose your mattress<br />'.($myDiscCode === "VENMO" ? '3. Proceed to payment window.<br /><br />' : '3. Type your discount code '.$myDiscCode.' in text box, when prompted<br />4. Proceed to payment window.<br /><br />' ).'';
                }
                $sendTo = $to;//info@winkbeds.com
                $txt	= 'Dear '.$request->custname.',<br /><br />
        <img src="https://www.sleepare.com/wp-content/themes/sleepare/emailopen.php?url='.$to.'&time='.date('Y-m-d H:i:s').'" width="1" height="1" />
        '.$innerData.'<br /><br />
        Regards,<br /><br />
        The SleePare team';
                //echo 'test: '.$txt; exit;
                $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = $emailFrom;                		  // SMTP username
                $mail->Password = $password;              		 	  // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
                $mail->Port = 465;                                    // Set the SMTP port number - 587 for authenticated TLS
                $mail->setFrom($emailFrom, $empID);   	 	  		  // Set who the message is to be sent from
                $mail->addAddress($sendTo, $request->custname);	  	  // Add a recipient
                $mail->addCC($to);
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Sleepare Showroom Visit';
                $mail->Body    = $txt;
                if(!$mail->send()) {
                    return '<h1>Message could not be sent.<br />Mailer Error: ' . $mail->ErrorInfo.'</h1>';
                }
                $productsDataT = implode(', ', $productsData);
                $productsUrlDa = implode(', ', $productsUrl);
                $productsCopDa = implode(', ', $productsCop);
                $productsData = implode(', ', $productsData);
                //exit;
                $sql = 'INSERT INTO tbluser_tyson (cust_name, cust_email, cust_number, cust_comments, keyword, email_text, cust_date, employee, produrls, prodcops) VALUES ("'.$request->custname.'", "'.$to.'", "'.$request->custphone.'", "'.$request->custcom.'", "'.$request->keyword.'", "'.$productsDataT.'", "'.date('Y-m-d H:i:s').'", "'.$empID.'", "'.$productsUrlDa.'", "'.$productsCopDa.'")';
                //echo $sql;
                $conn->query($sql);
                $conn->close();
                return '<h1>Thank you for visiting the Sleepare Showroom.</h1><br /><h2>Please check your email for details</h2>';
            }
        }// end if
    }// end send mail

    public function getKeywords($value = ' '){
        $keywords = file_get_contents('keywords.json');
        $keywords = json_decode($keywords);

        $options = '';
        foreach($keywords as $keyword){
            if(strpos(strtolower($keyword->text), strtolower($value)) !== false){
                $options .= '<a href="#!" data-value="'.$keyword->value.'" class="dropdown-item">'.$keyword->value.'</a>';
            } // end if
        }// end foreach
        
        return $options;
    }

} // end class

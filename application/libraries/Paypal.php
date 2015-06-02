<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Paypal{
   /* //Constructor and global variable are not necessary as all parameters are passed to PPHttpPost() method
   public $API_USERNAME;
   public $API_PASSWORD;
   public $API_SIGNATURE;
   public $API_ENDPOINT;

   function __construct($API_USERNAME, $API_PASSWORD, $API_SIGNATURE, $ENVIORNMENT){
      $this->API_USERNAME = $API_USERNAME;
      $this->API_PASSWORD = $API_PASSWORD;
      $this->API_SIGNATURE = $API_SIGNATURE;
      if($ENVIORNMENT == 'live'){
         $this->API_ENDPOINT = "https://api-3t.paypal.com/nvp";
      }
      else{
         $this->API_ENDPOINT = "https://api-3t.sandbox.paypal.com/nvp";
      }
   }*/

   function PPHttpPost($methodName_, $nvpStr_,$API_USERNAME, $API_PASSWORD, $API_SIGNATURE, $API_ENDPOINT) {
      $API_UserName = urlencode($API_USERNAME);
      $API_Password = urlencode($API_PASSWORD);
      $API_Signature = urlencode($API_SIGNATURE);
      $API_Endpoint = $API_ENDPOINT;
      $version = urlencode('109.0');

      // Set the curl parameters.
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
      curl_setopt($ch, CURLOPT_VERBOSE, 1);

      // Turn off the server and peer verification (TrustManager Concept).
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);

      // Set the API operation, version, and API signature in the request.
      $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature&BUTTONSOURCE=".urlencode("PHPMOOT_WPP_DP_US")."$nvpStr_";

      // Set the request as a POST FIELD for curl.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

      // Get response from the server.
      $httpResponse = curl_exec($ch);

      if(!$httpResponse) {
         exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
      }

      // Extract the response details.
      $httpResponseAr = explode("&", $httpResponse);

      $httpParsedResponseAr = array();
      foreach ($httpResponseAr as $i => $value) {
         $tmpAr = explode("=", $value);
         if(sizeof($tmpAr) > 1) {
            $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
         }
      }

      if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
         exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
      }

      return $httpParsedResponseAr;
   }
}
?>
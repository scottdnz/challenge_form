<?php
  /**
   * This file contains a base class for requesting data from an API.
   * 
   * @author Scott Davies
   * @version 1.0
   * @package ApiRequester
   */

namespace AppBundle\Lib;

use GuzzleHttp\Exception\RequestException;

/**
 * This is a base class for calling an API, then checking and storing the 
 * results, then returning output in a desired format.
 */
class ApiRequester 
{
    private _urlEndPoint;
    private _error;
    private _jsonRequestedArr;
    private _jsonResponseArr;

    function __construct() 
    {
        $this->_urlEndPoint = "";
        $this->_error = "";
        $this->_jsonRequestedArr = [];
        $this->_jsonResponseArr = ["result"=> "ok", "errors"=> ""];
    }
   
    /**
     * Attempts to call the API service. If all is valid, it converts the 
     * JSON response string into a PHP array. Otherwise, an error message is 
     * recorded. 
     */
    public function requestFromApi() 
    {
        $clientApi = new \GuzzleHttp\Client([
            "base_uri" => "https://services.mysublime.net/st4ts/data/get/type/",
            "timeout"  => 4.0]);
            
        try {    
            $response = $clientApi->request("GET", $this->_urlEndPoint);
            if ($response->getStatusCode() == "200") {
                $body = $response->getBody();
                $this->_jsonRequestedArr = json_decode($body); 
            }
            else { 
                $this->_error .= "Bad status code: . " . $response->getStatusCode(); 
            }
        }
        catch (Exception $exc) {
             $this->_error .= $exc->getMessage();
        }

    }
    
    /**
     * An interface-type method, designed to be filled in later by child classes.
     * This method will process data in the _jsonRequestedArr array and store data
     * for returning in the _jsonResponseArr array.  
     */
    public function setData() 
    {
        // Empty, to be overridden       
    }
    
    /**
     * An interface-type method, designed to be filled in later by child classes.
     * This method will return selected / transformed data in the _jsonResponseArr 
     * array.  
     */
    public function getResponseOutput() {
        // Empty, to be overridden
    } 
    
    /**
     * Returns any error messages recorded.
     * @return string _error
     */
    public function getError() {
        return $this->_error;
    }
}

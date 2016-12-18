<?php
  /**
   * This file contains a class for requesting Server Statistics from an API.
   * 
   * @author Scott Davies
   * @version 1.0
   * @package ServerStats
   */

namespace AppBundle\Lib;

/**
 * Retrieves a set of server stats from the API, and formats the data. The goal
 * is to return two simple data arrays for using in a graph.
 */
class ServerStats extends ApiRequester 
{
    function __construct() 
    {
        parent::__construct();
        $this->_urlEndPoint = "iq/server/";
    }
    
    /**
     * Sets the last part of the API URL end point
     * @param string $serverName
     */
    public function setServerName($serverName) {
        $this->_urlEndPoint .= $serverName . "/";
    }    

    /**
     * Processes the data returned from the API call.
     * @return array $res
     */
    public function setData() 
    {   
        $dataLabels = [];
        $dataValues = [];
        foreach($this->_jsonRequestedArr as $k=>$obj) {
           $dataLabels[] = $obj->data_label;            
           $dataValues[] = $obj->data_value;
        }
        $this->_jsonResponseArr["dataLabels"] = $dataLabels; 
        $this->_jsonResponseArr["dataPoints"] = $dataValues;        
    }
    
    /**
     * Adds error messages to the response returned. 
     * @return array _jsonResponseArr
     */
    public function getResponseOutput() 
    {
        if (strlen($this->_error) > 0) {
            $this->_jsonResponseArr["result"] .= "fail";
            $this->_jsonResponseArr["errors"] .= $this._error;                 
        }
        return $this->_jsonResponseArr;
    }  
    
}
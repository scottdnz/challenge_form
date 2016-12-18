<?php
  /**
   * This file contains a class for requesting a Server List from an API.
   * 
   * @author Scott Davies
   * @version 1.0
   * @package ServerList
   */

namespace AppBundle\Lib;

/**
 * Retrieves a list of server names from the API, and formats the data.
 */
class ServerList extends ApiRequester 
{
    function __construct() 
    {
        parent::__construct();
        $this->_urlEndPoint = "servers/";
    }    
    
    /**
     * Sets the _jsonResponseArr data in a simpler format for the server names 
     * found.
     */
    public function setData() 
    {
        $serverNames = [];
        foreach($this->_jsonRequestedArr as $k=>$obj) {
           $serverNames[] = $obj->s_system;
        }
        $this->_jsonResponseArr["server_list"] = $serverNames;
    }
    
    /** 
     * Returns a subset of the data.
     * @return array _jsonResponseArr
     */
    public function getResponseOutput() {
        return $this->_jsonResponseArr["server_list"];
    }    

}
<?php
/**
 * Boozio
 * 
 * Inspired by Finding a Good Deal at the Supermarkets
 * This Software has no affiliation with any Supermarkets.
 * 
 * @author Ciaran Synnott 
 * @package Boozio
 * @subpackage Supermarkets
 * 
 * Base class for individual Supermarkets
 * 
 */

namespace Boozio\Supermarkets;

class SupermarketBase  {
  
    private $supermarket_name;
    private $url;
    private $uid;
    
    /**
     * Gets Supermarket Name
     * 
     * @return string
     */
    public function get_supermarket_name(){
        return $this->supermarket_name;
    }
    
    /**
     * Gets URL of supermarket Items
     * 
     * @return string
     */
    public function get_url(){
        return $this->url;
    }

    /**
     * Gets Unique ID for individual Products
     * 
     * @return int
     */
    public function get_uid(){
        return $this->uid;
    }
    
}

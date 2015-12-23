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
 * Class for Scrapping the Supermarket Morrisons
 * 
 */

namespace Boozio\Supermarkets;

use Boozio\Basket\Item as BasketItem;
use Boozio\CUrl\CUrl as CUrl;
use Boozio\Supermarkets\SupermarketBase as Supermarket;
use DOMDocument;
use DOMXPath;

class Morrisons extends Supermarket {

    public function __construct() {
        $this->url = "https://groceries.morrisons.com/webshop/getBackOfPackPopup.do?sku=";
        $this->supermarket_name = "Morrisons";
    }
    
    /**
     * Main function to be called to fetch an Item
     * 
     * @param int $uid Unique Item ID
     * @return BasketItem - returns a Basket Item; 
     */
    public function fetch($uid) {
        $this->uid = $uid;
        return $this->extract(new CUrl($this->url . $this->uid."&ajax=ajax"));
    }
   
    /**
     * Passes a CUrl response Object to check results
     * 
     * @param CUrl $CUrl - CUrl Object
     * @return BasketItem - returns a Basket Item; 
     */
    private function extract(CUrl $CUrl) {

        $CUrl->go_fetch();
        
        if ($CUrl->get_status_code() == 200) {
                        
            $data = $CUrl->get_response();
                        
            $sku = $this->find_sku();
            $item_name = $this->find_item_name($data);
            $price = $this->find_price($data);
            $on_offer = $this->find_on_offer($data);
            
            $BasketItem = new BasketItem($sku, $this->supermarket_name, $item_name, $price, $on_offer);
        } else {
            $BasketItem = new BasketItem(0, $this->supermarket_name, "Item Not Found", "0.00", "no");
        }
        return $BasketItem;
    } 
    
    /**
     * Finds and returns the SKU
     * 
     * @return string
     */
    private function find_sku(){
       return $this->uid;
    }
    
    /**
     * Finds and returns the Item name
     * 
     * @param string $raw - Raw HTML
     * @return string
     */
    private function find_item_name($raw){
        libxml_use_internal_errors(true);
        $doc = new DOMDocument;
        $doc->loadHTML($raw);
        $xpath = new DOMXPath($doc);
        return $xpath->query('//strong [@itemprop="name"]')->item(0)->nodeValue;
    }
    
    /**
     * Finds and returns the Price
     * 
     * @param string $raw - Raw HTML
     * @return string
     */
    private function find_price($raw){
        libxml_use_internal_errors(true);
        $doc = new DOMDocument;
        $doc->loadHTML($raw);
        $xpath = new DOMXPath($doc);
        return $xpath->query('//meta [@itemprop="price"]/@content')->item(0)->value;
    }
    
    /**
     * Finds and returns Whether the item is on offer
     * 
     * @param string $raw - Raw HTML
     * @return string
     */
    private function find_on_offer($raw){
        libxml_use_internal_errors(true);
        $doc = new DOMDocument;
        $doc->loadHTML($raw);
        $xpath = new DOMXPath($doc);
        $result = @$xpath->query('//p [@class="onOffer"]/a')->item(0);
        if($result !== null){
            return "yes";
        }else{
            return "no";
        }
    }
    
}

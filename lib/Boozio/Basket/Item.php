<?php
/**
 * Boozio
 * 
 * Inspired by Finding a Good Deal at the Supermarkets
 * This Software has no affiliation with any Supermarkets.
 * 
 * @author Ciaran Synnott 
 * @package Boozio
 * @subpackage Basket
 * 
 * Creates a Basket Item for the Product ID
 * 
 */

namespace Boozio\Basket;

use SimpleXMLElement;

class Item {

    private $sku;
    private $supermarket;
    private $item_name;
    private $price;
    private $on_offer;


    public function __construct($sku, $supermarket, $item_name, $price, $on_offer) {
        $this->sku = $sku;
        $this->supermarket = $supermarket;
        $this->item_name = $item_name;
        $this->price = $price;
        $this->on_offer = $on_offer;
    }
   
    /**
     * Gets SKU Number of Item
     * 
     * @return string SKU
     */
    public function get_sku() {
        return $this->sku;
    }
    
    /**
     * Get Supermarket Name
     * 
     * @return string Supermarket Name
     */
    public function get_supermarket() {
        return $this->supermarket;
    }
    
    /**
     * Get Item Name
     * 
     * @return string Item Name
     */
    public function get_item_name() {
        return $this->item_name;
    }
    
    /**
     * Get Price
     * 
     * @return string Price
     */
    public function get_price() {
        return number_format((float) str_replace('£', '', $this->price), 2, '.', '');
    }
    
    /**
     * Get whether the Item is on Offer
     * 
     * @return string On Offer Details
     */
    public function get_on_offer() {
        return $this->on_offer;
    }
    
    /**
     * Get Basket info as a JSON string
     * 
     * @return string JSON string
     */
    public function toJSON() {
        return json_encode((object) $this->toArray());
    }
    
    /**
     * Get Basket info as a Array
     * 
     * @return array 
     */
    public function toArray() {
        return array(
            "sku" => $this->get_sku(),
            "supermarket" => $this->get_supermarket(),
            "item_name" => $this->get_item_name(),
            "price" => $this->get_price(),
            "on_offer" => $this->get_on_offer()
        );
    }
    
    /**
     * Get Basket info as a XML object
     * 
     * @return xml
     */
    public function toXML() {
        $_arr = array_flip($this->toArray());
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($_arr, array($xml, 'addChild'));
        return $xml->asXML();
    }

}

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
 * Class for Scrapping the Supermarket ASDA
 * 
 */

namespace Boozio\Supermarkets;

use Boozio\Basket\Item as BasketItem;
use Boozio\CUrl\CUrl as CUrl;
use Boozio\Supermarkets\SupermarketBase as Supermarket;

class Asda extends Supermarket {

    public function __construct() {
        $this->url = "http://groceries.asda.com/api/items/view?&itemid=";
        $this->supermarket_name = "ASDA/Wallmart";
    }

    /**
     * Main function to be called to fetch an Item
     * 
     * @param int $uid Unique Item ID
     * @return BasketItem - returns a Basket Item; 
     */
    public function fetch($uid) {
        $this->uid = $uid;
        return $this->extract(new CUrl($this->url . $this->uid));
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

            $data = json_decode($CUrl->get_response());

            $sku = $this->find_sku($data);
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
     * @param object $raw - Raw Object
     * @return string
     */
    private function find_sku($raw) {
        return $raw->items[0]->deptId;
    }

    /**
     * Finds and returns the Item name
     * 
     * @param object $raw - Raw Object
     * @return string
     */
    private function find_item_name($raw) {
        return $raw->items[0]->brandName . " " . $raw->items[0]->name . " (" . $raw->items[0]->weight . ")";
    }
    
    /**
     * Finds and returns the price
     * 
     * @param object $raw - Raw Object
     * @return string
     */
    private function find_price($raw) {
        return $raw->items[0]->price;
    }
    
    /**
     * Finds and returns Whether the item is on offer
     * 
     * @param object $raw - Raw Object
     * @return string
     */
    private function find_on_offer($raw) {
        if (!empty($raw->items[0]->wasPrice)) {
            return "yes";
        } else {
            return "no";
        }
    }

}

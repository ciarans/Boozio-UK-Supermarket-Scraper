<?php
require 'lib/autoload.php';


$asda = new Boozio\Supermarkets\Asda();
$tesco = new Boozio\Supermarkets\Tesco();
$waitrose = new Boozio\Supermarkets\Waitrose();
$morrisons = new Boozio\Supermarkets\Morrisons();

$item = $morrisons->fetch(210564011);

echo "SKU: ".$item->get_sku()."\n";
echo "Supermarket: ".$item->get_supermarket()."\n";
echo "Item Name: ".$item->get_item_name()."\n";
echo "Price: ".$item->get_price()."\n";
echo "On Offer: ".$item->get_on_offer()."\n";
echo "To JSON: ".$item->toJSON()."\n";
echo "To XML: \n";
print_r($item->toXML());
echo "To Array: \n";
print_r($item->toArray());
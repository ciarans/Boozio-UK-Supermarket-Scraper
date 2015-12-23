# Boozio
Boozio Price Matcher for Booze (Or anything) by Scrapping UK Supermarkets - Supports Asda, Tesco, Waitrose and Morrisons

## Installation

Click the `download` link above or `git clone git://github.com/ciarans/boozio.git`

## Usage

### Getting Started

Simply Require the autoload file and then pull in what Supermarkets you are looking for.

  ```php
  require_once 'lib/autoload.php';
  $asda = new Boozio\Supermarkets\Asda();
  $tesco = new Boozio\Supermarkets\Tesco();
  $waitrose = new Boozio\Supermarkets\Waitrose();
  $morrisons = new Boozio\Supermarkets\Morrisons();
  ```
  
You can pull in as many or as little supermarkets as you like. 

### Performing a Request

All you need is the unique ID the supermarkets use for each product and pass it to the ````fetch()``` command

  ```php
  $morrions_bombat_saphire_gin_1_litre = 210564011;
  $item = $morrisons->fetch($morrions_bombat_saphire_gin_1_litre);
  ```
````$item``` will then contain a Basket Item Object.

### The Basket Item Object

Once you have a Basket Object you can run the following  commands to get the data

  ```php
	echo "SKU: ".$item->get_sku()."\n";
	echo "Supermarket: ".$item->get_supermarket()."\n";
	echo "Item Name: ".$item->get_item_name()."\n";
	echo "Price: ".$item->get_price()."\n";
	echo "On Offer: ".$item->get_on_offer()."\n";
	echo "To JSON: ".$item->toJSON()."\n";
	echo "To XML: \n".$item->toXML()."\n";
	echo "To Array: \n";
	print_r($item->toArray());
  ```

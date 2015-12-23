# Boozio - Alcohol Price Scrapper
Boozio is a Price Matcher for Booze (Or anything) by Scrapping UK Supermarkets - Supports Asda, Tesco, Waitrose, Ocado and Morrisons.
This is not affiliated with any Supermarkets.

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
  $ocado = new Boozio\Supermarkets\Ocado();
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
	echo "Supermarket:\t".$item->get_supermarket()."\n";
	echo "Item Name:\t".$item->get_item_name()."\n";
	echo "Price:\t".$item->get_price()."\n";
	echo "On Offer:\t".$item->get_on_offer()."\n";
	echo "To JSON:\t".$item->toJSON()."\n\n";
	echo "To XML:\t\n\n".$item->toXML()."\n";
	echo "To Array:\t\n\n";
	print_r($item->toArray());
  ```
This will give you the following output;

```
	SKU: 210564011
	Supermarket:	Morrisons
	Item Name:	Kronenbourg 1664 Bottles 
	Price:	7.00
	On Offer:	no
	To JSON:	{"sku":210564011,"supermarket":"Morrisons","item_name":"Kronenbourg 1664 Bottles ","price":"7.00","on_offer":"no"}
	
	To XML:	
	
	<?xml version="1.0"?>
	<root><sku>210564011</sku><supermarket>Morrisons</supermarket><item_name>Kronenbourg 1664 Bottles </item_name><price>7.00</price><on_offer>no</on_offer></root>
	
	To Array:	
	
	Array
	(
	    [sku] => 210564011
	    [supermarket] => Morrisons
	    [item_name] => Kronenbourg 1664 Bottles 
	    [price] => 7.00
	    [on_offer] => no
	)
```
  
## Full Example

  ```php
	require 'lib/autoload.php';
	
	$asda = new Boozio\Supermarkets\Asda();
	$tesco = new Boozio\Supermarkets\Tesco();
	$waitrose = new Boozio\Supermarkets\Waitrose();
	$morrisons = new Boozio\Supermarkets\Morrisons();
	
	$morrions_bombat_saphire_gin_1_litre = 210564011;
	
	$item = $morrisons->fetch($morrions_bombat_saphire_gin_1_litre);
	
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
## Where is Sainsburys?

Oh Sainsburys! They use JSP on there Server side and have a funny redirect when setting a Cookie so actually getting the data means have a more advance CUrl Class that implements a Cookie Jar. Hopefully, this will be V2.

## Contact

If you have any questions  feel free to email me - hello@synnott.co.uk

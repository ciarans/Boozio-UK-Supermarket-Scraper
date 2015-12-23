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

  

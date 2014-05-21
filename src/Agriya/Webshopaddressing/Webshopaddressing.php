<?php namespace Agriya\Webshopaddressing;
use Agriya\Webshopaddressing\AddressingService;
use Agriya\Webshopaddressing\AddressesCountriesService;
use Agriya\Webshopaddressing\BillingAddressService;

class Webshopaddressing {

	public static function greeting(){
		return "What up dawg";
	}


	public static function Addressing()
	{

		return new AddressingService();
	}

	public static function AddressingCountry()
	{

		return new AddressesCountriesService();
	}

	public static function BillingAddress()
	{

		return new BillingAddressService();
	}
}
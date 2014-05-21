<?php namespace Agriya\Webshopaddressing;

class BillingAddress extends \Eloquent
{
	protected $table = "billing_address";
	public $timestamps = false;
	protected $primarykey = 'id';
	protected $table_fields = array("id","order_id","address_id", "billing_address_id", "user_id");
	protected $fillable = array("id","order_id","address_id", "billing_address_id", "user_id");
}
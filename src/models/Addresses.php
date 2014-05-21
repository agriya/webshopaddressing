<?php namespace Agriya\Webshopaddressing;

class Addresses extends \Eloquent
{
    protected $table = "addresses";
    public $timestamps = false;
    protected $primarykey = 'id';
    protected $table_fields = array("id", "user_id", "address_line1", "address_line2", "street", "city", "state", "country", "country_id", "address_type");
    protected $fillable = array("id", "user_id", "address_line1", "address_line2", "street", "city", "state", "country", "country_id", "address_type");

}
<?php namespace Agriya\Webshopaddressing;

Use Exception;
class MissingBilingAddressParamsExecption extends Exception {}

class BillingAddressService
{

	public function addBillingAddress($inputs = array())
	{

		try
		{
			//Throw exceptions if inputs are wrong
			if(is_null($inputs) || !is_array($inputs))
				throw new MissingBilingAddressParamsExecption('The input array can not be empty. ');

			if(!isset($inputs['address_id']) || empty($inputs['address_id']))
				throw new MissingBilingAddressParamsExecption('address_id cant be empty. ');

			$address_det = Webshopaddressing::Addressing()->getAddresses(array('id'=>$inputs['address_id']), 'first');

			if(!$address_det || !$address_det->user_id)
				throw new MissingBilingAddressParamsExecption('Given address id is not valid. ');

			$user_id = $address_det->user_id;
			$inputs['user_id'] = $user_id;

			if(!isset($inputs['billing_address_id']))
			{
				$inputs['billing_address_id'] = $inputs['address_id'];
			}
			else
			{
				$billing_address_det = Webshopaddressing::Addressing()->getAddresses(array('id'=>$inputs['address_id']), 'first');
				if(!$billing_address_det)
					throw new MissingBilingAddressParamsExecption('Given billing address id is not valid. ');
			}



			$rules = array(
				'user_id' 				=> 'required|numeric',
				'order_id'				=> 'required|numeric',
				'address_id' 			=> 'required|numeric',
				'billing_address_id' 	=> 'required|numeric',
			);
			$valid_keys = array(
				'user_id' 				=> '',
				'order_id'				=> '',
				'address_id' 			=> '',
				'billing_address_id'	=> '',
			);
			
			$inputs = array_intersect_key($inputs, $valid_keys);
			$inputs = $inputs+$valid_keys;
			
			
			//echo "<pre>";print_r($inputs);echo "</pre>";exit;
			$validator = \Validator::make($inputs,$rules);
			if($validator->passes())
			{
				$insertbilingaddress = BillingAddress::create($inputs);
				return $insertbilingaddress->id;
			}
			else
				throw new MissingBilingAddressParamsExecption($validator->messages()->first());
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}

	}

	public function getBillingAddress($options = array(), $return_type = 'all')
	{
		try
		{
			//Throw exceptions if inputs are wrong
			if(!is_array($options) || empty($options))
				throw new MissingBilingAddressParamsExecption('Options array should not be empty');
			

			if(is_array($options) && !empty($options) && (!isset($options['id']) && !isset($options['order_id'])))
				throw new MissingBilingAddressParamsExecption('Options array should have either \'id\' or \'order_id\' to get the address list. ');

			if(is_null($return_type)){$return_type = 'all';}
			if(!in_array($return_type, array('all', 'first')))
				throw new MissingBilingAddressParamsExecption('Return type can be either \'all\' or \'first\'. ');


			//Create model object for address
			$address = BillingAddress::orderby('id','asc');
			
			

			//Conditions based on input
			if(isset($options['id']) && $options['id'] > 0)
				$address->where('id','=',$options['id']);
			if(isset($options['order_id']) && $options['order_id'] !='')
				$address->where('order_id','like',$options['order_id']);

			//Check the return type and get hte list
			if($return_type == 'first')
				$addresslist = $address->first();
			else
				$addresslist = $address->get();

			//Return the list
			if(count($addresslist) > 0)
				return $addresslist;
			else
				return false;
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

}
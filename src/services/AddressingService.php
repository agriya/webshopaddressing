<?php namespace Agriya\Webshopaddressing;

Use Exception;
class MissingAddressingParamsExecption extends Exception {}

class AddressingService
{
	public function addAddresses($inputs = array())
	{

		try
		{
			//Throw exceptions if inputs are wrong
			if(is_null($inputs) || !is_array($inputs))
				throw new MissingAddressingParamsExecption('The input array can not be empty. ');

			$rules = array(
				'user_id' 		=> 'required|numeric',
				'city'			=> 'required',
				'state' 		=> 'required',
				'country'		=> 'required',
				'country_id'	=> 'required'
			);
			$valid_keys = array(
				'user_id' 			=> '',
				'address_line1'		=> '',
				'address_line2'		=> '',
				'street'			=> '',
				'city'	 			=> '',
				'state'			 	=> '',
				'country'			=> '',
				'country_id' 		=> '',
				'address_type'		=> 'shipping',
			);
			$inputs = array_intersect_key($inputs, $valid_keys);
			$inputs = $inputs+$valid_keys;
			

			$validator = \Validator::make($inputs,$rules);
			if($validator->passes())
			{
				$address = Addresses::create($inputs);
				return $address->id;
			}
			else
			{
				throw new MissingAddressingParamsExecption($validator->messages()->first());
			}
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}

	}

	public function getAddresses($options = array(), $return_type = 'all')
	{
		try
		{
			//Throw exceptions if inputs are wrong
			if(is_null($options) || !is_array($options) || (is_array($options) && (!isset($options['id']) && !isset($options['user_id']))))
				throw new MissingAddressingParamsExecption('The options can not be empty. Options array should have either \'id\' or \'user_id\' to get the address list. ');

			if(is_null($return_type)){$return_type = 'all';}
			if(!in_array($return_type, array('all','list', 'first')))
				throw new MissingAddressingParamsExecption('Return type can be either \'all\' or \'list\' or \'first\'. ');


			//Create model object for address
			$address = Addresses::orderby('id','asc');

			//Conditions based on input
			if(isset($options['id']) && $options['id'] > 0)
				$address->where('id','=',$options['id']);
			if(isset($options['user_id']) && $options['user_id'] > 0)
				$address->where('user_id','=',$options['user_id']);

			//Check the return type and get hte list
			if($return_type == 'list')
				$addresslist = $address->lists('tax_name','id');
			elseif($return_type == 'first')
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


	public function updateAddress($id = null, $inputs = array())
	{
		try
		{
			//Throw exceptions if inputs are wrong
			if(is_null($id))
				throw new MissingAddressingParamsExecption('The address id can not be null.');

			$address_det = $this->getAddresses(array('id' => $id), 'first');
			if(!$address_det)
				throw new MissingAddressingParamsExecption('Given address id is not present or may be deleted.');

			$user_id = $address_det->user_id;
			if(!$user_id)
				throw new MissingAddressingParamsExecption('Something went wrong with the details of the given address.');



			$rules = array(
				'city'			=> 'sometimes|required',
				'state' 		=> 'sometimes|required',
				'country'		=> 'sometimes|required',
				'country_id'	=> 'sometimes|required'
			);
			$valid_keys = array(
				'address_line1'		=> '',
				'address_line2'		=> '',
				'street'			=> '',
				'city'	 			=> '',
				'state'			 	=> '',
				'country'			=> '',
				'country_id' 		=> '',
			);
			$inputs = array_intersect_key($inputs, $valid_keys);
			
			$validator = \Validator::make($inputs,$rules);
			if($validator->passes())
			{
				$affectedRows = Addresses::where('id', '=', $id)->update($inputs);
				return $affectedRows;
			}
			else
			{
				throw new MissingAddressingParamsExecption($validator->messages()->first());
			}
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}

	}

	public function deleteAddress($id = null, $inputs = array())
	{
		try
		{
			//Throw exceptions if inputs are wrong
			if(is_null($id))
				throw new MissingAddressingParamsExecption('The address id can not be null.');

			$address_det = $this->getAddresses(array('id' => $id), 'first');
			if(!$address_det)
				throw new MissingAddressingParamsExecption('Given address id is not present or may be deleted.');


			$affectedRows = Addresses::where('id', '=', $id)->delete();
			return $affectedRows;
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}

	}

	

}
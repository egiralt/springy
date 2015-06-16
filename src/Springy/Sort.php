<?php

namespace Springy;

use Springy\DSL\Sort\SortParameter;

class Sort extends BaseCommand
{
	const SORT_ORDER_ASC 	= 'asc';
	const SORT_ORDER_DESC 	= 'desc';
	
	const SORT_MODE_MIN 	= 'min';
	const SORT_MODE_MAX		= 'max';
	const SORT_MODE_SUM		= 'sum';
	const SORT_MODE_AVG		= 'avg';
	
	protected $_parameters;
	
	public function __construct($parameters) 
	{
		parent::__construct();
		
		$this->_parameters = array();
		// Agrega la lista de parámetros enviados al constructor
		foreach ($parameters as $parameter)
			$this->_parameters[] = $parameter;
	}

	public function toStdClass()
	{
		$result = array();
		
		foreach ($this->_parameters as $field)
		{
			//print_r ($field); die();
			if ($field instanceof SortParameter)
				$result[] = $field->toStdClass();
		}
		
		return $result;
	}
}
<?php

namespace Springy\DSL\Sort\Filters;

use Springy\DSL\Sort\Filter;

class RangeFilter extends Filter
{
	protected $_fieldName;
	protected $_min;
	protected $_max;
	
	public function __construct($fieldName, $min = null, $max = null)
	{
		if (empty($fieldName))			//TODO: Refactorizar usando PHPUnit o Assert
			throw new \Exception('Se requiere un nombre de campo');
		
		$this->_fieldName = $fieldName;
		$this->_min = $min;
		$this->_max = $max;
	}
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->range = new \stdClass();
		$result->range->{$this->_fieldName} = new \stdClass();
		
		if ($this->_min !== null)
			$result->range->{$this->_fieldName}->lt = $this->_min;

		if ($this->_max !== null)
			$result->range->{$this->_fieldName}->gte = $this->_max;
				
		return $result;
	}
	
}
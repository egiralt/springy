<?php

namespace Springy\DSL\Sort\Filters;

use Springy\DSL\Sort\Filter;

class TermFilter extends Filter
{
	protected $_term;
	protected $_value;
	
	public function __construct($term, $value)
	{
		$this->_term = $term;
		$this->_value = $value;		
	}
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->term = new \stdClass();
		$result->term->{$this->_term} = $this->_value;
		
		return $result;
	}
	
}
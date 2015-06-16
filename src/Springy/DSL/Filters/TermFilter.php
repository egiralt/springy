<?php

namespace Springy\DSL\Filters;

use Assert\Assertion;
class TermFilter extends BaseDSLFilterCommand
{
	/**
	 * 
	 * @var \Springy\DSL\Queries\Term
	 */
	protected $_termQuery;
	
	public function __construct($query)
	{
		Assertion::notNull($query);
		
		$this->_termQuery = $query;
	} 
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->filter = $this->_termQuery->toStdClass();
		
		return $result;
	}
}
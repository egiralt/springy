<?php

namespace Springy\DSL\Queries;

use Assert\Assertion;

class Terms extends BaseTerm
{

	protected $_minimum_should_match;
	
	public function __construct($fieldName, $values)
	{
		Assertion::isArray($values);
		Assertion::notEmpty($values);
		
		parent::__construct($fieldName, $values);
	}
	
	/**
	 * 
	 * @param int $minimumShouldMatch
	 * @return \Springy\DSL\Terms
	 */
	public function setMinimumShouldMatch ($minimumShouldMatch)
	{
		Assertion::integer($minimumShouldMatch);
		
		$this->_minimum_should_match = $minimumShouldMatch;
		
		return $this;
	}
	
	protected function setValue(&$result)
	{
		$result->{$this->_fieldName} = $this->_value;
		
		return $this;
	}
	
	protected function getCommandName()
	{
		return 'terms';
	}
	
	public function toStdClass()
	{
		$command = $this->getCommandName();
		
		$result = new \stdClass();
		$result->$command = new \stdClass();
		
		if (!empty($this->_minimum_should_match))
			$result->$command->minimum_should_match = $this->_minimum_should_match;
		
		$this->setValue ($result->$command);
		
		return $result;
	}
}

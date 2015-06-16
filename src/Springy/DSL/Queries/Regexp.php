<?php

namespace Springy\DSL\Queries;

use Assert\Assertion;

class Regexp extends Term
{

	protected $_flags;
	protected $_max_determinized_states;
	
	/**
	 * @see \Springy\DSL\Term::getCommandName()
	 */
	protected function getCommandName()
	{
		return 'regexp';
	}
	
	public function setFlags ($flags)
	{
		Assertion::notEmpty($flags);
		
		$this->_flags = $flags;
		
		return $this;
	}
	
	public function setMaxDeterminizedStates ($value)
	{
		Assertion::integer($value);
		
		$this->_max_determinized_states = $value;
		
		return $this;
	}
	
	public function toStdClass()
	{
		$result = parent::toStdClass(); // El resultado que se debería volver
		$command = $this->getCommandName(); // Este comando
		
		// Y ahora tomar el campo donde deben insertarse el resto de opciones
		$field = $this->setValue($result->$command);
		
		if (!empty($this->_flags))
			$field->flags = $this->_flags;
		
		if (!empty($this->_max_determinized_states))
			$field->max_determinized_states = $this->_max_determinized_states;
		
		return $result;
	}
	
}

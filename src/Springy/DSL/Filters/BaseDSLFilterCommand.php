<?php

namespace Springy\DSL\Filters;

use Springy\DSL\BaseDSLCommand;
use Assert\Assertion;

abstract class BaseDSLFilterCommand extends BaseDSLCommand
{
	
	protected $_caching;
	
	/**
	 * Modifica el valor de caching para este comando
	 * 
	 * @param bool $value
	 * @return \Springy\DSL\Filters\BaseDSLFilterCommand
	 */
	public function setCaching ($value)
	{
		Assertion::boolean($value);
		
		$this->_caching = $value;
		
		return $this;
	}

}
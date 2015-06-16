<?php

namespace Springy\DSL\Queries;

use Springy\DSL\BaseDSLCommand;

abstract class BaseTerm extends BaseDSLCommand
{

	protected $_fieldName;
	protected $_value;
	
	public function __construct ($fieldName, $value)
	{
		if (empty($fieldName))
			throw new \Exception("Se requiere un nombre de campo");
		
		$this->_fieldName = $fieldName;
		$this->_value = $value;	
	}
	
	protected function setValue (&$result)
	{
		// No se hace nada aquí
	}
	
	abstract protected function getCommandName ();
	
	protected function getValueFieldName()
	{
		return 'value';
	} 
	
		
}
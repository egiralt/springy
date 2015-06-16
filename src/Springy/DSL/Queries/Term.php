<?php

namespace Springy\DSL\Queries;

class Term extends BaseTerm
{

	protected $_boost;
	
	public function __construct ($fieldName, $value, $boost = NULL)
	{
		parent::__construct($fieldName, $value);
		
		$this->_boost = $boost;
	}
	
	public function setValue(&$result)
	{
		if (empty($result->{$this->_fieldName}))
			$field = $result->{$this->_fieldName} = new \stdClass();
		else
			$field = $result->{$this->_fieldName};			
		
		$valueFieldName = $this->getValueFieldName();// Se usa el nombre actual del campo del valor
		$field->$valueFieldName = $this->_value;
			
		return $field;
	}
	
	protected function getCommandName()
	{
		return 'term';
	}
	
	public function toStdClass()
	{
		$command = $this->getCommandName();
		
		$result = new \stdClass();
		$result->$command = new \stdClass();
		
		$fieldValue = $this->setValue( $result->$command);
		  
		if (!empty($this->_boost))
			$fieldValue->boost = $this->_boost; // el boost se le pone al campo en específico
		
		return $result;
	}
	
}
<?php

namespace Springy\DSL\Sort;

use Springy\IClassable;

/**
 * Parámetros básicos para el ordenamiento de los resultados de una consulta
 *
 */
class SortParameter implements IClassable
{
	
	protected $_name;
	protected $_order;
	protected $_mode;
	protected $_nestedFilter;
	protected $_nestedPath;
	
	public function __construct($name, $order = NULL, $mode = NULL, $nestedPath = null, Filter $nestedFilter = null)
	{
		$this->_name = $name;
		$this->_mode = $mode;
		$this->_order = $order;
		$this->_nestedFilter = $nestedFilter;
		$this->_nestedPath = $nestedPath;
	}
	
	/**
	 * 
	 * @param string $nestedFieldName
	 * @throws \Exception
	 */
	public function setNestedPath ($nestedFieldName)
	{
		if (empty($nestedFieldName))
			throw new \Exception();
		
		$this->_nestedPath = $nestedFieldName;
	}
	
	/**
	 * 
	 * @param Filter $filter
	 * @throws \Exception
	 */
	public function setNestedFilter (Filter $filter)
	{
		if (empty($filter))
			throw new \Exception();
		
		$this->_nestedFilter = $filter;
	}

	/**
	 * 
	 * @return Ambigous <string, \stdClass>
	 */
	public function toStdClass()
	{
		$result = NULL;
		
		if ($this->_order !== NULL || $this->_mode !== NULL || !empty($this->_nested))
		{
			$result = new \stdClass();
			$result->{$this->_name} = new \stdClass();
			
			// Agregar el tipo de ordenamiento
			if ($this->_order !== NULL)
				$result->{$this->_name}->order = $this->_order;
			// Agregar el modo
			if ($this->_mode !== NULL)
				$result->{$this->_name}->mode = $this->_mode;
			
			if ($this->_nestedFilter)
				$result->{$this->_name}->nested_filter = $this->_nestedFilter->toStdClass();
		}
		else
			$result = $this->_name;
		
		return $result;
	}
}
<?php
/**
 *  Springy Query Framework for ElasticSearch
 *  Copyright (C) 2015, by Ernesto Giralt (egiralt@gmail.com)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 **/

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
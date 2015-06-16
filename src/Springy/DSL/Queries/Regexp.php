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

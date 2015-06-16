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

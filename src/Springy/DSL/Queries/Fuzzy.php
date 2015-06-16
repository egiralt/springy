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

class Fuzzy extends BaseTerm
{
	protected $_max_expansions;
	protected $_prefix_length;
	protected $_fuzziness;
	protected $_boost;
	
	public function __construct($field, $value, $fuzziness = null)
	{
		parent::__construct($field, $value);

		if (!empty($fuzziness))
			$this->setFuzziness($fuzziness);
	}		
	
	/**
	 * Cambia el valor del parámetro fuzziness
	 *
	 * @param string $fuzziness
	 * @return \ElasticCode\Match
	 */
	public function setFuzziness ($fuzziness)
	{
		Assertion::notEmpty($fuzziness);
		$this->_fuzziness = $fuzziness;
	
		return $this;
	}
	
	/**
	 * Cambia el valor del parámetro prefix_length
	 *
	 * @param int $prefix_length
	 * @return \ElasticCode\Match
	 */
	public function setPrefixLength ($prefix_length)
	{
		Assertion::integer($prefix_length);
		$this->_prefix_length = $prefix_length;
	
		return $this;
	}
	
	/**
	 * Cambia el valor del parámetro max_expansions
	 *
	 * @param unknown $max_expansions
	 * @return \ElasticCode\Match
	 */
	public function setMaxExpansions  ($max_expansions)
	{
		Assertion::integer($max_expansions);
		$this->_max_expansions = $max_expansions;
	
		return $this;
	}
	
	protected function setValue(&$result)
	{
		$field = $result->{$this->_fieldName} = new \stdClass(); 
		$field->query= $this->_value;
		
		return $field;
	}
	
	protected function getCommandName()
	{
		return 'fuzzy';
	}
	
	/**
	 * @see \Springy\BaseCommand::toStdClass()
	 */
	public function toStdClass()
	{
		$command = $this->getCommandName();
		
		$result = new \stdClass();
		$result->$command = new \stdClass();
	
		$field = $this->setValue($result->$command);
	
		if (!empty($this->_fuzziness))
			$field->fuzziness = $this->_fuzziness;
	
		if (!empty($this->_max_expansions))
			$field->max_expansions = $this->_max_expansions;
	
		if (!empty($this->_prefix_length))
			$field->prefix_length = $this->_prefix_length;
	
		return $result;
	}
	
	
}

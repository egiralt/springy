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

namespace Springy\DSL\Sort\Filters;

use Springy\DSL\Sort\Filter;

class RangeFilter extends Filter
{
	protected $_fieldName;
	protected $_min;
	protected $_max;
	
	public function __construct($fieldName, $min = null, $max = null)
	{
		if (empty($fieldName))			//TODO: Refactorizar usando PHPUnit o Assert
			throw new \Exception('Se requiere un nombre de campo');
		
		$this->_fieldName = $fieldName;
		$this->_min = $min;
		$this->_max = $max;
	}
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->range = new \stdClass();
		$result->range->{$this->_fieldName} = new \stdClass();
		
		if ($this->_min !== null)
			$result->range->{$this->_fieldName}->lt = $this->_min;

		if ($this->_max !== null)
			$result->range->{$this->_fieldName}->gte = $this->_max;
				
		return $result;
	}
	
}
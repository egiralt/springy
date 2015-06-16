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

class TermFilter extends Filter
{
	protected $_term;
	protected $_value;
	
	public function __construct($term, $value)
	{
		$this->_term = $term;
		$this->_value = $value;		
	}
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->term = new \stdClass();
		$result->term->{$this->_term} = $this->_value;
		
		return $result;
	}
	
}
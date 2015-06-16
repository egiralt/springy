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
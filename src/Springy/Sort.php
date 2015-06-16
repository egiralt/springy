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

namespace Springy;

use Springy\DSL\Sort\SortParameter;

class Sort extends BaseCommand
{
	const SORT_ORDER_ASC 	= 'asc';
	const SORT_ORDER_DESC 	= 'desc';
	
	const SORT_MODE_MIN 	= 'min';
	const SORT_MODE_MAX		= 'max';
	const SORT_MODE_SUM		= 'sum';
	const SORT_MODE_AVG		= 'avg';
	
	protected $_parameters;
	
	public function __construct($parameters) 
	{
		parent::__construct();
		
		$this->_parameters = array();
		// Agrega la lista de parámetros enviados al constructor
		foreach ($parameters as $parameter)
			$this->_parameters[] = $parameter;
	}

	public function toStdClass()
	{
		$result = array();
		
		foreach ($this->_parameters as $field)
		{
			//print_r ($field); die();
			if ($field instanceof SortParameter)
				$result[] = $field->toStdClass();
		}
		
		return $result;
	}
}
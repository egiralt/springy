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

use Springy\Query;
use Springy\BaseCommand;
use Springy\DSL\BaseDSLCommand;

class Bool extends BaseDSLCommand
{
	protected $_must;
	protected $_must_not;
	protected $_should;
	protected $_minimum_should_match;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_should = array();
		$this->_must = array();
		$this->_must_not = array();
	}
	
	public function must (BaseCommand $query)
	{
		Assertion::notNull($query);
		$this->_must[] = $query;
		
		return $this;
	}
	
	public function mustNot (BaseCommand $query)
	{
		Assertion::notNull($query);
		$this->_must_not[] = $query;
	
		return $this;
	}

	public function should (BaseCommand $query)
	{
		Assertion::notNull($query);
		$this->_shouldt[] = $query;
	
		return $this;
	}
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->bool = new \stdClass();
		
		$this->getQueryItems($result, $this->_must, 'must');
		$this->getQueryItems($result, $this->_must_not, 'must_not');
		$this->getQueryItems($result, $this->_should, 'should');
		
		return $result;
	}
	
	private function getQueryItems (&$result, $element, $fieldName)
	{
		if (count($element) > 0)
		{
			$result->bool->{$fieldName} = array();
				
			foreach ($element as $query)
				$result->bool->{$fieldName}[] = $query->toStdClass();
		}
	}
	
}
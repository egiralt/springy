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

class Search extends BaseCommand
{
	protected $_query;
	protected $_size;
	protected $_from;
	protected $_sourceFilter;
	protected $_sort;
	protected $_explain;
	protected $_version;
	
		/**
	 * 
	 * @param BaseCommand $query
	 * @return \Springy\DSL\ElasticCode
	 */
	public function search ($query)
	{
		$this->_query = $query;

		return $this;
	}
	
	/**
	 * Pone el parámetro "size" y opcionalmente "from"
	 * 
	 * @param int $size
	 * @param int $from
	 */
	public function setSize ($size, $from = null)
	{
		$this->_size = $size;
		
		if ($from !== NULL)
			$this->_from = $from;

		return $this;
	}

	/**
	 * Pone el parámetro "from"
	 *
	 * @param int $from
	 */
	public function setFrom ($from)
	{
		$this->_from = $from;
		
		return $this;
	}

	/**
	 * Configura el parámetro _source para la búsqueda 
	 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-source-filtering.html
	 * 
	 * @param unknown $include Parametro de inclusión de campos. Se puede poner a false, una string o un array
	 * @param string $exclude
	 * @return \Springy\DSL\ElasticCode
	 */
	public function setSourceFilter ($include = false, $exclude = NULL)
	{
		if ($include !== NULL && $exclude === NULL)
			$this->_sourceFilter = $include;				// El caso cuando solo se incluye un valor
		elseif ($include !== NULL && $exclude !== NULL)
		{	
			// Para los casos en los que se incluye los dos
			$this->_sourceFilter = new \stdClass();
			$this->_sourceFilter->include = $include;
			$this->_sourceFilter->exclude = $exclude;
		}
		elseif ($include === NULL && $exclude !== NULL)
		{
			// Para los casos en los que se incluye los dos
			$this->_sourceFilter = new \stdClass();
			$this->_sourceFilter->exclude = $exclude;
		}
		
		return $this;
	}
	
	/**
	 * Agrega un comando sort a la búsqueda
	 * Recibe una lista variable de parámetros
	 * 
	 * @return \Springy\DSL\Sort
	 */
	public function sort ()
	{
		$this->_sort = new Sort(func_get_args());

		return $this;
	}
	
	public function setExplain ()
	{
		$this->_explain = true;
	
		return $this;
	}
	
	public function setVersion ()
	{
		$this->_version = true;
	
		return $this;
	}
	
	
		
	/**
	 * @see \Springy\DSL\BaseCommand::toStdClass()
	 */
	public function toStdClass()
	{
		$result = new \stdClass();

		if ($this->_explain !== null)
			$result->explain = true;
		
		if ($this->_version !== null)
			$result->version = true;
				
		if ($this->_query !== null)
			$result = $this->_query->toStdClass();
		
		if ($this->_size !== null)
			$result->size = $this->_size;
		
		if ($this->_from !== null)
			$result->from = $this->_from;

		if ($this->_sourceFilter !== null)
			$result->_source = $this->_sourceFilter;

		if ($this->_sort !== null)
			$result->sort = $this->_sort->toStdClass();
		
		return $result;
	}
	
}
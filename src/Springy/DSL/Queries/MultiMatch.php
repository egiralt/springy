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

class MultiMatch extends Match
{
	const MULTIMATCH_QUERY_TYPE_BEST_FIELDS 		= 'best_fields';
	const MULTIMATCH_QUERY_TYPE_BEST_MOST_FIELDS 	= 'most_fields';
	const MULTIMATCH_QUERY_TYPE_BEST_CROSS_FIELDS 	= 'cross_fields';
	const MULTIMATCH_QUERY_TYPE_BEST_PHRASE 		= 'phrase';
	const MULTIMATCH_QUERY_TYPE_BEST_PHRASE_PREFIX 	= 'phrase_prefix';
	
	const MULTIMATCH_REWRITE_SCORING_BOOLEAN 		= 'scoring_boolean';  	
	const MULTIMATCH_REWRITE_CONSTANT_SCORE_BOOLEAN = 'constant_score_boolean';
	const MULTIMATCH_REWRITE_CONSTANT_SCORE_FILTER 	= 'constant_score_filter';
	const MULTIMATCH_REWRITE_TOP_TERMS_1			= 'top_terms_1';
	const MULTIMATCH_REWRITE_TOP_TERMS_2			= 'top_terms_2';
	const MULTIMATCH_REWRITE_TOP_TERMS_3			= 'top_terms_3';
	const MULTIMATCH_REWRITE_TOP_TERMS_BOOST_1		= 'top_terms_boost_1';
	const MULTIMATCH_REWRITE_TOP_TERMS_BOOST_2		= 'top_terms_boost_2';
	const MULTIMATCH_REWRITE_TOP_TERMS_BOOST_3		= 'top_terms_boost_3';
	
	protected $_tie_breaker;
	protected $_minimum_should_match;
	protected $_rewrite;
	
	public function __construct($fields, $query)
	{
		Assertion::isArray($fields);
		Assertion::notEmpty($fields);
		Assertion::notEmpty($query);
		
		$this->_value = $query;
		$this->_fieldName = $fields;
	}
	
	public function setTieBreaker ($value)
	{
		Assertion::float($value);
		$this->_tie_breaker = $value;
		
		return $this;
	}
	
	public function setMinimumShouldMatch ($value)
	{
		Assertion::integer($value);
		$this->_minimum_should_match = $value;
		
		return $this;
	} 
	
	public function setRewrite ($value)
	{
		Assertion::choice($value, 
			array(
				MULTIMATCH_REWRITE_SCORING_BOOLEAN,
				MULTIMATCH_REWRITE_CONSTANT_SCORE_BOOLEAN,
				MULTIMATCH_REWRITE_CONSTANT_SCORE_FILTER,
				MULTIMATCH_REWRITE_TOP_TERMS_1,
				MULTIMATCH_REWRITE_TOP_TERMS_2,
				MULTIMATCH_REWRITE_TOP_TERMS_3,
				MULTIMATCH_REWRITE_TOP_TERMS_BOOST_1,
				MULTIMATCH_REWRITE_TOP_TERMS_BOOST_2,
				MULTIMATCH_REWRITE_TOP_TERMS_BOOST_3
		));

		$this->_rewrite = $value;
		
		return $this;
	}
	
	public function setMatchQueryType($queryType)
	{
		Assertion::choice($queryType, 
			array (
				self::MULTIMATCH_QUERY_TYPE_BEST_CROSS_FIELDS, 
				self::MULTIMATCH_QUERY_TYPE_BEST_FIELDS, 
				self::MULTIMATCH_QUERY_TYPE_BEST_MOST_FIELDS,
				self::MULTIMATCH_QUERY_TYPE_BEST_PHRASE,
				self::MULTIMATCH_QUERY_TYPE_BEST_PHRASE_PREFIX));
		
		$this->_matchQueryType = $queryType;
		
		return $this;
	}
	
	protected function setValue(&$result)
	{
		$result->fields = $this->_fieldName;
		$result->query = $this->_value;

		return $result; // el mismo campo "match" es que se usa para poner el resto
	}
	
	protected function getCommandName()
	{
		return 'multi_match';
	}
	
	/**
	 * @see \Springy\BaseCommand::toStdClass()
	 */
	public function toStdClass()
	{
		$command = $this->getCommandName();
		$parentCommand = parent::getCommandName();
		
		$result = new \stdClass();
		
		// Ahora se utiliza el algoritmo del Match, cambiando solo el nombre del comando
		$parentResult = parent::toStdClass();
		$result->$command = $parentResult->$parentCommand;
		
		// Y el resto de campos específicos de multi_match
		if (!empty($this->_tie_breaker))
			$result->$command->tie_breaker = $this->_tie_breaker;
		
		if (!empty($this->_minimum_should_match))
			$result->$command->minimum_should_match = $this->_minimum_should_match;
		
		return $result;
	}
}
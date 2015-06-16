<?php

namespace Springy\DSL\Queries;

use Assert\Assertion;

class Match extends BaseTerm
{
	const AND_OPERATOR = 'and';
	const OR_OPERATOR = 'or';
	
	const ZERO_TERM_QUERY_ALL = 'all';
	const ZERO_TERM_QUERY_NONE = 'none';
	
	const MATCH_QUERY_TYPE_PHRASE = 'phrase';
	const MATCH_QUERY_TYPE_PHRASE_PREFIX = 'phrase_prefix';
	
	protected $_max_expansions;
	protected $_prefix_length;
	protected $_operator;
	protected $_fuzziness;
	protected $_analyzer;
	protected $_zero_terms_query;
	protected $_cutoff_frequency;
	protected $_matchQueryType;
	protected $_slop;
	
	public function __construct($field, $value, $operator = NULL)
	{
		parent::__construct($field, $value);
		
		if ($operator !== NULL)
			$this->setOperator($operator);
	}
	
	/**
	 * Cambia el valor del parámetro operator
	 *
	 * @param string $operator
	 * @return \ElasticCode\Match
	 */
	public function setOperator ($operator)
	{
		Assertion::choice($operator, array(self::AND_OPERATOR, self::OR_OPERATOR));
		$this->_operator = $operator;
	
		return $this;
	}
	
	/**
	 * @param int $value
	 */
	public function setSlop ($value)
	{
		Assertion::integer($value);
		$this->_slop = $value;
		
		return $this;		
	}

	/**
	 * Cambia el tipo de query. Se utilizan las constantes MATCH_QUERY_TYPE_xxxx
	 * 
	 * @param string $queryType
	 * @return \Springy\DSL\Match
	 */
	public function setMatchQueryType ($queryType)
	{
		Assertion::choice($queryType, array(self::MATCH_QUERY_TYPE_PHRASE, self::MATCH_QUERY_TYPE_PHRASE_PREFIX));
		$this->_matchQueryType = $queryType;
		
		return $this;
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

	/**
	 * Cambia el valor del parámetro cutoff_frequency
	 * 
	 * @param float $cutoff_frequency
	 * @return \Springy\DSL\Match
	 */
	public function setCutoffFrequency ($cutoff_frequency)
	{
		Assertion::float(cutoff_frequency);
		$this->_cutoff_frequency = $cutoff_frequency;
	
		return $this;
	}
	
	/**
	 * Cambia el valor del parámetro cutoff_frequency
	 *
	 * @param float $cutoff_frequency
	 * @return \Springy\DSL\Match
	 */
	public function setAnalyzer ($analyzer)
	{
		Assertion::notEmpty($analyzer);
		$this->_analyzer = $analyzer;
	
		return $this;
	}
	
	/**
	 * Cambia el valor del parámetro cutoff_frequency
	 *
	 * @param float $cutoff_frequency
	 * @return \Springy\DSL\Match
	 */
	public function setZeroTermsQuery ($option)
	{
		Assertion::choice($option, array(self::ZERO_TERM_QUERY_ALL, self::ZERO_TERM_QUERY_NONE));
		
		$this->_zero_terms_query = $option;
	
		return $this;
	}	
	
	protected function setValue(&$result)
	{
		$field = $result->{$this->_fieldName} = new \stdClass();
		$field->query = $this->_value;
		
		return $field;
	}
	
	protected function getCommandName()
	{
		return 'match';
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

		if (!empty($this->_operator))
			$field->operator = $this->_operator;
			
		if (!empty($this->_fuzziness))
			$field->fuzziness = $this->_fuzziness;
		
		if (!empty($this->_max_expansions))
			$field->max_expansions = $this->_max_expansions;
		
		if (!empty($this->_prefix_length))
			$field->prefix_length = $this->_prefix_length;
		
		if (!empty($this->_analyzer))
			$field->analyzer = $this->_analyzer;
		
		if (!empty($this->_zero_terms_query))
			$field->zero_terms_query = $this->_zero_terms_query;
		
		if (!empty($this->_cutoff_frequency))
			$field->cutoff_frequency = $this->_cutoff_frequency;
		
		if (!empty($this->_matchQueryType))
			$field->type = $this->_matchQueryType;
		
		if (!empty($this->_slop))
			$field->slop = $this->_slop;
						
		return $result;
	}
	
}
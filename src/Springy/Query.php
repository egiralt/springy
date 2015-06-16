<?php

namespace Springy;

use Springy\DSL\Queries as DSL;
use Assert\Assertion;

class Query extends BaseCommand
{
	protected $_queryChain;
	
	public function __construct(BaseCommand $command = null) 
	{ 
		if (!empty($command))
			$this->setQuery($command);
	}
	
	/**
	 * Asigna una consulta 
	 * 
	 * @param BaseCommand $command
	 * @return \Springy\Query
	 */
	public function setQuery (BaseCommand $command)
	{
		Assertion::notNull($command);
		
		$this->_queryChain = $command;
		
		return $this;
	}
	
	/**
	 * Retorna el comando de búsqueda actualmente puesto
	 * 
	 * @return BaseCommand
	 */
	public function getQuery ()
	{
		return $this->_queryChain;
	}
	
	/**
	 * Agrega un comando Fuzzy
	 * @param string $field
	 * @param string $value
	 * @return \Springy\DSL\Fuzzy
	 */
	static public function fuzzy ($field, $value)
	{
		Assertion::notEmpty($field);
		Assertion::notEmpty($value);
		
		$result = new DSL\Fuzzy($field, $value);
		//$this->setQuery($result);
	
		return $result;
	}
	
	/**
	 * Agrega un comando Match simple
	 * @param string $field
	 * @param string $value
	 * @return \Springy\DSL\Match
	 */
	static public function match ($field, $value)
	{
		Assertion::notEmpty($field);
		Assertion::notEmpty($value);
		
		$result = new DSL\Match($field, $value);
		//$this->setQuery($result);
	
		return $result;
	}
	
	/**
	 * Agrega un comando terms
	 * @param string $field
	 * @param string $value
	 * @return \Springy\DSL\Terms
	 */
	static public function terms ($field, $values)
	{
		Assertion::notEmpty($field);
		Assertion::isArray($values);
		Assertion::notEmpty($values);
				
		$result = new DSL\Terms($field, $values);
		//$this->setQuery($result);
	
		return $result;
	}

	/**
	 * Agrega un comando terms
	 * @param string $field
	 * @param string $value
	 * @return \Springy\DSL\MultiMatch
	 */
	static public function multiMatch ($fields, $values)
	{
		Assertion::notEmpty($field);
		Assertion::notEmpty($value);
		
		$result = new DSL\MultiMatch($fields, $values);
		//$this->setQuery($result);
	
		return $result;
	}
		
	/**
	 * Genera un comando match_all
	 *
	 * @return \Springy\DSL\MatchAll
	 */
	static public function matchAll ()
	{
		$result = new DSL\MatchAll();
	
		//$this->setQuery($result);
	
		return $result;
	}
	
	/**
	 * Genera un comando match_all
	 *
	 * @return \Springy\DSL\Bool
	 */
	static public function bool ()
	{
		$result = new DSL\Bool();
	
		//$this->setQuery($result);
	
		return $result;
	}
	
	
	/**
	 * Genera una nueva búsqueda de tipo term
	 * 
	 * @param unknown $fieldName
	 * @param unknown $value
	 * @param string $boost
	 * @return \Springy\DSL\Term
	 */
	static public function term ($fieldName, $value, $boost = null)
	{
		Assertion::notEmpty($fieldName);
		Assertion::notEmpty($value);
		
		$result = new DSL\Term($fieldName, $value, $boost);
		//$this->setQuery($result);
		
		return $result;
	}

	/**
	 * Genera una nueva búsqueda de tipo term
	 *
	 * @param unknown $fieldName
	 * @param unknown $value
	 * @param string $boost
	 * @return \Springy\DSL\Regexp
	 */
	static public function regexp ($fieldName, $expression, $boost = null)
	{
		Assertion::notEmpty($fieldName);
		Assertion::notEmpty($expression);
	
		$result = new DSL\Regexp($fieldName, $expression, $boost);
		
		return $result;
	}
	

	/**
	 * @see \Springy\DSL\BaseCommand::toStdClass()
	 */
	public function toStdClass()
	{
		$result = new \stdClass();
		
		if ($this->_queryChain !== NULL)
			$result->query = $this->_queryChain->toStdClass();
		
		return $result;
	}
	
	
}
<?php

namespace Springy\DSL\Queries;

/**
 * Implementa el comando Match_all
 * 
 * @author giralt
 */
class MatchAll extends Match
{
	
	public function __construct()
	{
	}
	
	/**
	 * @see \Springy\DSL\Match::toStdClass()
	 */
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->match_all = new \stdClass();
		
		return $result;
	}
}
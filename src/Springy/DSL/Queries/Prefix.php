<?php

namespace Springy\DSL\Queries;

class Prefix extends Term
{

	/**
	 * @see \Springy\DSL\Term::getCommandName()
	 */
	protected function getCommandName()
	{
		return 'prefix';
	}
	
}

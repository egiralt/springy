<?php

namespace Springy\DSL\Queries;

class Wildcard extends Term
{
	/**
	 * @see \Springy\DSL\Term::getCommandName()
	 */
	protected function getCommandName()
	{
		return 'wildcard';
	}
	
}

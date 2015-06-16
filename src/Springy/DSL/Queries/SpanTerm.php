<?php

namespace Springy\DSL\Queries;

class SpanTerm extends Term
{

	/**
	 * @see \Springy\DSL\Term::getCommandName()
	 */
	protected function getCommandName()
	{
		return 'span_term';
	}
	
}

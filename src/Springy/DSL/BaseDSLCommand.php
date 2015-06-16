<?php

namespace Springy\DSL;

use Springy\BaseCommand;

abstract class BaseDSLCommand extends BaseCommand
{
	
	protected function setProperty (&$target, $value, $propName)
	{
		if (!empty($value))
			$target->$propName = $value;
	}
} 
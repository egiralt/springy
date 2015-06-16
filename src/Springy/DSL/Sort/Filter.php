<?php

namespace Springy\DSL\Sort;

use Springy\IClassable;

abstract class Filter implements IClassable
{
	
	abstract public function toStdClass(); 

}

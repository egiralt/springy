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

abstract class BaseCommand implements IClassable
{
	
	public function __construct()
	{
	}

	/**
	 * Usada para crear el árbol de clases con la estructura de parámetros y 
	 */
	public abstract function toStdClass();

	/**
	 * Retorna el string JSON equivalente a la estructura de la búsqueda
	 * 
	 * @param bool $pretty Retorna una string visualmente ordenada (con espacios) o no
	 * @param int $options Lista de opciones usadas para json_encode. Se usan los siguientes valores por defecto:
	 * 	 JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_HEX_AMP | JSON_PRESERVE_ZERO_FRACTION
	 * @return string
	 */
	public function toJSON($pretty = false, $options = 0)
	{
		if ($options === 0)
			$options = JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_HEX_AMP;
		
		if ($pretty === true)
			$options |= JSON_PRETTY_PRINT ;
		
		return json_encode ($this->toStdClass(), $options);		
	}
	
	public function __toString()
	{
		return $this->toJSON();
	}
		
}
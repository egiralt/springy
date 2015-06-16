<?php

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
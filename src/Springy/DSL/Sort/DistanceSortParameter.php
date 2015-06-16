<?php

namespace Springy\DSL\Sort;

use Springy\GeoCoordinates;

/**
 * 
 */
class DistanceSortParameter extends SortParameter
{
	const DISTANCE_TYPE_SLOOPY_ARC 	= 'sloopy_arc';
	const DISTANCE_TYPE_ARC			= 'arc';
	const DISTANCE_TYPE_PLANE		= 'plane';
	
	// Esta lista fue extraída desde http://rpackages.ianhowson.com/cran/elastic/man/units-distance.html
	const UNIT_KM					= "km";
	const UNIT_MILES 				= 'mi';
	const UNIT_YARDS				= 'yd';
	const UNIT_FEETS				= 'ft';
	const UNIT_INCHES				= 'in';
	const UNIT_METERS				= 'm';
	const UNIT_CENTIMETERS			= 'cm';
	const UNIT_MILLIMITERS			= 'mm';
	const UNIT_NAUTICAL_MILES		= 'nmi';	
	
	protected $_coordinates;
	protected $_type;
	protected $_unit;
	
	/**
	 * 
	 * @param unknown $coordinates Puede ser una instancia de GeoCoordinates o un array de estas instancias
	 * @param string $unit
	 * @param string $type
	 * @param string $order
	 * @param string $mode
	 */
	public function __construct($coordinates, $unit = NULL, $type = NULL, $order = NULL, $mode = NULL)
	{
		parent::__construct(NULL, $order, $mode);
		
		if (!is_array($coordinates) && !($coordinates instanceof GeoCoordinates))
			throw new \Exception("Se ha de indicar una instancia de GeoCoordinates o un array de estos");
		
		$this->_unit = $unit;
		$this->_coordinates = $coordinates;
		$this->_type = $type;
	}
	
	/**
	 * @see \Springy\DSL\Sort\SortParameter::toStdClass()
	 */
	public function toStdClass()
	{
		$result = new \stdClass();

		$result->_geo_distance = new \stdClass();
		if ($this->_coordinates instanceof GeoCoordinates )
			// se agrega una instancia concreta de las coordenadas
			$result->_geo_distance->{"pin.location"} = $this->_coordinates->toArray();
		else 
		{
			// Se agregan la lista de coordenadas
			foreach ($this->_coordinates as $coordinate)
				$result->_geo_distance->{"pin.location"}[] = $coordinate->toStdClass();
		}
		// Resto de los parámetros
		if (!empty($this->_mode))
			$result->_geo_distance->mode = $this->_mode;
		
		if (!empty($this->_order))
			$result->_geo_distance->order = $this->_order;
		
		if (!empty($this->_unit))
			$result->_geo_distance->unit = $this->_unit;

		if (!empty($this->_type))
			$result->_geo_distance->distance_type = $this->_type;
		
		return $result;
								
	}
}
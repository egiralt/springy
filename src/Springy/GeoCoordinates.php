<?php
namespace Springy;

final class GeoCoordinates implements IClassable
{
	private $_lat;
	private $_lon;
	
	public function __construct($lat, $lon)
	{
		$this->_lat = $lat;
		$this->_lon = $lon;
	}
	
	/**
	 * Retorna las coordenadas en forma de array (lon, lat). Formato según @see http://geojson.org/
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return array ($this->_lon, $this->_lat);	
	}
	
	
	public function __toString()
	{
		return sprintf('%s,%s', $this->_lon, $this->_lat);
	}	
	
	/**
	 * Retorna un string en el formato Geohash @see https://en.wikipedia.org/wiki/Geohash
	 * Utiliza una clase tomada de Paul Dixon (paul@elphin.com). Ver cabecera de la clase
	 * 
	 * @return string
	 */
	public function getGeoHash ()
	{
		$geoHash = new \Geohash();

		return $geoHash->encode($this->_lon, $this->_lat);
	}
	
	
	public function toStdClass()
	{
		$result = new \stdClass();
		$result->lat = $this->_lat;
		$result->lon = $this->_lon;

		return $result;
	}
	
}
<?php
namespace Springy;
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
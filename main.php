<?php

include_once 'autoload.php';

use Springy\DSL\Queries\Term;
use Springy\DSL\Queries\MultiMatch;
use Springy\DSL\Sort\SortParameter;
use Springy\DSL\Sort\Filters\RangeFilter;
use Springy\DSL\Sort\DistanceSortParameter;
use Springy\Sort;
use Springy\Query;
use Springy\Search;
use Springy\GeoCoordinates;

$multiMatch = new MultiMatch(['givenName', "middleName"], 'giralt');
$multiMatch->setAnalyzer("test");
$multiMatch->setMatchQueryType(MultiMatch::MULTIMATCH_QUERY_TYPE_BEST_FIELDS);
$multiMatch->setTieBreaker(0.3);

$query = new Term("name", "ernesto");
$filter = new \Springy\DSL\Filters\TermFilter($query);

$nestedSortParameter = new SortParameter ("fullname", Sort::SORT_ORDER_ASC);
$nestedSortParameter->setNestedPath('data.color');
$nestedSortParameter->setNestedFilter(new RangeFilter('data.height', null, 200));

$bool =	new Query(Query::bool()
			->must($filter)
			->must(Query::regexp('name.first', 's.*y')
					->setFlags('INTERSECTION|COMPLEMENT|EMPTY'))
		);

$es = new Search();
$es->search($filter)
	->setSourceFilter("data.*")
	->sort ( 
			$nestedSortParameter,
			new DistanceSortParameter ( 
					new GeoCoordinates(70, -40), 
					DistanceSortParameter::UNIT_METERS)
		);

echo ($es->toJSON(true));
	

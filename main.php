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

$multiMatch = new MultiMatch(['data.givenName', "data.middleName"], 'giralt');
$multiMatch->setAnalyzer("names");
$multiMatch->setMatchQueryType(MultiMatch::MULTIMATCH_QUERY_TYPE_BEST_FIELDS);
$multiMatch->setTieBreaker(0.3);

$es = new Search();
$es->search(new Query (
	Query::bool()
		->must(
				Query::multiMatch(['data.givenName', "data.middleName"], 'giralt')
					->setAnalyzer("names")
					->setMatchQueryType(MultiMatch::MULTIMATCH_QUERY_TYPE_BEST_FIELDS)
					->setTieBreaker(0.3)			)
		->must(
				Query::regexp('data.city', 's.*y')
					->setFlags('INTERSECTION|COMPLEMENT|EMPTY'))))
	->setSourceFilter("data.*")
	->sort (new SortParameter ("givenName", Sort::SORT_ORDER_ASC)
  );

echo ($es->toJSON(true));
	

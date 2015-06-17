# springy
OOP Query Framework for ElasticSearch 

this PHP code:
```php

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
  	
```

Produces this JSON:
```json
{
    "query": {
        "bool": {
            "must": [
                {
                    "multi_match": {
                        "fields": [ "data.givenName", "data.middleName" ],
                        "query": "giralt",
                        "analyzer": "names",
                        "type": "best_fields",
                        "tie_breaker": 0.3
                    }
                },
                {
                    "regexp": {
                        "data.city": {
                            "value": "s.*y",
                            "flags": "INTERSECTION|COMPLEMENT|EMPTY"
                        }
                    }
                }
            ]
        }
    },
    "_source": "data.*",
    "sort": [
        {
            "givenName": {
                "order": "asc"
            }
        }
    ]
}
```

<?php
namespace App\Http\Queries;

use Unlu\Laravel\Api\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use Unlu\Laravel\Api\UriParser;

class PhotoQueryBuilder extends QueryBuilder
{
    public function __construct(Model $model, Request $request)
    {
        $this->orderBy = [
            [
                'column' => 'updated_at',
                'direction' => 'DESC'
            ],
        ];

        $this->limit = config('api-query-builder.limit');

        $this->excludedParameters = array_merge($this->excludedParameters, config('api-query-builder.excludedParameters'));

        $this->model = $model;

        $this->uriParser = new UriParser($request);

        $this->query = $this->model->newQuery();
    }
}
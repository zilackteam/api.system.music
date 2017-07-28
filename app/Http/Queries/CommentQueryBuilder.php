<?php
namespace App\Http\Queries;

use Unlu\Laravel\Api\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use Unlu\Laravel\Api\UriParser;

class CommentQueryBuilder extends QueryBuilder
{
    protected $postId = 1;

    public function __construct(Model $model, Request $request, $postId)
    {
        $this->orderBy = [
            [
                'column' => 'created_at',
                'direction' => 'DESC'
            ]
        ];

        $this->excludedParameters = array_merge($this->excludedParameters, config('api-query-builder.excludedParameters'));

        $this->model = $model;

        $this->uriParser = new UriParser($request);

        $this->query = $this->model->newQuery();

        $this->postId = $postId;
    }

    public function get()
    {
        $result = $this->query->where('post_id', $this->postId)->get();

        if ($this->hasAppends()) {
            $result = $this->addAppendsToModel($result);
        }

        return $result;
    }

    private function hasAppends()
    {
        return (count($this->appends) > 0);
    }

    private function addAppendsToModel($result)
    {
        $result->map(function($item) {
            $item->append($this->appends);
            return $item;
        });

        return $result;
    }
}
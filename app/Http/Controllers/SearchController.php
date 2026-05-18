<?php

namespace App\Http\Controllers;

use App\Actions\Search;
use App\DataTransferObjects\SearchDto;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\SearchResource;
use App\Interfaces\SearchInterface;

class SearchController extends Controller
{
    /**
     * API or App Search for products
     */
    public function __invoke(SearchRequest $request, SearchInterface $repository): SearchResource
    {
        $action = new Search($repository);
        $data = $action->handle(SearchDto::fromAppRequest($request));

        return new SearchResource($data);
    }
}

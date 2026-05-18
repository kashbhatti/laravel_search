<?php

namespace App\DataTransferObjects;

use App\Http\Requests\SearchRequest;

class SearchDto
{
    public function __construct(
        public string $query,
        public int $offSet,
        public ?string $sort = null,
    ) {}

    public static function fromAppRequest(SearchRequest $request): self
    {
        return new self(
            query: strtolower($request->validated('query')),
            offSet: $request->validated('offSet') ?? 0,
            sort: $request->validated('sort'),
        );
    }
}

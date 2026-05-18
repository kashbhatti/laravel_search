<?php

namespace App\Actions;

use App\DataTransferObjects\SearchDto;
use App\Interfaces\SearchInterface;

readonly class Search
{
    public function __construct(private SearchInterface $repository) {}

    public function handle(SearchDto $dto): array
    {
        return $this->repository->search(
            $dto
        );
    }
}

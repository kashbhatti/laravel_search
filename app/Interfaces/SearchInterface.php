<?php

namespace App\Interfaces;

use App\DataTransferObjects\SearchDto;

interface SearchInterface
{
    public function search(SearchDto $dto): array;
}

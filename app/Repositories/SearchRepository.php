<?php

namespace App\Repositories;

use App\DataTransferObjects\SearchDto;
use App\Enums\SortType;
use App\Interfaces\SearchInterface;
use App\Models\Product;

class SearchRepository implements SearchInterface
{
    public function search(SearchDto $dto): array
    {
        $dataQuery = Product::query()
            ->where('name', 'LIKE', '%' . $dto->query . '%')
            ->offset($dto->offSet)
            ->limit(12);

        if ($dto->sort === SortType::ASC->value) {
            $dataQuery->orderBy('price');
        } elseif ($dto->sort === SortType::DESC->value) {
            $dataQuery->orderByDesc('price');
        } else {
            $dataQuery->orderBy('id');
        }

        return $dataQuery->select('id', 'name', 'image', 'price', 'name as description')
            ->get()
            ->toArray();
    }
}

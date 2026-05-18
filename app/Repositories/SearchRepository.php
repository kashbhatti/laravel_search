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
            ->whereRaw('LOWER(name) LIKE :query', ['query' => '%'.$dto->query.'%'])
            ->offset($dto->offSet)
            ->limit(12);

        if ($dto->sort === SortType::ASC->value) {
            $dataQuery->orderBy('price');
        } elseif ($dto->sort === SortType::DESC->value) {
            $dataQuery->orderByDesc('price');
        } else {
            $dataQuery->orderBy('id');
        }

        return $dataQuery->selectRaw('id, name, image, price, name as description')->get()->toArray();
    }
}

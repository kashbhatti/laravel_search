<?php

namespace App\Enums;

enum SortType: string
{
    case ASC = 'asc';
    case DESC = 'desc';
    case RELEVANCE = 'relevance';
}

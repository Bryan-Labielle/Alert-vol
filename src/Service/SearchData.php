<?php

namespace App\Service;

use App\Entity\Category;
use DateTime;

class SearchData
{
    /**
     * @var int
     */
    public int $page = 1;

    /**
     * @var Category[]
     */
    public array $categories = [];

    /**
     * @var null|string
     */
    public ?string $search = '';
    /**
     * @var datetime|null
     */
    public ?DateTime $dateSearch;

    /**
     * @var null|string
     */
    public ?string $placeSearch;
}

<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Products;

enum ProductStatus: string
{
    case Draft = 'draft';
    case Ready = 'ready';
    case Published = 'published';
    case Archived = 'archived';
}

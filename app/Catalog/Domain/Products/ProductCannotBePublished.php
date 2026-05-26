<?php

namespace App\Catalog\Domain\Products;

use DomainException;

class ProductCannotBePublished extends DomainException
{
    /**
     * @param  list<string>  $missingAttributeCodes
     */
    public static function missingRequiredAttributes(array $missingAttributeCodes): self
    {
        return new self('Product cannot be published. Missing required attributes: '.implode(', ', $missingAttributeCodes).'.');
    }
}

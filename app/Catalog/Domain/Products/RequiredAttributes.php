<?php

namespace App\Catalog\Domain\Products;

final readonly class RequiredAttributes
{
    /**
     * @param  list<string>  $codes
     */
    private function __construct(private array $codes) {}

    /**
     * @param  list<string>  $codes
     */
    public static function fromCodes(array $codes): self
    {
        return new self(array_values(array_unique($codes)));
    }

    /**
     * @param  list<string>  $filledAttributeCodes
     * @return list<string>
     */
    public function missingFrom(array $filledAttributeCodes): array
    {
        return array_values(array_diff($this->codes, array_unique($filledAttributeCodes)));
    }

    /**
     * @return list<string>
     */
    public function all(): array
    {
        return $this->codes;
    }
}

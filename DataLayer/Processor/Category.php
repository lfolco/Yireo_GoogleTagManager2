<?php declare(strict_types=1);

namespace Yireo\GoogleTagManager2\DataLayer\Processor;

use Yireo\GoogleTagManager2\Api\Data\ProcessorInterface;

class Category implements ProcessorInterface
{
    /**
     * @inheritDoc
     */
    public function process(array $data): array
    {
        return $data;
    }
}

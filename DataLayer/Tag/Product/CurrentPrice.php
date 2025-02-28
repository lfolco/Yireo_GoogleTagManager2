<?php declare(strict_types=1);

namespace Yireo\GoogleTagManager2\DataLayer\Tag\Product;

use Magento\Framework\Exception\NoSuchEntityException;
use Yireo\GoogleTagManager2\Api\Data\TagInterface;
use Yireo\GoogleTagManager2\Util\GetCurrentProduct;
use Yireo\GoogleTagManager2\Util\PriceFormatter;

class CurrentPrice implements TagInterface
{
    private GetCurrentProduct $getCurrentProduct;
    private PriceFormatter $priceFormatter;

    /**
     * @param GetCurrentProduct $getCurrentProduct
     * @param PriceFormatter $priceFormatter
     */
    public function __construct(
        GetCurrentProduct $getCurrentProduct,
        PriceFormatter $priceFormatter
    ) {
        $this->getCurrentProduct = $getCurrentProduct;
        $this->priceFormatter = $priceFormatter;
    }

    /**
     * @return float
     * @throws NoSuchEntityException
     */
    public function get(): float
    {
        $product = $this->getCurrentProduct->get();
        return $this->priceFormatter->format((float)$product->getPrice());
    }
}

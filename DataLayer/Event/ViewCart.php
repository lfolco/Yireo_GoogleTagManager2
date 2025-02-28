<?php declare(strict_types=1);

namespace Yireo\GoogleTagManager2\DataLayer\Event;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Yireo\GoogleTagManager2\Api\Data\EventInterface;
use Yireo\GoogleTagManager2\DataLayer\Tag\Cart\CartItems;

class ViewCart implements EventInterface
{
    private CartItems $cartItems;

    /**
     * @param CartItems $cartItems
     */
    public function __construct(
        CartItems $cartItems
    ) {
        $this->cartItems = $cartItems;
    }

    /**
     * @return string[]
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function get(): array
    {
        return [
            'cacheable' => true,
            'event' => 'view_cart',
            'ecommerce' => [
                'items' => $this->cartItems->get()
            ]
        ];
    }
}

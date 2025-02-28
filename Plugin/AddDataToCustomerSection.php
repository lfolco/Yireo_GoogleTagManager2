<?php declare(strict_types=1);

/**
 * GoogleTagManager2 plugin for Magento
 *
 * @author      Yireo (https://www.yireo.com/)
 * @copyright   Copyright 2017 Yireo (https://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 */

namespace Yireo\GoogleTagManager2\Plugin;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\CustomerData\Customer as CustomerData;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Yireo\GoogleTagManager2\Api\CustomerSessionDataProviderInterface;

class AddDataToCustomerSection
{
    private CustomerSession $customerSession;
    private GroupRepositoryInterface $groupRepository;
    private CustomerSessionDataProviderInterface $customerSessionDataProvider;

    /**
     * Customer constructor.
     * @param CustomerSession $customerSession
     * @param GroupRepositoryInterface $groupRepository
     * @param CustomerSessionDataProviderInterface $customerSessionDataProvider
     */
    public function __construct(
        CustomerSession $customerSession,
        GroupRepositoryInterface $groupRepository,
        CustomerSessionDataProviderInterface $customerSessionDataProvider
    ) {
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
        $this->customerSessionDataProvider = $customerSessionDataProvider;
    }

    /**
     * @param CustomerData $subject
     * @param $result
     *
     * @return mixed
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function afterGetSectionData(CustomerData $subject, $result)
    {
        if (!is_array($result)) {
            return $result;
        }


        $gtmData = $this->getGtmData();
        $gtmOnce = $this->customerSessionDataProvider->get();
        $this->customerSessionDataProvider->clear();

        return array_merge($result, ['gtm' => $gtmData, 'gtm_events' => $gtmOnce]);
    }

    /**
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getGtmData(): array
    {
        if (!$this->customerSession->isLoggedIn()) {
            return [
                'customerLoggedIn' => 0,
                'customerId' => 0,
                'customerGroupId' => 0,
                'customerGroupCode' => 'GUEST'
            ];
        }

        $customerGroup = $this->groupRepository->getById($this->customerSession->getCustomerGroupId());
        return [
            'customerLoggedIn' => 1,
            'customerId' => $this->customerSession->getCustomerId(),
            'customerGroupId' => $customerGroup->getId(),
            'customerGroupCode' => strtoupper($customerGroup->getCode())
        ];
    }
}

<?php
/**
 *
 * @package     magento2
 * @author      Jayanka Ghosh (joy)
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        https://www.codilar.com/
 */

namespace Codilar\BannerSlider\Controller\Adminhtml\Banner;

use Codilar\BannerSlider\Api\Data\BannerInterface;
use Magento\Framework\Exception\CouldNotSaveException;

class MassDisable extends AbstractMassAction
{
    /**
     * @param \Codilar\BannerSlider\Model\ResourceModel\Banner\Collection $collection
     * @return void
     */
    protected function processCollection(\Codilar\BannerSlider\Model\ResourceModel\Banner\Collection $collection): void
    {
        $itemsSaved = 0;
        /** @var BannerInterface $item */
        foreach ($collection as $item) {
            try {
                if ($item->getIsEnabled()) {
                    $item->setIsEnabled(false);
                    $this->bannerRepository->save($item);
                    $itemsSaved++;
                }
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage(__('Error saving %1: %2', $item->getEntityId(), $e->getMessage()));
            }
        }
        $this->messageManager->addSuccessMessage(__('%1 Banner(s) disabled', $itemsSaved));
    }
}
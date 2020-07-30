<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\StoreUrlRetriever;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Cms\Model\Page;
use Magento\CmsUrlRewrite\Model\CmsPageUrlPathGenerator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\Store;
use Magento\Cms\Model\ResourceModel\Page as PageResource;
use Magento\Cms\Model\ResourceModel\Page\Collection as PageCollection;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;

class CmsPageStoreUrl implements StoreUrlInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;
    /**
     * @var CmsPageUrlPathGenerator
     */
    private $urlPathGenerator;
    /**
     * @var PageResource
     */
    private $pageResource;
    /**
     * @var PageCollectionFactory
     */
    private $pageCollectionFactory;
    /**
     * @var PageHelper
     */
    private $pageHelper;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        CmsPageUrlPathGenerator $urlPathGenerator,
        PageResource $pageResource,
        PageCollectionFactory $pageCollectionFactory,
        PageHelper $pageHelper
    ) {
        $this->pageRepository = $pageRepository;
        $this->urlPathGenerator = $urlPathGenerator;
        $this->pageResource = $pageResource;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->pageHelper = $pageHelper;
    }

    /**
     * @param int $entityId
     * @param Store $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws LocalizedException
     */
    public function getUrl(int $entityId, Store $store): string
    {
        $page = $this->pageRepository->getById($entityId);
        try {
            $storePage = $this->getPageByGlobalIdentifier((string)$page->getData('global_identifier'), $store);
        } catch (NoSuchEntityException $e) {
            $pageId = $this->pageResource->checkIdentifier($page->getIdentifier(), $store->getId());
            $storePage = $this->pageRepository->getById($pageId);
        }

        $path = $this->urlPathGenerator->getUrlPath($storePage);
        return $store->getBaseUrl() . $path;
    }

    /**
     * @param string $globalIdentifier
     * @param Store $store
     * @return Page
     * @throws NoSuchEntityException
     */
    public function getPageByGlobalIdentifier(string $globalIdentifier, Store $store): Page
    {
        if (!$globalIdentifier) {
            throw new NoSuchEntityException(__('No global identifier given'));
        }

        /** @var PageCollection $pageCollection */
        $pageCollection = $this->pageCollectionFactory->create();
        $pageCollection->addStoreFilter($store);
        $pageCollection->addFieldToFilter('global_identifier', $globalIdentifier);

        $page = $pageCollection->getFirstItem();
        if (!$page->getId()) {
            throw new NoSuchEntityException(__(
                'No Page with global identifier "%1" in store %2.',
                $globalIdentifier,
                $store->getCode()
            ));
        }
        return $page;
    }
}

<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\StoreUrlRetriever;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\CmsUrlRewrite\Model\CmsPageUrlPathGenerator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;
use Magento\Cms\Model\ResourceModel\Page as PageResource;

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

    public function __construct(
        PageRepositoryInterface $pageRepository,
        CmsPageUrlPathGenerator $urlPathGenerator,
        PageResource $pageResource
    ) {
        $this->pageRepository = $pageRepository;
        $this->urlPathGenerator = $urlPathGenerator;
        $this->pageResource = $pageResource;
    }

    /**
     * @param int $entityId
     * @param Store $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws LocalizedException
     */
    public function getUrl(int $entityId, Store $store)
    {
        $page = $this->pageRepository->getById($entityId);
        $pageId = $this->pageResource->checkIdentifier($page->getIdentifier(), $store->getId());
        $storePage = $this->pageRepository->getById($pageId);
        $path = $this->urlPathGenerator->getUrlPath($storePage);
        return $store->getBaseUrl() . $path;
    }
}

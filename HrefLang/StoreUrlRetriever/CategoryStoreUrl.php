<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\StoreUrlRetriever;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Store\Model\Store;

class CategoryStoreUrl implements StoreUrlInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var CategoryUrlPathGenerator
     */
    private $urlPathGenerator;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryUrlPathGenerator $urlPathGenerator
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->urlPathGenerator = $urlPathGenerator;
    }

    /**
     * @param int $entityId
     * @param Store $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUrl(int $entityId, Store $store): string
    {
        /** @var Category $category */
        $category = $this->categoryRepository->get($entityId, $store->getId());
        $path = $this->urlPathGenerator->getUrlPathWithSuffix($category);
        return $store->getBaseUrl() . $path;
    }
}

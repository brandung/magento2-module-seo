<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\StoreUrlRetriever;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;

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
    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryUrlPathGenerator $urlPathGenerator,
        StoreManager $storeManager
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->urlPathGenerator = $urlPathGenerator;
        $this->storeManager = $storeManager;
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
        if (!$category->getIsActive()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Category is disabled.'));
        }
        $storeGroup = $this->storeManager->getGroup($store->getGroupId());
        if (!in_array($storeGroup->getRootCategoryId(), $category->getPathIds())) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Category is not below root category.'));
        }
        $path = $this->urlPathGenerator->getUrlPathWithSuffix($category);
        return $store->getBaseUrl() . $path;
    }
}

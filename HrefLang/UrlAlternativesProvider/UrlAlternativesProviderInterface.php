<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\UrlAlternativesProvider;

use Brandung\Seo\HrefLang\Data\HrefLangAlternativeInterface;

interface UrlAlternativesProviderInterface
{
    /**
     * @return HrefLangAlternativeInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAlternatives(): array;

    /**
     * @return HrefLangAlternativeInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDefaultAlternative(): ?HrefLangAlternativeInterface;
}

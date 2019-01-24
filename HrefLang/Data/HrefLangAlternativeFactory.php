<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\Data;

use Magento\Framework\ObjectManagerInterface;

class HrefLangAlternativeFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create(string $hrefLang, string $href): HrefLangAlternativeInterface
    {
        return $this->objectManager->create(HrefLangAlternativeInterface::class, [
            'hrefLang' => $hrefLang,
            'href' => $href
        ]);
    }
}

<?php
declare(strict_types=1);

namespace Brandung\Seo\ViewModel;

use Brandung\Seo\HrefLang\Data\HrefLangAlternativeInterface;
use Brandung\Seo\HrefLang\HrefLangAlternativesGenerator;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class HrefLang implements ArgumentInterface
{
    /**
     * @var HrefLangAlternativesGenerator
     */
    private $alternativesGenerator;

    public function __construct(HrefLangAlternativesGenerator $alternativesGenerator)
    {
        $this->alternativesGenerator = $alternativesGenerator;
    }

    /**
     * @return HrefLangAlternativeInterface[]
     */
    public function getAlternatives(): array
    {
        try {
            return $this->alternativesGenerator->getAlternatives();
        } catch (NoSuchEntityException $e) {
            return (array)null;
        }
    }

    public function getDefault(): ?HrefLangAlternativeInterface
    {
        try {
            return $this->alternativesGenerator->getDefaultAlternative();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}

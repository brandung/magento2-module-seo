<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang;

use Brandung\Seo\HrefLang\Data\HrefLangAlternativeInterface;
use Brandung\Seo\HrefLang\UrlAlternativesProvider\MissingAlternativeProviderException;
use Brandung\Seo\HrefLang\UrlAlternativesProvider\UrlAlternativesProviderInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Psr\Log\LoggerInterface;

class HrefLangAlternativesGenerator
{
    /**
     * @var array
     */
    private $alternativeUrlProviders;
    /**
     * @var HttpRequest
     */
    private $request;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param HttpRequest $request
     * @param LoggerInterface $logger
     * @param UrlAlternativesProviderInterface[] $alternativeUrlProviders
     */
    public function __construct(HttpRequest $request, LoggerInterface $logger, array $alternativeUrlProviders = [])
    {
        $this->alternativeUrlProviders = $alternativeUrlProviders;
        $this->request = $request;
        $this->logger = $logger;
    }

    /**
     * @return HrefLangAlternativeInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAlternatives(): array
    {
        try {
            return $this->getUrlAlternativeProvider()->getAlternatives();
        } catch (MissingAlternativeProviderException $e) {
            $this->logger->debug('HrefLang Alternative Provider Missing', ['page_type' => $e->getMessage()]);
            return (array)null;
        }
    }

    /**
     * @return HrefLangAlternativeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDefaultAlternative(): HrefLangAlternativeInterface
    {
        return $this->alternativeUrlProviders[$this->getPageType()]->getDefaultAlternative();
    }

    private function getPageType(): string
    {
        return $this->request->getFullActionName();
    }

    /**
     * @return UrlAlternativesProviderInterface
     * @throws MissingAlternativeProviderException
     */
    private function getUrlAlternativeProvider(): UrlAlternativesProviderInterface
    {
        $pageType = $this->getPageType();
        if (false === array_key_exists($pageType, $this->alternativeUrlProviders)) {
            throw MissingAlternativeProviderException::forPageType($pageType);
        }
        return $this->alternativeUrlProviders[$pageType];
    }
}

<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\UrlAlternativesProvider;

class MissingAlternativeProviderException extends \Exception
{
    public static function forPageType(string $pageType): MissingAlternativeProviderException
    {
        return new self($pageType);
    }
}

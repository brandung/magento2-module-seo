<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\UrlAlternativesProvider;

class CmsPageUrlAlternativesProvider extends AbstractUrlAlternativesProvider
{
    public function getRequestIdFieldName(): string
    {
        return 'page_id';
    }
}

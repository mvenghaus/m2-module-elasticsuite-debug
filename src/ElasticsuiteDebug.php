<?php

declare(strict_types=1);

namespace Mvenghaus\ElasticsuiteDebug;

use Magento\Framework\App\ObjectManager;
use Smile\ElasticsuiteCatalog\Model\ResourceModel\Product\Fulltext\Collection;
use Smile\ElasticsuiteCore\Search\Adapter\Elasticsuite\Request\Mapper;
use Smile\ElasticsuiteCore\Search\RequestInterface;

class ElasticsuiteDebug
{
    public static function debugCollection(Collection $collection): void
    {
        $objectManager = ObjectManager::getInstance();
        $requestMapper = $objectManager->get(Mapper::class);

        $reflector = new \ReflectionObject($collection);
        $method = $reflector->getMethod('prepareRequest');
        $method->setAccessible(true);

        $request = $method->invoke($collection);
        $requestData = $requestMapper->buildSearchRequest($request);
        unset($requestData['_source']);

        self::render(
            $request->getIndex(),
            json_encode($requestData, JSON_PRETTY_PRINT)
        );
    }

    public static function debugRequest(RequestInterface $request): void
    {
        $objectManager = ObjectManager::getInstance();
        $requestMapper = $objectManager->get(Mapper::class);

        $requestData = $requestMapper->buildSearchRequest($request);
        unset($requestData['_source']);

        self::render(
            $request->getIndex(),
            json_encode($requestData, JSON_PRETTY_PRINT)
        );
    }

    private static function render(string $index, string $request): void
    {
        $copyText = "GET /{$index}/_search" . PHP_EOL . htmlspecialchars($request);

        echo <<<EOF
<div style="position: absolute; z-index: 99999; width: 1024px; height: 768px; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); overflow: auto;  background: #fff;">
    <div style="padding:20px 0 0 20px;">
        <button onclick="navigator.clipboard.writeText(`{$copyText}`);">Copy to clipboard</button>
    </div>
    <pre style="white-space: pre-wrap; font-family: 'Courier New', monospace; padding: 20px;">GET /{$index}/_search
{$request}</pre>
</div>
EOF;
    }
}
# Magento 2 Module - Elasticsuite Debug

Very poorly programmed debug output of Elasticsearch requests in frontend .. but it works ;)

It shows the final Elasticsearch request in a modal with a copy button.

## Installation

```shell
composer require --dev mvenghaus/m2-module-elasticsuite-debug
```

## Usage

```php
/** @var \Smile\ElasticsuiteCore\Search\RequestInterface $request */
\Mvenghaus\ElasticsuiteDebug\ElasticsuiteDebug::debugRequest($request);
```

```php
/** @var \Smile\ElasticsuiteCatalog\Model\ResourceModel\Product\Fulltext\Collection $productCollection */
\Mvenghaus\ElasticsuiteDebug\ElasticsuiteDebug::debugCollection($productCollection);
```
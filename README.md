# Pimcore CustomTwigBundle

A collection of twig Extensions/Filters and Tests for Pimcore 11.

- [Twig Extensions](docs/twig-extensions.md)
- [Twig Filters](docs/twig-filters.md)
- [Twig Tests](docs/twig-tests.md)
- [Twig Statements](docs/twig-statements.md)

### Installation

```php
"require": {
    "serge0design/pimcore-custom-twig": "^1.0",
}
```
- Execute: $ `composer require serge0design/pimcore-custom-twig`

Add Bundle to `bundles.php`:
```php
return [
    SergeDesign\PimcoreCustomTwigBundle\PimcoreCustomTwigBundle::class => ['all' => true],
];
```
 
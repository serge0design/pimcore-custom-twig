## Twig Test Examples

pimcoreAssetSvg\
Check if item is of MIME-Type image/svg+xml

``` 
{% if item is pimcoreAssetSvg %}
    ...
{% endif %}
```

twigTestIsArray\
Check if item is an array

``` 
{% if item is twigTestIsArray %}
    ...
{% endif %}
```

twigTestIsBoolean\
Check if item is of bool

``` 
{% if item is twigTestIsBoolean %}
    ...
{% endif %}
```

twigTestIsCallable\
Check if item is callable

``` 
{% if item is twigTestIsCallable %}
    ...
{% endif %}
```

twigTestIsCountable\
Check if item is countable

``` 
{% if item is twigTestIsCountable %}
    ...
{% endif %}
```

twigTestIsDir\
Check if item is a directory

``` 
{% if item is twigTestIsDir %}
    ...
{% endif %}
```

twigTestIsFloat\
Check if item is of float

``` 
{% if item is twigTestIsFloat %}
    ...
{% endif %}
```

twigTestIsInt\
Check if is of int

``` 
{% if item is twigTestIsInt %}
    ...
{% endif %}
```

twigTestIsNumeric\
Check if is of numeric

``` 
{% if item is twigTestIsNumeric %}
    ...
{% endif %}
```

twigTestIsNull\
Check if item is of null

``` 
{% if item is twigTestIsNull %}
    ...
{% endif %}
```

twigTestIsObject\
Check if item is an object

``` 
{% if item is twigTestIsObject %}
    ...
{% endif %}
```

twigTestIsResource\
Check if item is a resource

``` 
{% if item is twigTestIsResource %}
    ...
{% endif %}
```

twigTestIsScalar\
Check if item is scalar

``` 
{% if item is twigTestIsScalar %}
    ...
{% endif %}
```

twigTestIsString\
Check if item is a string

``` 
{% if item is twigTestIsString %}
    ...
{% endif %}
```

twigTestIsset\
Check if item is set

``` 
{% if item is twigTestIsset %}
    ...
{% endif %}
```

twigTestBundleChecker\
Check if Bundle is installed

``` 
{% if twigTestBundleChecker('PimcoreCustomTwigBundle') %}
    ...
{% endif %}
```
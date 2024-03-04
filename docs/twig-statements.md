## Twig Statement Examples

TwigSwitch

``` 
{% set item = 'item2' %}
{% switch item %}
    {% case 'item' %}
        <p>item is "value1"</p>
    {% case 'item2' %}
        <p>item is "value2"</p>
    {% case 'item3' %}
        <p>item is "value3"</p>
    {% default %}
        <p>item is something else</p>
{% endswitch %}
```
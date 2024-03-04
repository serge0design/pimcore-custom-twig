## Twig Extension Examples

TwigBootstrapSvgIcon:

```
{{ twigExtensionBootstrapSvgIcon('bootstrap', 'blue', 1.6) }}
```

TwigEditmodeLinkToObject:

```
{{ twigExtensionEditmodeLinkToObject(object.id) }}
```

TwigLanguageSwitcher:

```
{% for key, lang in twigExtensionLocalizedLinks(document) %}
<li {{ ( app.request.locale ==  key ? 'class="active"' : '') }}>
    <a href="{{ lang.link }}">
        <img class="language-switcher-img"
             src="{{ twigExtensionLanguageFlag(key) }}"
             height="20"
             width="25">
        {{ lang.text }}
    </a>
{% endfor %}
```

TwigQrCode:

```
{{ twigExtensionQrImage('string' ,200 ,25 ,[0,0,0] ,[255,255,255] ) }}
```
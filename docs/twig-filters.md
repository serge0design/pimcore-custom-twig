## Twig Filter Examples

test array

```
{% set array = ['apple', 'banana', 'cherry'] %}
```

twigFilterArrayFlip:<br>
Exchanges all keys with their associated values in an array

```
{% for item in array|twigFilterArrayFlip %}
    {{ item }}
{% endfor %}
```

twigFilterArrayReverse:<br>   
Return an array with elements in reverse order

``` 
{% for item in array|twigFilterArrayReverse %}
    {{ item }}
{% endfor %}
```

twigFilterArrayShuffle <br>  
Return an array with elements in shuffled order

``` 
{% for item in array|twigFilterArrayShuffle %}
    {{ item }}
{% endfor %}
```

twigFilterPassedTimeToNow<br>   
usable for logins, orders, blogs, etc. <br>
Outputs something like: Last Loggin ( 1day ago )

``` 
{% set unixTimestamp = dateField|date('U') %}
{{ unixTimestamp|twigFilterPassedTimeToNow }}
```

twigFilterFileGetContents

``` 
{{ svgImagePath|twigFilterFileGetContents }}
```

Formatting currency output

``` 
    {% set productPrice = 1234.56 %} {# Example price #}
    {% set currencySymbol = 'CHF' %} {# Currency code #}
    {% set locale = 'de_CH' %} {# Locale for formatting #}
    {# Using the twigFilterFormatPrice filter to format the price #}
    {{ productPrice|twigFilterFormatPrice(currencySymbol, 2, locale) }}
```

#### Image

twigFilterImgThumbnail

``` 
{{ pimcoreImage|twigFilterImgThumbnail('thumbnailName', 'cssClass', 'altText', {"data-attr": "value"}) }}
```

twigFilterImgThumbConfig

``` 
{{ pimcoreImage|twigFilterImgThumbConfig('cssClass', 'altText', 200, 200, 100, 'png') }}
```

twigFilterCssBgImg  
Output inline Code: style="background-image: url('..');

``` 
{{ pimcoreImage|twigFilterCssBgImg('thumbnailName') }}
```

Usage:

``` 
{% set pimcoreImage = pimcore_image("pimcoreImage")  %}
{% if editmode %}
    {{ pimcoreImage|raw }}
{% else %}
    {% set pimcoreImage = pimcoreImage.image %}
    {{ pimcoreImage|twigFilterImgThumbnail('thumbnailName', 'cssClass', 'altText', {"data-attr": "value"}) }}
    {{ pimcoreImage|twigFilterImgThumbConfig('cssClass', 'altText', 100, 100, 100, 'png') }}
    {{ pimcoreImage|twigFilterCssBgImg('contentimages') }}
{% endif %}
``` 

#### String

twigFilterGetMd5

``` 
{{ "string"|twigFilterGetMd5 }}
```

twigFilterGetUniqid

``` 
{{ "string"|twigFilterGetUniqid }}
```

twigFilterStringNormalizer

``` 
{% set string = '~¨^?\'"/-+.,;() &äöüÄÖÜßÉéÈèÊêEeËëÀàÁáÅåaÂâÃãªÆæCcÇçCcÍíÌìÎîÏïÓóÒòÔôºÕõŒOoØøÚúÙùÛûUuUuŠšSsŽžÑñ¡¿Ÿÿ_:' %}
{{ string|twigFilterStringNormalizer }}
```

twigFilterNormalizeFolderName

``` 
{% set string = '~¨^?\'"/-+.,;() &äöüÄÖÜßÉéÈèÊêEeËëÀàÁáÅåaÂâÃãªÆæCcÇçCcÍíÌìÎîÏïÓóÒòÔôºÕõŒOoØøÚúÙùÛûUuUuŠšSsŽžÑñ¡¿Ÿÿ_:' %}
{{ string|twigFilterNormalizeFolderName }}
```

twigFilterStrToLower

``` 
{{ "String"|twigFilterStrToLower }}
```

twigFilterStrToUpper

``` 
 {{ "string"|twigFilterStrToUpper }}
```

twigFilterStrCapitalize

``` 
 {{ "string"|twigFilterStrCapitalize }}
```

twigFilterTruncate

``` 
{{ "string"|twigFilterTruncate(120, false, '...') }}
```

twigFilterWordwrap

``` 
{{ "string"|twigFilterWordwrap(60 ,'<br>', false)  }}
```

#### Links

twigFilterHrefUrl

``` 
 {{ "https://url.com/"|twigFilterHrefUrl('css_class', "_blank") }}
```

twigFilterHrefEmail

``` 
{{ emailAddress|twigFilterHrefEmail('cssClass','subjectText', 'bodyText', 'ccEmail', 'bccEmail') }}
```

twigFilterHrefPhone

``` 
{{ href|twigFilterHrefPhone }}
```

twigFilterHrefWhatsApp

``` 
{{ href|twigFilterHrefWhatsApp }}
```

twigFilterHrefSocialMedia <br>
based on Bootstrap Icons: https://icons.getbootstrap.com/<br>
r.i.p. twitter

``` 
{% set social = "https://twitter.com" %}
{{ social|twigFilterHrefSocialMedia('twitter') }}
```

#### Time

twigFilterUnixTimestampToTime

```
{{ unixTimestamp|twigFilterUnixTimestampToTime }}
```
 

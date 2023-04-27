## Twig Filter Examples

twigFilterArrayFlip:  
Exchanges all keys with their associated values in an array
```
{% for item in array|twigFilterArrayFlip %}
    {{ item }}
{% endfor %}
```

twigFilterArrayReverse:  
Return an array with elements in reverse order
``` 
{% for item in array|twigFilterArrayReverse %}
    {{ item }}
{% endfor %}
```

twigFilterArrayShuffle  
Return an array with elements in shuffled order
``` 
{% for item in array|twigFilterArrayShuffle %}
    {{ item }}
{% endfor %}
```
twigFilterPassedTimeToNow  
usable for logins, orders, blogs, etc  
Return time passed from now, outputs: (in 10 years) or (10 years ago )
``` 
{{ unixTimestamp|twigFilterPassedTimeToNow }}
```

twigFilterFileGetContents
``` 
{{ svgImage.path|twigFilterFileGetContents }}
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
Return style="background-image: url();
``` 
{{ pimcoreImage|twigFilterCssBgImg('thumbnailName') }}
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
{{ "String"|twigFilterStringNormalizer }}
```
twigFilterStrToLower
``` 
{{ "String"|twigFilterStrToLower }}
```
twigFilterTruncate
``` 
{{ "string"|twigFilterTruncate(120, false, '...') }}
```
twigFilterWordwrap
``` 
{{ "string"|twigFilterWordwrap }}
```

#### Links
twigFilterHrefUrl
``` 
{{ "url"|twigFilterHrefUrl }} 
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
twigFilterHrefSocialMedia  
based on Bootstrap Icons: https://icons.getbootstrap.com/
``` 
{{ href|twigFilterHrefSocialMedia }}
```

#### Time
twigFilterUnixTimestampToTime
```
{{  unixTimestamp|twigFilterUnixTimestampToTime }}
```
 

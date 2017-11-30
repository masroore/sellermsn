# BootPHP


## Pre-requisite
- XAMPP [instructions](https://github.com/boilerplatez/docs/blob/master/markdown/xampp/ENV.md)
- PHP/Copmoser [instructions](https://github.com/boilerplatez/docs/blob/master/markdown/php/ENV.md)
## Setup

```bash
$ composer create-project bootphp/project my_project
$ cd my_project
$ composer update
```

## Build
- Whenever there are changes in Any Controller-Annotations you need to hit this url

```
    http://local.piggy.com?RX_MODE_DEBUG=true&RX_MODE_BUILD=1&_display_errors_=2
    
```

## Wroking?
- Hit these urls in your browser and see the outputs you get
```
    http://local.piggy.com/welcome?name=Lucas
    http://local.piggy.com/api/data/7
    http://local.piggy.com
    
```

## RudraX
- [Full Documentation](https://github.com/rudraks/boot/blob/master/README.md)

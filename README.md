# Flexible logging of REST API requests & responses

This module implements logging of REST API requests and responses to database and file system.
It supports filtering of private data and what should be logged or not with regular expressions. 

## Installation

The easiest way to install is to use Composer:

```
composer config repositories.guidance composer https://repo.guidance.com/
composer require guidance/module-webapi-logging
```

## Configuration

Almost all module configuration is situated in `etc/di.xml` file. 

The module can write logs to `webapi_log` table and to `var/log/webapi.log` file depends 
on logger handlers configuration of virtual type `fileDbLogger.` By default it logs to file and 
to database. Logs in `webapi_log` table are cleaned each night in 3am (it can be configured in 
`etc/crontab.xml`). Log entries older than 30 days will be cleaned (it can be configured in 
admin panel _Stores > Configuration > System > REST API Log Cleaning)._

To log particular requests `Guidance\WebapiLogging\Model\RegExpRequestFilter` type should be
configured. It matches request header and body against list of regular expressions. The filter 
supports two modes: blacklist and whitelist. In blacklist mode all matched requests won't be 
logged in whitelist mode vice versa.    
 
Filters for private data can be set up in 
`Guidance\WebapiLogging\Model\Formatter\PrivateDataFilter::$maskPatterns` property.
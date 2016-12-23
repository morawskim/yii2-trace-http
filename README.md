# Instalation
Currently, this yii2 extension is not provided by Packagist.
You must manually add repository to your `composer.json` file.

````
"repositories": [
  {
    "type": "git",
    "url": "https://github.com/morawskim/yii2-tracehttp.git"
  }
]
````

Then you can run this command in shell (at project root)
````
composer require --dev "mmo/yii2-tracehttp":"dev-master"
````

# TODO
* add filter (currently we log all request/response). We don't want log
request with user password.

* unit tests

* create associaction between request and response in logs

* add possibilities to parse request and change some value (eg. replace password with text "*****")

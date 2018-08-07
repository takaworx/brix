## Brix

Additional bootstrapping solution for Laravel that adds Repositories, Api Handlers, Etc.

### Installation

1. Please add the following to your composer.json:

```
"repositories": [
    {
        "url": "https://github.com/takaworx/brix.git",
        "type": "git"
    }
],
"require": {
    "takaworx/brix": "dev-master"
}
```

2. Publish the service provider

```
php artisan vendor:publish --provider=Takaworx\Brix\BrixServiceProvider
```

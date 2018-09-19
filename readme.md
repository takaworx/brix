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
    "takaworx/brix": "0.1.0"
}
```

2. Publish the service provider

```
php artisan vendor:publish --provider=Takaworx\Brix\BrixServiceProvider
```
### ApiResponse (Takaworx\Brix\Entities\ApiResponse)

Send uniform responses to your API call.

The `ApiResponse` class has three methods:

* `ApiResponse::success($data)`
* `ApiResponse::error($status, $data=null, $message=null)`,
* and `ApiResponse::exception(\Exception $e)`

For example:
```
<?php

use Takaworx\Brix\Entities\ApiResponse;

class ApiController extends Controller {
    public function getUser()
    {
        return ApiResponse::success([
            'id' => 1,
            'name' => 'John Doe',
        ]);
    }
}

?>
```

Result (200):
```
{
    'id': 1,
    'name': 'John Doe'
}
```

### ApiException (Takaworx\Brix\Exceptions\ApiException)

Create an exception that contains data which you can extract for your API response.

There are static methods to help you generate exceptions quickly:

* `ApiException::badRequest($data=null, $message=null, \Exception $inheritedException=null)` generate an exception w/ 400 HTTP eror code
* `ApiException::unauthorized($data=null, $message=null, \Exception $inheritedException=null)` generate an exception w/ 401 HTTP eror code
* `ApiException::forbidden($data=null, $message=null, \Exception $inheritedException=null)` generate an exception w/ 403 HTTP eror code
* `ApiException::notFound($data=null, $message=null, \Exception $inheritedException=null)` generate an exception w/ 404 HTTP eror code
* `ApiException::serverError($data=null, $message=null, \Exception $inheritedException=null)` generate an exception w/ 500 HTTP eror code

To get the data from the exception. Simply use the `getData()` method:
```
<?php

use Takaworx\Brix\Exceptions\ApiException

$exception = ApiException::badRequest([
    'id' => 'Must be an integer',
]);

var_dump($exception->getData())

?>
```

Result (400):
```
{
    'id': 'Must be an integer'
}
```

### Repository

Quickly create repositories for your model which you can inject into your controllers.

Use the command below to quickly generate a repository. This will save the new repository in `app/repositories` folder
```
php artisan make:repository UsersRepository --model=User
```

You can use the `model()` method to use the repository just like you would a Query builder:

```
<?php

use App\Repositories\UsersRepository;

class UserController extends Controller
{
    public function getUser(UsersRepository $users)
    {
        return $users->model()->where('name', 'John Doe')->first();
    }
}

?>
```

### Traits

Brix comes with some useful traits for your model that modifies the behavior of the model on certain query events.

**AuditTrait (Takaworx\Brix\Traits\AuditTrait)**

Saves the id of the user that created or last updated the model. This requires the model to have `created_at` and `updated_at` attributes.

Example usage:
```
<?php

use Illuminate\Database\Eloquent\Model;
use Takaworx\Brix\Traits\AuditTrait;

class User extends Model
{
    use AuditTrait;
}

?>
```

**Expirable (Takaworx\Brix\Traits\Expirable)**

Automatically add an expiration for the model upon creation. This requires the model to have `expires_at` attribute.

By default the expiration is set to 48 hours. You can override this by adding the `expiration` property in the model:
```
<?php

use Illuminate\Database\Eloquent\Model;
use Takaworx\Brix\Traits\Expirable;

class User extends Model
{
    use Expirable;

    protected $expiration = 72;
}

?>
```

**UidTrait (Takaworx\Brix\Traits\UidTrait)**

Automatically generate a unique string-based id for the model. This requires the model to have a UNIQUE `uid` attribute.

By default, the uid is 8 characters in length. You can override this by adding the `uidLength` property in the model:
```
<?php

use Illuminate\Database\Eloquent\Model;
use Takaworx\Brix\Traits\UidTrait;

class User extends Model
{
    use UidTrait;

    protected $uidLength = 8;
}

?>
```

To increase the number of possible unique ids the trait can generate, you can make the attribute case sensitive:
```
Schema::create('user', function (Blueprint $table) {
    $table->increments('id');
    $table->string('uid')->charset('utf8')->collation('utf8_bin')->unique();
    $table->string('name');
    $table->timestamps();
}
```

If you don't want your uid attribute to be case sensitive, you can ommit the charset and collation methods:
```
Schema::create('user', function (Blueprint $table) {
    $table->increments('id');
    $table->string('uid')->unique();
    $table->string('name');
    $table->timestamps();
}
```
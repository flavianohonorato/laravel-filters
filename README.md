
## Laravel package to make it easy to consult eloquente

- Install:

```
composer require wicool/laravel-filters
```

## How to use:

- Model `app/Models/User.php`
```php
<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Wicool\LaraFilter\LaraFilterTrait;

class User extends Model
{
    use LaraFilterTrait;

    /**
     * set string fields for filtering
     * @var array
     */
    protected $likeFilterFields = ['name', 'email', 'phone'];

    /**
     * set boolean fields for filtering
     * @var array
     */
    protected $boolFilterFields = ['status'];
}

```

- Controller `app/Http/Controllers/UserController.php`
###### You only need to pass the parameters via request in the controller scope filter.

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	public function index(Request $request)
	{
		$users = User->filter($request->all())->get();
		
		return $users;
	}
}
```

- The return will be something like:
```
/users?name=Fulaninho&email=fulaninho@email.com?phone=999999999&status=true

SELECT * FROM users WHERE name = 'Fulaninho' AND email = 'fulaninho@email.com' AND status = true
```

# Simple model validation for Laravel 4

---

* Auto validate model on save.
* Use simple or separate rules for model events (create, update and save).
* Based on Jeffrey Way project Laravel Model Validation.

---

## Installation

Just place require new package for your Laravel installation via composer.json

    "spajz/modval": "dev-master"

Then composer update.

You can add following lines to ```app/config/app.php``` if you want to use alias:

```php
'Modval' => 'Spajz\Modval\Modval'
```

## Usage

Your models need to extend `Modval` or `Spajz\Modval\Modval`.

```php
class Foo extends Modval {

}
```

How to add rules in the model (same for all events).

```php
class Foo extends Modval {
    protected static $rules = array(
        'title' => 'required',
        'slug' => 'required|min:5',
    );
}
```

Add rules separately for each event (create, update or save).
Save event is executed in both cases (create and update).

```php
class Foo extends Modval {
    protected static $rules = array(
        'create' => array(
            'slug' => 'required|min:5',
        ),
        'update' => array(
            'url' => 'required',
        ),
        'save' => array(
            'title' => 'required',
        ),
    );
}
```

And here's an example from controller.

```php
public function store()
{
    $foo = new Foo(Input::all());

    if ($foo->save()) return Redirect::route('foo.index');

    return Redirect::back()->withInput()->withErrors($foo->getErrors());
}
```

## Thanks

Thanks to Jeffrey Way and his project Laravel Model Validation:

[https://github.com/JeffreyWay/Laravel-Model-Validation](https://github.com/JeffreyWay/Laravel-Model-Validation)

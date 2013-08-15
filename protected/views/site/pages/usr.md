# Usr module

User login, registration and more.

## Resources

* [GitHub repo](https://github.com/nineinchnick/yii-usr).

* [Extension page](http://www.yiiframework.com/extension/usr).

* Available as composer package under [nineinchnick/yii-usr](https://packagist.org/packages/nineinchnick/yii-usr) name.

## Demo

This site is configured to present features like:

* Login page
* Registration
* Generate a random password
* Email verification
* Password recovery
* Force password reset after one day
* Update own profile

### Demo configuration

~~~
[php]
	'modules'=>array(
		// ...
		'usr'=>array(
			'class'=>'vendors.nineinchnick.yii-usr.UsrModule',
			'layout'=>'//layouts/column1',
			'userIdentityClass' => 'UserIdentity',
		),
	),
~~~

### Migrations

Currently there is only one migration that creates the table for User model:

* [migrations/m130815_104658_create_table_user.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/migrations/m130815_104658_create_table_user.php)

### Custom classes

The module provides an example User model and matching UserIdentity implementation. They are located in:

* [models/User.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/models/User.php)
* [components/UserIdentity.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/components/UserIdentity.php)

Most project specific logic is contained in the UserIdentity class.

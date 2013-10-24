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
* Log in using Facebook account (using Hybridauth PHP library)

### Demo configuration

~~~
[php]
	'modules'=>array(
		// ...
		'usr'=>array(
			'class'=>'vendors.nineinchnick.yii-usr.UsrModule',
			'layout'=>'//layouts/column1',
			'userIdentityClass' => 'UserIdentity',
			'hybridauthProviders' => array(
				'OpenID' => array('enabled'=>true),
				'Facebook' => array('enabled'=>true, 'keys'=>array('id'=>'', 'secret'=>''), 'scope'=>'email'),
			),
		),
	),
~~~

### Migrations

Currently there are two migrations that creates the table for User and UserRemoteIdentity models:

* [migrations/m130701_104658_create_table_user.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/migrations/m130701_104658_create_table_user.php)
* [migrations/m130702_104658_create_table_user_remote_identity.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/migrations/m130702_104658_create_table_user_remote_identity.php)

### Custom classes

The module provides an example User and UserRemoteIdentity models and matching UserIdentity implementation. They are located in:

* [models/User.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/models/User.php)
* [models/UserRemoteIdentity.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/models/UserRemoteIdentity.php)
* [components/UserIdentity.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/components/UserIdentity.php)

All project specific logic is contained in the UserIdentity class.

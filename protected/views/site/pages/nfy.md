# Nfy module

Notifications system.

## Resources

* [GitHub repo](https://github.com/nineinchnick/yii-nfy).

* [Extension page](http://www.yiiframework.com/extension/yii-nfy).

* Available as composer package under [nineinchnick/yii-nfy](https://packagist.org/packages/nineinchnick/yii-nfy) name.

## Demo

In this demo every registered user is subsribed to a default channel.

Notifications are added to this channel by pressing a button.

### Demo configuration

~~~
[php]
	'modules'=>array(
		// ...
		'nfy'=>array(
			'class'=>'vendors.nineinchnick.yii-nfy.NfyModule',
			'longPolling'=>null,
		),
	),
~~~

Long polling is disabled here because it seems this shared hosting platform allows only one process to serve this site.

### Migrations

Applied migrations from the extension.

Created one migration to create the default channel and subscribe existing users to it.

* [migrations/m130815_155154_insert_nfy_channels.php](https://github.com/nineinchnick/yii-demo/blob/master/protected/migrations/m130815_155154_insert_nfy_channels.php)

### Custom classes

No custom classes are necessary, the NfyDbRoute class is used to deliver messages.

The User class contains code in the afterSave() method to subsribe users to the default channel:

~~~
[php]

	protected function afterSave() {
		Yii::import('nfy.models.NfyChannels');
		foreach(NfyChannels::model()->findAll() as $channel) {
			$channel->unsubscribe($this->id);
			$channel->subscribe($this->id, 'db');
		}
	}

~~~




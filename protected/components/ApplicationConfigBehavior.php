<?php

/**
 * ApplicationConfigBehavior is a behavior for the application.
 * It loads additional config parameters that cannot be statically 
 * written in config/main
 */
class ApplicationConfigBehavior extends CBehavior
{
	/**
	 * Declares events and the event handler methods
	 * See yii documentation on behavior
	 */
	public function events() {
		return array_merge(parent::events(), array(
			'onBeginRequest'=>'beginRequest',
			'onEndRequest'=>'endRequest',
		));
	}

	public function processOption($property, $queryStringKey, $stateKey, $availableValues, $default = null) {
		if (isset($_GET) && isset($_GET[$queryStringKey])) {
			// if passed in the request, save value as state and optionally redirect back to remove param from url
			$value = $_GET[$queryStringKey];
			if (in_array($value, $availableValues)) {
				$this->owner->user->setState($stateKey, $value);
				YII_DEBUG && Yii::log('Received and saved state value for application property '.$property.': '.$value, 'debug', 'application.behavior.ApplicationConfigBehavior');
				if (isset($_GET['returnUrl']))
					$this->owner->request->redirect($_GET['returnUrl']);
			}
		}
		if (($value = $this->owner->user->getState($stateKey))) {
			// if state has been saved, use it's value
			$this->owner->$property = $value;
			YII_DEBUG && Yii::log('Application property '.$property.' has been set to value: '.$value, 'debug', 'application.behavior.ApplicationConfigBehavior');
		} elseif ($default !== null) {
			// if not and there is a default, use it - default value could be dynamic
			if (in_array($default, $availableValues))
				$this->owner->$property = $default;
			YII_DEBUG && Yii::log('Application property '.$property.' has been set to default value: '.$default, 'debug', 'application.behavior.ApplicationConfigBehavior');
		}
	}

	/**
	 * Load configuration that cannot be put in config/main
	 */
	public function beginRequest() {
		$availableLanguages = Controller::getAvailableLanguages();
		$availableThemes = Controller::getAvailableThemes();
		$this->processOption('language', 'language', 'applicationLanguage', array_keys($availableLanguages), Yii::app()->getRequest()->getPreferredLanguage());
		$this->processOption('theme', 'theme', 'applicationTheme', array_keys($availableThemes));
		return true;
	}

	public function endRequest() {
		return true;
	}
}

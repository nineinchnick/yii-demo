<?php

/**
 * This is the model class for table "{{countries}}".
 *
 * The followings are the available columns in table '{{countries}}':
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property string $french_short_name
 * @property string $short_code
 * @property string $code
 * @property string $telephone_prefix
 * @property integer $currency_id
 * @property integer $is_independent
 *
 * The followings are the available model relations:
 * @property Currencies $currency
 * @property CountryCode $countryCode
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{countries}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, short_name, short_code, code', 'required'),
			array('currency_id, is_independent', 'numerical', 'integerOnly'=>true),
			array('short_name, french_short_name, telephone_prefix', 'length', 'max'=>255),
			array('short_code', 'length', 'max'=>2),
			array('code', 'length', 'max'=>3),
			// The following rule is used by search().
			array('id, name, short_name, french_short_name, short_code, code, telephone_prefix, currency_id, is_independent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'countryCode' => array(self::HAS_ONE, 'CountryCode', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models','ID'),
			'name' => Yii::t('models','Name'),
			'short_name' => Yii::t('models','Short Name'),
			'french_short_name' => Yii::t('models','French Short Name'),
			'short_code' => Yii::t('models','Short Code'),
			'code' => Yii::t('models','Code'),
			'telephone_prefix' => Yii::t('models','Telephone Prefix'),
			'currency_id' => Yii::t('models','Currency'),
			'is_independent' => Yii::t('models','Is Independent'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('french_short_name',$this->french_short_name,true);
		$criteria->compare('short_code',$this->short_code,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('telephone_prefix',$this->telephone_prefix,true);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('is_independent',$this->is_independent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

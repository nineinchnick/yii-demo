<?php

/**
 * This is the model class for table "{{country_codes}}".
 *
 * The followings are the available columns in table '{{country_codes}}':
 * @property integer $country_id
 * @property string $numeric_code
 * @property string $vehicle_code
 * @property string $fifa_code
 * @property string $fips_code
 * @property string $gaul_code
 * @property string $ioc_code
 * @property string $itu_code
 * @property string $marc_code
 * @property string $wmo_code
 *
 * The followings are the available model relations:
 * @property Country $country
 */
class CountryCode extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{country_codes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('numeric_code, vehicle_code, fifa_code, fips_code, gaul_code, ioc_code, itu_code, marc_code, wmo_code', 'length', 'max'=>255),
			// The following rule is used by search().
			array('country_id, numeric_code, vehicle_code, fifa_code, fips_code, gaul_code, ioc_code, itu_code, marc_code, wmo_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'country_id' => Yii::t('models','Country'),
			'numeric_code' => Yii::t('models','Numeric Code'),
			'vehicle_code' => Yii::t('models','Vehicle Code'),
			'fifa_code' => Yii::t('models','Fifa Code'),
			'fips_code' => Yii::t('models','Fips Code'),
			'gaul_code' => Yii::t('models','Gaul Code'),
			'ioc_code' => Yii::t('models','Ioc Code'),
			'itu_code' => Yii::t('models','Itu Code'),
			'marc_code' => Yii::t('models','Marc Code'),
			'wmo_code' => Yii::t('models','Wmo Code'),
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

		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('numeric_code',$this->numeric_code,true);
		$criteria->compare('vehicle_code',$this->vehicle_code,true);
		$criteria->compare('fifa_code',$this->fifa_code,true);
		$criteria->compare('fips_code',$this->fips_code,true);
		$criteria->compare('gaul_code',$this->gaul_code,true);
		$criteria->compare('ioc_code',$this->ioc_code,true);
		$criteria->compare('itu_code',$this->itu_code,true);
		$criteria->compare('marc_code',$this->marc_code,true);
		$criteria->compare('wmo_code',$this->wmo_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CountryCode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "{{precious_metal_fixings}}".
 *
 * The followings are the available columns in table '{{precious_metal_fixings}}':
 * @property integer $id
 * @property string $date
 * @property integer $rate
 * @property integer $currency_id
 * @property integer $precious_metal_id
 *
 * The followings are the available model relations:
 * @property PreciousMetals $preciousMetal
 * @property Currencies $currency
 */
class PreciousMetalFixing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{precious_metal_fixings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('date, rate, currency_id, precious_metal_id', 'required'),
			array('rate, currency_id, precious_metal_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, date, rate, currency_id, precious_metal_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'preciousMetal' => array(self::BELONGS_TO, 'PreciousMetal', 'precious_metal_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models','ID'),
			'date' => Yii::t('models','Date'),
			'rate' => Yii::t('models','Rate'),
			'currency_id' => Yii::t('models','Currency'),
			'precious_metal_id' => Yii::t('models','Precious Metal'),
		);
	}

	/**
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 * @param array $columns columns definition used in CGridView
	 */
	public function search(array $columns)
	{
		$criteria=new CDbCriteria;

		if (isset($_GET['sSearch'])) {
			$criteria->compare('date',$_GET['sSearch'],true,'OR');
			$criteria->compare('rate',$_GET['sSearch'],false,'OR');
			//$criteria->compare('currency_id',$_GET['sSearch'],true,'OR');
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('precious_metal_id',$this->precious_metal_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>new EDTSort(__CLASS__, $columns),
			'pagination'=>new EDTPagination,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PreciousMetalFixing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

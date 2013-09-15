<?php

/**
 * This is the model class for table "{{currencies}}".
 *
 * The followings are the available columns in table '{{currencies}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $number
 * @property integer $minor_unit
 * @property string $withdrawn_date
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property Country[] $countries
 */
class Currency extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{currencies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, code', 'required'),
			array('number, minor_unit', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>3),
			array('withdrawn_date', 'length', 'max'=>255),
			array('comment', 'safe'),
			// The following rule is used by search().
			array('id, name, code, number, minor_unit, withdrawn_date, comment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'countries' => array(self::HAS_MANY, 'Country', 'currency_id'),
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
			'code' => Yii::t('models','Code'),
			'number' => Yii::t('models','Number'),
			'minor_unit' => Yii::t('models','Minor Unit'),
			'withdrawn_date' => Yii::t('models','Withdrawn Date'),
			'comment' => Yii::t('models','Comment'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('minor_unit',$this->minor_unit);
		$criteria->compare('withdrawn_date',$this->withdrawn_date,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currency the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

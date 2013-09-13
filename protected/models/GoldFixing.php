<?php

/**
 * This is the model class for table "{{gold_fixings}}".
 *
 * The followings are the available columns in table '{{gold_fixings}}':
 * @property integer $id
 * @property string $date
 * @property integer $rate
 * @property string $currency
 */
class GoldFixing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gold_fixings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('date, rate', 'required'),
			array('rate', 'numerical', 'integerOnly'=>true),
			array('currency', 'length', 'max'=>3),
			// The following rule is used by search().
			array('id, date, rate, currency', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'rate' => 'Rate',
			'currency' => 'Currency',
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
			$criteria->compare('currency',$_GET['sSearch'],true,'OR');
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('currency',$this->currency,true);

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
	 * @return GoldFixing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

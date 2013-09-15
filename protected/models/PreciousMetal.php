<?php

/**
 * This is the model class for table "{{precious_metals}}".
 *
 * The followings are the available columns in table '{{precious_metals}}':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property PreciousMetalFixings[] $preciousMetalFixings
 */
class PreciousMetal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{precious_metals}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'preciousMetalFixings' => array(self::HAS_MANY, 'PreciousMetalFixing', 'precious_metal_id'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PreciousMetal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

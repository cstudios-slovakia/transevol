<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transporter".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $companies_id
 * @property string $transport_price
 * @property string $transport_other_costs
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Companies $companies
 * @property Listings $customer
 * @property TransporterContents[] $transporterContents
 */
class Transporter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'transport_price'], 'required'],
            [['customer_id', 'companies_id'], 'integer'],
            [['transport_price', 'transport_other_costs'], 'number'],
            [['created_at', 'updated_at', 'created_at'], 'safe'],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listings::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'companies_id' => Yii::t('app', 'Companies ID'),
            'transport_price' => Yii::t('app', 'Transport Price'),
            'transport_other_costs' => Yii::t('app', 'Transport Other Costs'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasOne(Companies::className(), ['id' => 'companies_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Listings::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransporterContents()
    {
        return $this->hasMany(TransporterContents::className(), ['transporter_id' => 'id']);
    }

    public function getTransporterParts()
    {
        return $this->hasMany(TransporterParts::className(), ['id' => 'transporter_parts_id'])
            ->via('transporterContents');

    }
}

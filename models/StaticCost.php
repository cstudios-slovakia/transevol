<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "static_costs".
 *
 * @property int $id
 * @property string $cost_name
 * @property string $short_name
 * @property string $cost_section
 * @property int $frequency_datas_id
 * @property int $units_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyCostDatas[] $companyCostDatas
 * @property DriverCostDatas[] $driverCostDatas
 * @property FrequencyDatas $frequencyDatas
 * @property Units $units
 * @property TransportDriverStaticCostContracts[] $transportDriverStaticCostContracts
 * @property TransportVehicleStaticCost[] $transportVehicleStaticCosts
 * @property VehicleStaticCosts[] $vehicleStaticCosts
 */
class StaticCost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'static_costs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cost_name', 'short_name', 'cost_section', 'frequency_datas_id', 'units_id', 'created_at'], 'required'],
            [['frequency_datas_id', 'units_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cost_name', 'short_name', 'cost_section'], 'string', 'max' => 100],
            [['frequency_datas_id'], 'exist', 'skipOnError' => true, 'targetClass' => FrequencyDatas::className(), 'targetAttribute' => ['frequency_datas_id' => 'id']],
            [['units_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['units_id' => 'id']],
        ];
    }

    public static function instantiate($row)
    {
        switch ($row['cost_section']) {
            case DriverStaticCost::SECTION:
                return new DriverStaticCost();

            default:
                return new self;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cost_name' => 'Cost Name',
            'short_name' => 'Short Name',
            'cost_section' => 'Cost Section',
            'frequency_datas_id' => 'Frequency Datas ID',
            'units_id' => 'Units ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyCostDatas()
    {
        return $this->hasMany(CompanyCostDatas::className(), ['static_costs_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverCostDatas()
    {
        return $this->hasMany(DriverCostDatas::className(), ['static_costs_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequencyDatas()
    {
        return $this->hasOne(FrequencyDatas::className(), ['id' => 'frequency_datas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasOne(Units::className(), ['id' => 'units_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportDriverStaticCostContracts()
    {
        return $this->hasMany(TransportDriverStaticCostContracts::className(), ['static_costs_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportVehicleStaticCosts()
    {
        return $this->hasMany(TransportVehicleStaticCost::className(), ['static_costs_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleStaticCosts()
    {
        return $this->hasMany(VehicleStaticCosts::className(), ['static_costs_id' => 'id']);
    }
}

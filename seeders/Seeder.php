<?php

namespace app\seeders;

use tebazil\dbseeder\FakerConfigurator;
use tebazil\yii2seeder\Seeder as YiiSeeder;

abstract class Seeder extends YiiSeeder{

    protected $pdo;

    /** @var  FakerConfigurator */
    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->setPdo($this->dbHelper->db->getMasterPdo());

        $generator = $this->getGenerator();
        $faker = $generator->getFakerConfigurator();

        $this->setFaker($faker);
    }


    protected function disableFkCheck()
    {
        $stmt = $this->getPdo()->prepare("SET FOREIGN_KEY_CHECKS=0");
        $stmt->execute();
    }

    protected function enableFkCheck()
    {
        $stmt = $this->getPdo()->prepare("SET FOREIGN_KEY_CHECKS=1");
        $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @return mixed
     */
    public function getFaker()
    {
        return $this->faker;
    }

    /**
     * @param mixed $faker
     */
    public function setFaker($faker)
    {
        $this->faker = $faker;
    }

    public function getGenerator()
    {
        return $this->getGeneratorConfigurator();
    }

    public function __call($name, $arguments)
    {
        if ($name === 'seeding') {
            $this->disableFkCheck();

            if(method_exists($this,'run')){
                $this->run();

                $this->refill();
            }

            $this->enableFkCheck();
        }
    }
}


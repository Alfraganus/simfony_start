<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $countryData = [
            ['name' => 'Germany', 'regexTaxNumber' => 'DE123456789', 'taxPercentage' => 19],
            ['name' => 'Italy', 'regexTaxNumber' => 'IT123456789', 'taxPercentage' => 22],
            ['name' => 'Greece', 'regexTaxNumber' => 'GR123456789', 'taxPercentage' => 24],
            ['name' => 'France', 'regexTaxNumber' => 'FR123456789', 'taxPercentage' => 20],
        ];

        foreach ($countryData as $countryInfo) {
            $country = new Country();
            $country->setName($countryInfo['name']);
            $country->setRegexTaxNumber($countryInfo['regexTaxNumber']);
            $country->setTaxPercentage($countryInfo['taxPercentage']);
            $manager->persist($country);
        }

        $manager->flush();
    }
}

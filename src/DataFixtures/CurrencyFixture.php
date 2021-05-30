<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixture extends Fixture
{
    const CURRENCY_BITCOIN = 'bitcoin';

    const CURRENCY_USD = 'dollar';

    const CURRENCY_EURO = 'CURRENCY_EURO';

    public function load(ObjectManager $manager): void
    {
        $currency = new Currency();
        $currency->setName('bitcoin');
        $currency->setShortName('BTC');
        $currency->setCreated(new \DateTime());
        $this->addReference(self::CURRENCY_BITCOIN, $currency);
        $manager->persist($currency);

        $currencyUsd = new Currency();
        $currencyUsd->setName('dollar');
        $currencyUsd->setShortName('USD');
        $currencyUsd->setCreated(new \DateTime());
        $this->addReference(self::CURRENCY_USD, $currencyUsd);
        $manager->persist($currencyUsd);

        $currencyEuro = new Currency();
        $currencyEuro->setName('euro');
        $currencyEuro->setShortName('EUR');
        $currencyEuro->setCreated(new \DateTime());
        $this->addReference(self::CURRENCY_EURO, $currencyEuro);
        $manager->persist($currencyEuro);

        $manager->flush();
    }
}

<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\CurrencyHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CurrencyHistoryFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $currencyHistoryBTCUSD = new CurrencyHistory();
        $currencyHistoryBTCUSD->setCurrency($this->getReference(CurrencyFixture::CURRENCY_BITCOIN));
        $currencyHistoryBTCUSD->setCurrencyTo($this->getReference(CurrencyFixture::CURRENCY_USD));
        $currencyHistoryBTCUSD->setAmount("10000");
        $currencyHistoryBTCUSD->setCreated(new \DateTime());

        $manager->persist($currencyHistoryBTCUSD);

        $currencyHistoryBTCUSD2 = new CurrencyHistory();
        $currencyHistoryBTCUSD2->setCurrency($this->getReference(CurrencyFixture::CURRENCY_BITCOIN));
        $currencyHistoryBTCUSD2->setCurrencyTo($this->getReference(CurrencyFixture::CURRENCY_USD));
        $currencyHistoryBTCUSD2->setAmount("50000");
        $currencyHistoryBTCUSD2->setCreated(new \DateTime());

        $manager->persist($currencyHistoryBTCUSD2);

        $currencyHistoryBTCEURO = new CurrencyHistory();
        $currencyHistoryBTCEURO->setCurrency($this->getReference(CurrencyFixture::CURRENCY_BITCOIN));
        $currencyHistoryBTCEURO->setCurrencyTo($this->getReference(CurrencyFixture::CURRENCY_EURO));
        $currencyHistoryBTCEURO->setAmount("20000");
        $currencyHistoryBTCEURO->setCreated(new \DateTime());

        $manager->persist($currencyHistoryBTCEURO);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CurrencyFixture::class
        ];
    }
}

<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\CurrencyHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyHistory::class);
    }

    /**
     * @param string $name
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getHistoryCurrencyByPeriod(string $name, \DateTime $from, \DateTime $to): array
    {
        $con = $this->getEntityManager()->getConnection();

        $sql = <<<SQL
SELECT cMain.id, cMain.name, cMain.name, cTO.name as currencyNameTo, history.amount, history.created FROM currency_history history
INNER JOIN currency cMain ON cMain.id = history.currency_id
INNER JOIN currency cTO on cTO.id = history.currency_to_id
WHERE cMain.short_name = :name AND history.created >= :from AND history.created <= :to 
ORDER BY cTO.name, created ASC;
SQL;
        $stmt = $con->executeQuery(
            $sql,
            [
                'name' => $name,
                'from' => $from->format('Y-m-d H:i:s'),
                'to' => $to->format('Y-m-d H:i:s')
            ]
        );

        return $stmt->fetchAllAssociative();
    }

    /**
     * @param Currency $currency
     * @param Currency $currencyTo
     * @param string $amount
     * @param \DateTime $created
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(
        Currency $currency,
        Currency $currencyTo,
        string $amount,
        \DateTime  $created
    ): void {
        $manager = $this->getEntityManager();
        $history = new CurrencyHistory();
        $history->setCurrency($currency);
        $history->setCurrencyTo($currencyTo);
        $history->setAmount($amount);
        $history->setCreated($created);
        $manager->persist($history);
        $manager->flush();
    }
}

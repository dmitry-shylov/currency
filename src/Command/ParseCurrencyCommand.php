<?php declare(strict_types=1);

namespace App\Command;

use App\DataFixtures\CurrencyFixture;
use App\Entity\Currency;
use App\Repository\CurrencyHistoryRepository;
use App\Repository\CurrencyRepository;
use App\Service\HttpRequester;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ParseCurrencyCommand  extends Command
{
    /**
     * @var CurrencyHistoryRepository
     */
    private $currencyHistoryRepository;

    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    /**
     * @var HttpRequester
     */
    private $httpRequester;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string
     */
    private $url;

    protected function configure(): void
    {
        $this->setName('eps:parse:currency');
    }

    public function __construct(
        CurrencyHistoryRepository $currencyHistoryRepository,
        CurrencyRepository $currencyRepository,
        HttpRequester $httpRequester,
        LoggerInterface $logger,
        ParameterBagInterface $params
    ) {
        parent::__construct();
        $this->currencyHistoryRepository = $currencyHistoryRepository;
        $this->currencyRepository = $currencyRepository;
        $this->httpRequester = $httpRequester;
        $this->logger = $logger;
        $this->url = (string) $params->get('coincap')['api_url'];
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->httpRequester->sendRequest($this->url . '/' . CurrencyFixture::CURRENCY_BITCOIN);
            $result = $this->httpRequester->getResponse();
            /**
             * @var Currency $currency
             */
            $currency = $this->currencyRepository->findOneBy(['name' => CurrencyFixture::CURRENCY_BITCOIN]);
            /**
             * @var Currency $currencyTo
             */
            $currencyTo = $this->currencyRepository->findOneBy(['name' => CurrencyFixture::CURRENCY_USD]);

            $response = json_decode($result, true);
            $this->currencyHistoryRepository->create(
                $currency,
                $currencyTo,
                $response['data']['rateUsd'],
                new \DateTime()
            );
        } catch (\Throwable $e) {
            $this->logger->log(LogLevel::ERROR, $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => null
            ]);

            return 1;
        }

        return 0;
    }
}

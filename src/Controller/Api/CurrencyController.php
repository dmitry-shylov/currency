<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Currency;
use App\Repository\CurrencyHistoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/v1")
 */
class CurrencyController
{
    /**
     * @Route(
     *     "/currencies/{currency}",
     *     requirements={
     *        "currency"="^BTC$"
     *     },
     *     methods={"GET"}
     * )
     * @param Request $request
     * @param string $currency
     * @param CurrencyHistoryRepository $currencyHistoryRepository
     */
    public function action(
        string $currency,
        Request $request,
        CurrencyHistoryRepository $currencyHistoryRepository
    ): Response {
        //TODO:: Валидация полей или через регулярку
        $from = new \DateTime($request->query->get('from'));
        $to = new \DateTime($request->query->get('to'));
        $data = $currencyHistoryRepository->getHistoryCurrencyByPeriod(
            Currency::BTC_SHORT_NAME,
            $from,
            $to
        );

        if (!$data) {
            return new JsonResponse($data);
        }

        /**
         * TODO:: Форматирование нужно вынести из контроллера
         * Оно должно быть либо в сервисе, либо в репозиторий.
         */
        $baseCurrency = current($data)['name'];
        $result[$baseCurrency] = [];
        foreach ($data as $currency) {
            $result[$baseCurrency][$currency['currencyNameTo']][] = [
                'amount' => $currency['amount'],
                'created' => $currency['created'],
                'timestamp' => (new \DateTime($currency['created']))->getTimestamp()
            ];
        }

        return new JsonResponse($result);
    }
}

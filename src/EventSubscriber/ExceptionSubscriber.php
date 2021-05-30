<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExceptionSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException', 0],
                ['logException', 1]
            ],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $jsonResponse = new JsonResponse(null, 500);
        $jsonResponse->setEncodingOptions(
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
        );
        $jsonResponse->setData([
            'message' => $exception->getMessage()
        ]);

        $event->setResponse($jsonResponse);
    }

    /**
     * @param ExceptionEvent $event
     */
    public function logException(ExceptionEvent $event): void
    {
        $exception = $event->getException();

        $message = sprintf(
            'ExceptionMessage: %s ',
            $exception->getMessage()
        );

        $this->logger->log(LogLevel::ERROR, $message, [
            [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'stackTrace' => $exception->getTraceAsString()
            ]
        ]);
    }
}

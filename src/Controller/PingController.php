<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    /**
     * @Route("/xping", methods={"GET"})
     * @return JsonResponse
     * @throws \Exception
     */
    public function xping()
    {
        return new JsonResponse(["meta" =>
            [
                "service" => "merchant",
                "date" => (new \DateTime())->format("Y-m-d\TH:i:s\Z")
            ]
        ]);
    }
}

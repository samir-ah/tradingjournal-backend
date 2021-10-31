<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TradeRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PerformanceController extends AbstractController
{
    public function __construct(private TradeRepository $tradeRepository)
    {

    }

    #[Route('/api/performance', name: 'performance',methods: "GET")]
    public function index(Request $request, SerializerInterface $serializer): Response
    {
//        $jsonRaw = $request->getContent();
//        $jsonData = json_decode($jsonRaw);
        try {
            $performanceData = [];
            $performanceData["byTradePerformance"] = $this->tradeRepository->findPerformance($this->getUser()->getId(),12);
            $performanceData["groupByMonth"] = $this->tradeRepository->findPerformanceGroupByMonth($this->getUser()->getId(),12);
            $performanceData["totalTrades"] = $this->tradeRepository->count(["author"=>$this->getUser()->getId()]);
            $performanceData["totalPerformance"] = $this->tradeRepository->findTotalPerformanceSum($this->getUser()->getId())["total"] ?? 0;

            return $this->json($performanceData, Response::HTTP_CREATED, [], ['groups' => 'read:User']);

        } catch (Exception $e) {
            return $this->json(
                [
                    'message' => $e->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

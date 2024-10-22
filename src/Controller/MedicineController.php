<?php

namespace App\Controller;

use App\Entity\Medicament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medicines')]
class MedicineController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_medicines', methods: ['GET'])]
    public function getMedicines(Request $request)
    {
        $page = $request->query->get('page') ;
        $element = $request->query->get('element');
        $name = $request->query->get('name');
        $nameOrder = $request->query->get('order_name');

        $medicines = $this->entityManager->getRepository(Medicament::class)->findAllMedicinesWithPagination($page,
            $element, $nameOrder, $name);
        $response = array();
        /** @var  $medicine  Medicament */
        foreach ($medicines as $medicine) {
            $response['medicines'][] = [
                'id' => $medicine->getId(),
                'business name' => $medicine->getNomCommercial(),
                "family" => $medicine->getFamille()->getLibelle(),
                "composition" => $medicine->getComposition(),
                "effects" => $medicine->getEffets(),
                "againstIndications" => $medicine->getContreIndications(),

            ];
        }
        $response["currentPage"] = $page !== null ? $page : 1;
        $response["totalPages"] = $element!== null ? ceil(count($medicines)/$element) : 1;
        return new JsonResponse($response, 200);
    }
}
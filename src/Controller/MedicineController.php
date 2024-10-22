<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Repository\MedicamentRepository;
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
        $page = $request->query->get('page') !== null ? $request->query->get('page') : 1;
        $element = $request->query->get('element') !== null ? $request->query->get('element') : 10;
        $name = $request->query->get('name');
        $nameOrder = $request->query->get('order_name') !== null ? $request->query->get('order_name') : 'asc';

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
        $response["currentPage"] = $page;
        $response["totalPages"] = ceil(count($medicines) / $element);
        return new JsonResponse($response, 200);
    }
}
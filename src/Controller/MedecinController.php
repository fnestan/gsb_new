<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Rapport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/doctors')]
class MedecinController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_doctors', methods: ['GET'])]
    public function getDoctors(Request $request)
    {
        $page = $request->query->get('page') !== null ? $request->query->get('page') : 1;
        $element = $request->query->get('element') !== null ? $request->query->get('element') : 10;
        $name = $request->query->get('name');
        $lastnameOrder = $request->query->get('lastname');
        $firstnameOrder = $request->query->get('firstname');
        $doctors = $this->entityManager->getRepository(Medecin::class)->findAllDoctorsWithPagination($page,
            $element, $lastnameOrder, $firstnameOrder, $name);
        $response = array();
        foreach ($doctors as $doctor) {
            $response['doctors'][] = [
                "id" => $doctor->getId(),
                "lastname" => $doctor->getNom(),
                "firstname" => $doctor->getPrenom(),
                "phone" => $doctor->getTel() ? $doctor->getTel() : "",
                "address" => $doctor->getAdresse() ? $doctor->getAdresse() : "",
                "speciality" => $doctor->getSpecialitecomplementaire() ? $doctor->getSpecialitecomplementaire() : "",

            ];
        }
        $response["currentPage"] = $page;
        $response["totalPages"] = ceil(count($doctors) / $element);
        return new JsonResponse($response, 200);

    }

    #[Route('/{id}', name: 'app_doctor', methods: ['GET'])]
    public function getDoctorById($id)
    {
        $doctor = $this->entityManager->getRepository(Medecin::class)->find($id);
        $reports = $this->entityManager->getRepository(Rapport::class)->findByMedecin($doctor);
        $reportList = array();
        foreach ($reports as $report) {
            $reportList[] = [
                "id" => $report->getId(),
                "date" => $report->getDate()->format('Y-m-d'),
                "motiv" => $report->getMotif(),
                "balance sheet" => $report->getBilan()
            ];
        }
        $response = [
            "id" => $doctor->getId(),
            "lastname" => $doctor->getNom(),
            "firstname" => $doctor->getPrenom(),
            "phone" => $doctor->getTel() ?: "",
            "address" => $doctor->getAdresse() ?: "",
            "speciality" => $doctor->getSpecialitecomplementaire() ?: "",
            "department" => $doctor->getDepartement(),
            "reports" => $reportList
        ];
        return new JsonResponse($response, 200);
    }

}
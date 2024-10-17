<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Rapport;
use App\Entity\Visiteur;
use App\Service\JwtTokenGenerator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('reports')]
class ReportController extends AbstractController
{
    private JwtTokenGenerator $tokenGenerator;
    private EntityManagerInterface $entityManager;

    public function __construct(JwtTokenGenerator $tokenGenerator, EntityManagerInterface $entityManager)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_reports', methods: ['GET'])]
    public function getReports(Request $request)
    {
        $page = $request->query->get('page');
        $element = $request->query->get('element');
        $reports = $this->entityManager->getRepository(Rapport::class)->findAllReportsWithPagination($page, $element);
        $response = array();
        foreach ($reports as $report) {
            $response[] = [
                "id" => $report->getId(),
                "date" => $report->getDate()->format('Y-m-d'),
                "motive" => $report->getMotif(),
                "balance sheet" => $report->getBilan()
            ];
        }
        $response["currentPage"] = $page;
        $response["totalPages"] = ceil(count($reports) / $element);
        return new JsonResponse($response, 200);
    }

    #[Route('/{id}', name: 'app_report', methods: ['GET'])]
    public function getReportBYid($id)
    {
        $report = $this->entityManager->getRepository(Rapport::class)->find($id);
        $response = [
            "id" => $report->getId(),
            "date" => $report->getDate()->format('Y-m-d'),
            "motive" => $report->getMotif(),
            "balance sheet" => $report->getBilan(),
            "doctor" => $report->getMedecin() ? $report->getMedecin()->getPrenom() . " "
                . $report->getMedecin()->getNom() : " "
        ];
        return new JsonResponse($response, 200);
    }

    #[Route('/', name: 'app_create_report', methods: ['POST'])]
    public function createReport(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');

        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return new JsonResponse(['error' => 'Token manquant ou incorrect'], 401);
        }
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenIsValid = $this->tokenGenerator->validateToken($token);
        $tokenIsBlacklisted = $this->tokenGenerator->isBlacklisted($token);
        $visiteurId = $this->tokenGenerator->getClaims($token)["uid"];
        $visitorRepository = $this->entityManager->getRepository(Visiteur::class);
        $visitor = $visitorRepository->find($visiteurId);
        if (is_null($visitor) || !$tokenIsValid || $tokenIsBlacklisted) {
            return new JsonResponse(['error' => 'Token manquant ou incorrect ou visiteur inexistant'], 401);

        }
        $balanceSheet = json_decode($request->getContent())->balanceSheet;
        $motive = json_decode($request->getContent())->motive;
        $doctorId = json_decode($request->getContent())->doctorId;
        $date = json_decode($request->getContent())->date;
        $reportDate = DateTime::createFromFormat('Y-m-d', $date);
        $doctor = $this->entityManager->getRepository(Medecin::class)->find($doctorId);
        $report = new Rapport();
        $report->setDate($reportDate);
        $report->setBilan($balanceSheet);
        $report->setMedecin($doctor);
        $report->setMotif($motive);
        $report->setVisiteur($visitor);
        $this->entityManager->persist($report);
        $this->entityManager->flush();
        return new JsonResponse(['data' => 'rapport crée'], 201);
    }
}
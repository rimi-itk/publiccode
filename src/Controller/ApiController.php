<?php

namespace App\Controller;

use App\Repository\SoftwareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_')]
class ApiController extends AbstractController
{
    #[Route('/software', name: 'software')]
    public function software(SoftwareRepository $softwareRepository): JsonResponse
    {
        $software = $softwareRepository->findAll();

        return $this->json($software);
    }
}

<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/project/{keyCode}', name: 'project_show')]
    public function show(?Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }
    #[Route('/project/', name: 'project_list')]
    public function list(): Response
    {
        return $this->render('project/list.html.twig');
    }
}

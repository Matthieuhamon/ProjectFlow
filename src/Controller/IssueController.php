<?php

namespace App\Controller;

use App\Entity\Attachment;
use App\Entity\Issue;
use App\Entity\User;
use App\Service\AttachmentService;
use App\Service\IssueService;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User getUser()
 */
#[Route('/issues', name: 'issue_')]
class IssueController extends AbstractController
{
    public function __construct(
        private readonly IssueService $issueService
    ) {
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('issue/list.html.twig', [
            'issues' => $this->getUser()->getSelectedProject()->getIssues(),
            'issueStatuses' => $this->issueService->getIssueStatuses(),
            'issueTypes' => $this->issueService->getIssueTypes()
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET'])]
    public function create(ProjectService $projectService): Response
    {
        if (!$user = $this->getUser()) {
            return $this->json([]);
        }

        $reporter = [
            'id' => $user->getId(),
            'name' => $user->getEmail(),
        ];

        return $this->json([
            'projects' => $projectService->findAllNormalized(['project:list:create:issue']),
            'statuses' => $this->issueService->getIssueStatuses(),
            'types' => $this->issueService->getIssueTypes(),
            'reporter' => $reporter
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(?Issue $issue): Response
    {
        return $this->render('issue/index.html.twig', [
            'issue' => $issue,
            'issueStatuses' => $this->issueService->getIssueStatuses(),
            'issueTypes' => $this->issueService->getIssueTypes(),
        ]);
    }

    #[Route('/{id}/attachments', name: 'add_attachment', methods: ['POST'])]
    public function addAttachment(AttachmentService $attachmentService, ?Issue $issue, Request $request): Response
    {
        /** @var ?UploadedFile $attachmentFile */
        $attachmentFile = $request->files->get('attachment');

        if (null === $attachmentFile) {
            return $this->json([]);
        }

        $newFilename = $attachmentService->generateNewFilename($attachmentFile);

        $attachment = new Attachment($issue);
        $attachment->setOriginalName($attachmentFile->getClientOriginalName());
        $attachment->setPath($this->getParameter('absolute_attachments_directory').DIRECTORY_SEPARATOR.$newFilename);
        $attachment->setSize($attachmentFile->getSize());

        $attachmentFile->move($this->getParameter('attachments_directory'), $newFilename);
        $attachmentService->add($attachment);

        return $this->json([
            'id' => $attachment->getId(),
            'createdAt' => $attachment->getCreatedAt(),
            'originalName' => $attachment->getOriginalName(),
            'path' => $attachment->getPath(),
            'size' => $attachment->getSize(),
        ]);
    }
}

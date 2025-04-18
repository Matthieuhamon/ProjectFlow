<?php

namespace App\Twig\Components;
use App\Form\Type\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent]
class ProjectForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[LiveProp]
    public ?Project $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        $this->initialFormData = new Project();
        return $this->createForm(ProjectType::class, $this->initialFormData);
    }
    #[LiveProp]
    public function save(): Reponse
    {
        $this->validate();
        $this->submitForm();
    }
}
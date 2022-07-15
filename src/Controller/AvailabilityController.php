<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\Type\AvailabilityType;
use App\Service\AvailabilityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AvailabilityController extends AbstractController
{
    private AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index(Request $request): Response
    {
        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class, $availability);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $availabilityFormData = $form->getData();
            $availableSpaces = $this->availabilityService->getAvailability(
                $availabilityFormData->getFromDate(),
                $availabilityFormData->getToDate()
            );
        }

        return $this->renderForm('availability.html.twig', [
            'form' => $form,
            'available_spaces' => $availableSpaces ?? [],
        ]);


    }
}
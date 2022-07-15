<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\Type\BookingType;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends AbstractController
{
    private BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function book(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bookingFormData= $form->getData();
            $bookingResponse = $this->bookingService->book(
                $bookingFormData->getUsername(),
                $bookingFormData->getFromDate(),
                $bookingFormData->getToDate()
            );
        }

        return $this->renderForm('booking.html.twig', [
            'form' => $form,
            'message' => $bookingResponse ?? '',
        ]);


    }
}
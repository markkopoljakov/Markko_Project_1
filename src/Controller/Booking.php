<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use  Symfony\Component\Form\Extension\Core\Type\DateType;
use  Symfony\Component\Form\Extension\Core\Type\SubmitType;
use  Symfony\Component\Form\Extension\Core\Type\TextType;
use  Symfony\Component\Form\Extension\Core\Type\EmailType;
use  Symfony\Component\Form\Extension\Core\Type\IntegerType;
use  Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use  Symfony\Component\Form\Extension\Core\Type\TimeType;


class Booking extends AbstractController
{

    /**
     * @Route("/create_booking")
     */

    public function createBooking(): Response
    {
        $form = $this->createFormBuilder()
            ->add('Firstname', TextType::class)
            ->add('Lastname', TextType::class)
            ->add('Phone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Lastname', TextType::class)
            ->add('Birthday', DateType::class)
            ->add('StartDate', DateType::class)
            ->add('EndDate', DateType::class)
            ->add('ArrivalTime', TimeType::class)
            ->add('Numberofpeople', IntegerType::class)
            ->add('Paymentmethod', ChoiceType::class, [
                'choices' => [
                    'cash' => 'cash',
                    'bank transfer' => 'transfer',
                ],
            ])
             ->add('save', SubmitType::class)
             ->getForm();

        return $this->render('/create_booking.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/bookings")
     */

    public function Booking(): Response {
        return $this->render('/bookings.html.twig');
    }
}
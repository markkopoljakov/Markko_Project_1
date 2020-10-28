<?php


namespace App\Controller;
use App\Entity\Bookings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTime;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class Booking extends AbstractController
{

    /**
     * @Route("/create_booking")
     */

    public function create_booking(Request $request): Response
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
             ->add('submit', SubmitType::class)
             ->getForm();

        if ($request->isMethod('POST')){
            $form->submit($request->request->get($form->getName()));
            if ($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $booking = new Bookings();

                $booking->setFirstName($data['Firstname']);
                $booking->setLastName($data['Lastname']);
                $booking->setPhone($data['Phone']);
                $booking->setEmail($data['Email']);
                $booking->setBirthdate( new \DateTime($data['Birthday']->format('Y-m-d')));
                $booking->setStartDate( new \DateTime($data['StartDate']->format('Y-m-d')));
                $booking->setEndDate( new \DateTime($data['EndDate']->format('Y-m-d')));
                $booking->setArrivalTime( new \DateTime($data['ArrivalTime']->format('H:i:s')));
                $booking->setNumberOfPeople($data['Numberofpeople']);
                $booking->setPayingMethod($data['Paymentmethod']);
                $entityManager->persist($booking);

                $entityManager->flush();

                return $this->redirectToRoute('bookings');

            }
        }
        return $this->render('/create_booking.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/bookings", name="bookings")
     */
    public function bookings(){
        $this->generateUrl('bookings');
        $repository = $this->getDoctrine()->getRepository(Bookings::class);
        $booking = $repository->findAll();
        return $this->render('list.html.twig', ['booking' => $booking]);
    }
}
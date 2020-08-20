<?php
namespace App\Controller;

use App\Entity\Parking;
use App\DTO\ParkingDTO;
use App\Entity\ParkingSpace;
use App\Form\ParkingDTOType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParkingController extends AbstractController
{
    /**
     * @Route("/parking", name="parking")
     */
    public function index()
    {
        return $this->render('parking/parking.html.twig', [
            'controller_name' => 'ParkingController',
        ]);
    }

    /**
     * @Route("/parking/add", name="parking_add")
     */
    public function submit(Request $request)
    {
        // Je crée un objet
        $parkingDTO = new ParkingDTO();
        $parking = new Parking();
        // Je demande à créer un formulaire grâce à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(ParkingDTOType::class, $parkingDTO);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $tvShow
        // Si des données ont été soumises dans le formulaire
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $parking->setName($parkingDTO->name);
            $parking->setLocalisation($parkingDTO->localisation);
            $manager->persist($parking);
            for ( $i =0; $i<$parkingDTO->nbPlace; $i++ ) {
                $slot = new ParkingSpace();
                $slot->setParking($parking);
                $slot->setWidth($parkingDTO->placeWidth);
                $slot->setHeight($parkingDTO->placeHeight);
                $manager->persist($slot);
            }
            // Si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager->flush();
            $this->addFlash("success", "Le Parking a bien été ajoutée");
            return $this->redirectToRoute('parking');
        }
        // On envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'parking/add.html.twig',
            [
                "parkingForm" => $form->createView()
            ]
        );
    }
}
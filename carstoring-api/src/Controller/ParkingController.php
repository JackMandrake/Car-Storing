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
    public function index(Request $request)
    {
        $search = $request->query->get('search');

        /** @var ParkingRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Parking::class);
        $parkings = $repository->findAll($search);

        return $this->render('parking/parking.html.twig', [
            "parkings" => $parkings,
        ]);
    }

    /**
     * @Route("/parking/{id}", name="parking_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var ParkingRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Parking::class);
        $parking = $repository->find($id);
        
        return $this->render('parking/view.html.twig', ["parking" => $parking]);
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

    /**
     * @Route("/parking/{id}/update", name="parking_update", requirements={"id"="\d+"})
     */
    public function update( $id, Request $request)
    {
        /** @var ParkingRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Parking::class);
        $parking = $repository->find($id);

        $parkingDTO = new ParkingDTO();
        $parkingDTO->name = $parking->getName();
        $parkingDTO->localisation = $parking->getLocalisation();
        $parkingSpace = $parking->getParkingSpace();
        $parkingDTO->nbPlace = count($parkingSpace);
        if (count($parkingSpace)> 0) {
            $parkingDTO->height = $parkingSpace[0]->getHeight();
            $parkingDTO->width = $parkingSpace[0]->getWidth();
        }

        
        $parkingForm = $this->createForm(ParkingDTOType::class, $parkingDTO);
        $parkingForm->handleRequest($request);

        if($parkingForm->isSubmitted() && $parkingForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $parking->setName($parkingDTO->name);
            $parking->setLocalisation($parkingDTO->localisation);

            foreach ($parking->getParkingSpace() as $places) {
                $manager->remove($places);
            } 
            for ( $i =0; $i<$parkingDTO->nbPlace; $i++ ) {
                $slot = new ParkingSpace();
                $slot->setParking($parking);
                $slot->setWidth($parkingDTO->placeWidth);
                $slot->setHeight($parkingDTO->placeHeight);
                $manager->persist($slot);
            }

            $manager->flush();
            $this->addFlash("success", "Le parking a bien été modifié");
            return $this->redirectToRoute("parking", ["id" => $parking->getId()]);
        }

        return $this->render(
            'parking/update.html.twig',
            [
                "parkingForm" => $parkingForm->createView(),
                "parking" => $parking
            ]
        );
    }
}
<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Parking;
use App\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
   
    /**
     * @Route("/car", name="car")
     */
    public function index(Request $request)
    {
        $search = $request->query->get('search');

        /** @var CarRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Car::class);
        $cars = $repository->findAll($search);

        return $this->render('car/car.html.twig', [
            "cars" => $cars,
        ]);
    }

    /**
     * @Route("/car/{id}", name="car_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var CarRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Car::class);
        $car = $repository->find($id);
        
        return $this->render('car/view.html.twig', ["car" => $car]);
    }

    /**
     * @Route("/car/add", name="car_add")
     */
    public function add(Request $request)
    {
        // Je crée un objet
        $car = new Car();

        // Je demande à créer un formulaire grâce à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(CarType::class, $car);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $tvShow

        // Si des données ont été soumises dans le formulaire
        if($form->isSubmitted() && $form->isValid()) {
            // Si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($car);
            $manager->flush();
            $this->addFlash("success", "Le Véhicule a bien été ajoutée");
            return $this->redirectToRoute('car');
        }

        // On envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'car/add.html.twig',
            [
                "carForm" => $form->createView()
            ]
        );
    }
}

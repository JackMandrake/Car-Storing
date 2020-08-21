<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Parking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StoringController extends AbstractController
{
    /**
     * @Route("/storing", name="storing")
     */
    public function index()
    {
        /** @var CarRepository $carRepository */
        $carRepository = $this->getDoctrine()->getRepository(Car::class);
        $cars = $carRepository->findByParkingNull();

        /** @var ParkingRepository $parkingRepository */
        $parkingRepository = $this->getDoctrine()->getRepository(Parking::class);
        $parkings = $parkingRepository->findAll();

        return $this->render('storing/storing.html.twig', [
            'cars' => $cars,
            'parkings' => $parkings
        ]);
    }
    
    /**
     * @Route("/storing/move", name="storing_move")
     */
    public function park(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $idCar = $request->get('idCar');
            $idParking = $request->get('idParking');
            $parkingRepository = $this->getDoctrine()->getRepository(Parking::class);
            $carRepository = $this->getDoctrine()->getRepository(Car::class);
            $parking = $parkingRepository->findOneBy([
                'id'=> $idParking
            ]);
            $car = $carRepository->findOneBY([
                'id'=> $idCar
            ]);

            $nbCars = count($parking->getCars());
            $nbPlace = count($parking->getParkingSpace()); 
            
            if ( $nbCars < $nbPlace ) {
                $parking->addCar($car);
                $manager = $this->getDoctrine()->getManager();
                $manager->flush();
                return new Response("succes", 200);
            } else {
                $this->addFlash("warning", "Le parking est plein");
                return new Response("error", 401);
            }
        }
    }

    /**
     * @Route("/storing/remove", name="storing_remove")
     */
    public function unpark(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $idCar = $request->get('idCar');
            
            $carRepository = $this->getDoctrine()->getRepository(Car::class);
        
            $car = $carRepository->findOneBY([
                'id'=> $idCar
            ]);
            $car->setParking(null);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response("succes", 200);
        }
        
    } 

}
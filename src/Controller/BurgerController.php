<?php

namespace App\Controller;

use App\Entity\Pain;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Burger;

#[Route('/burger')]
class BurgerController extends AbstractController
{
    private $dataBurger = [
        'burger_vip' => [
            'name' => 'Burger vip',
            'detail' => 'le burger de bob l\'éponge'
        ],
        'burger_legend' => [
            'name' => 'Burger legend',
            'detail' => 'le burger du goat patrick'
        ]
    ];

    #[Route('/', name: 'burger')]
    public function index(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();

        //return $this->render('burgers_list.html.twig', ['listeBurger' => $this->dataBurger]);
        return $this->render('burger/index.html.twig', ['burgers' => $burgers]);
    }


    #[Route('/data/{id}', name: 'burger_id')]
    public function show($id): Response
    {
        $burgerExist = in_array($id, array_keys($this->dataBurger));


        if ($burgerExist) {
            return $this->render('burger_show.html.twig', ['dataBurger' => $this->dataBurger[$id], 'id' => $id]);
        }

        return $this->render('burger_error.html.twig', ['listeBurger' => $this->dataBurger]);
    }

    #[Route('/create', name: 'create_burger')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $burger = new Burger();
        $burger->setName('Burger vip');
        $burger->setId(1);
        $burger->setPrice(9.99);
        $burger->setPain($entityManager->getRepository(Pain::class)->find(1));

        $entityManager->persist($burger);
        $entityManager->flush();

        return new Response('Burger créé avec succès !');
    }
}
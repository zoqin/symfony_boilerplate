<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function list(): Response
    {

        return $this->render('burgers_list.html.twig', ['listeBurger' => $this->dataBurger]);
    }

    #[Route('/{id}', name: 'burger_id')]
    public function show($id): Response
    {
        $burgerExist = in_array($id, array_keys($this->dataBurger));

        if ($burgerExist) {
            return $this->render('burger_show.html.twig', ['dataBurger' => $this->dataBurger[$id], 'id' => $id]);
        }

        return $this->render('burger_error.html.twig', ['listeBurger' => $this->dataBurger]);
    }
}
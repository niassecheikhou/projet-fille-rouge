<?php

namespace App\Controller;


use App\Entity\Menu;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    #[Route('/api/menus2', name: 'app_menu')]

    public function __invoke(Request $request,EntityManagerInterface $entityManager,BurgerRepository $burgerRepository)

    {
        $context=$request->getContent();
        $tab=json_decode($context);

        // dd($tab->burgers[0]->burger(0));
        if (!isset($tab->nomProduit)) {
            

            return $this->json('nom du produit obligatoire',400);
        }
            $menus=new Menu();
            $menus->setNomProduit($tab->nomProduit);
            $menus->setPrix($tab->prix);
            foreach ($tab-> menuBurgers as $burg) {
                $burger=$burgerRepository->find($burg->burger);
                // dd($burger);
                if ($burger) {
                    $menus->addBurger($burg,$burg->quantiteProduit);
                }
            }
            $entityManager->persist( $menus);
            $entityManager->flush();
            return  $this->json('Succes',201);

        // return $this->render('menu/index.html.twig', [
        //     'message' => 'Bien venu dans votre controller MenuController',
        //     'path'=>"src/Controller/MenuController"
        // ]);
    }

   
}

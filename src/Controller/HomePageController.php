<?php

namespace App\Controller;


use App\Form\MenuSearchType;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomePageController extends AbstractController
{
    /**
     * @Route("/home_page", name="home", methods={"GET","POST"})
     */
    public function index(Request $request, MenuRepository $menuRepository): Response
    {
        $sauces = $menuRepository->findAllSauces();
        $drinks = $menuRepository->findAllDrink();

        $bases = $menuRepository->findAllBases();
        $ba = call_user_func_array('array_merge', $bases);//affiche un seul tableau avec toutes les valeurs

        $extras = $menuRepository->findAllExtra();
        $ex = call_user_func_array('array_merge', $extras);

        $menuSearchForm = $this->createForm(MenuSearchType::class, null, [
            'sauce' => ($sauces),
            'base' => array_unique($ba), // array_unique retire les valeurs en doublon
            'extra' => array_unique($ex),
            'drink' => ($drinks)
        ]);
        $menuSearchForm->handleRequest($request);
        if ($menuSearchForm->isSubmitted() && $menuSearchForm->isValid()) {

            $sauce = $menuSearchForm->getData() ['sauce'];
            $base = $menuSearchForm->getData() ['base'];
            $drink = $menuSearchForm->getData() ['drink'];
            $extra = $menuSearchForm->getData() ['extra'];
        }
        return $this->render('home_page/index.html.twig', [
            'menu' => empty($sauce) && empty($base) && empty($drink) && empty($extra) ? $menuRepository->findAll() :
                $menuRepository->findBySauceAndBaseAndDrinkAndExtra($sauce, $base, $drink, $extra),
            'menuSearchForm' => $menuSearchForm->createView()
        ]);
    }


}

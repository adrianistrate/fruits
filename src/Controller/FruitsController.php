<?php

namespace App\Controller;

use App\Entity\Fruit;
use App\Form\FruitFilterType;
use App\Repository\FruitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class FruitsController extends AbstractController
{
    #[Route('/', name: 'app_fruits')]
    public function index(Request $request, FruitRepository $fruitRepository, PaginatorInterface $paginator): Response
    {
        $page = $request->query->getInt('page', 1);
        $form = $this->createForm(FruitFilterType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filterData = $form->getData();
            $qb = $fruitRepository->prepareForPagination($filterData);
        } else {
            $qb = $fruitRepository->findAll();
        }

        $queryParams = ['fruit_filter' => $request->query->all()['fruit_filter'] ?? null];

        $pagination = $paginator->paginate($qb, $page, 5);

        return $this->render('fruits/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
            'queryParams' => $queryParams,
        ]);
    }

    #[Route('/add-to-favorites/{id}/{action}', name: 'app_fruits_manage_favorites', requirements: ['id' => '\d+', 'action' => 'add|remove'], methods: ['POST'])]
    public function addToFavorites(Request $request, Fruit $fruit, Session $session): Response
    {
        $favorites = $session->get('favorites', []);

        if (!$this->isCsrfTokenValid('add-to-favorites', $request->request->get('_token'))) {
            $this->addFlash('error', 'Invalid CSRF token!');

            return $this->redirectToRoute('app_fruits');
        }

        switch ($request->attributes->get('action')) {
            case 'add':
                if (count($favorites) < 10 && !in_array($fruit->getId(), $favorites, true)) {
                    $favorites[] = $fruit->getId();
                    $session->set('favorites', $favorites);

                    $this->addFlash('success', 'Fruit added to favorites!');
                } else {
                    $this->addFlash('error', 'Fruit not added to favorites!');
                }
                break;
            case 'remove':
                if (in_array($fruit->getId(), $favorites, true)) {
                    $favorites = array_diff($favorites, [$fruit->getId()]);
                    $session->set('favorites', $favorites);

                    $this->addFlash('success', 'Fruit removed from favorites!');
                } else {
                    $this->addFlash('error', 'Fruit not removed from favorites!');
                }
                break;
        }

        return $this->redirectToRoute('app_fruits');
    }

    #[Route('/favorites', name: 'app_favorites')]
    public function favorites(Request $request, FruitRepository $fruitRepository, PaginatorInterface $paginator): Response
    {
        $favorites = $request->getSession()->get('favorites', []);

        $favoriteFruits = $fruitRepository->findFavorites($favorites);
        $nutritionStats = $fruitRepository->getNutritionStats($favorites);

        return $this->render('fruits/favorites.html.twig', [
            'favoriteFruits' => $favoriteFruits,
            'nutritionStats' => $nutritionStats,
        ]);
    }
}

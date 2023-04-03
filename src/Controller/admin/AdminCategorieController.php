<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controleur des categories en mode administrateur
 *
 * @author vince
 */
class AdminCategorieController extends AbstractController{
    
    /**
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    /**
     * 
     * @param CategorieRepository $categorieRepository
     */
    function __construct(CategorieRepository $categorieRepository) {
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * @Route("/admin/categories", name="admin.categories")
     * @return Response
     */
    public function index(): Response{
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories
        ]);
    }
    
    /**
     * @Route("/admin/categorie/suppr/{id}", name="admin.categorie.suppr")
     * @param Categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie): Response {
        if (count($categorie->getFormations()) == 0) {
            $this->categorieRepository->remove($categorie, true);
        }
        return $this->redirectToRoute('admin.categories');
    }
    
    /**
     * @Route("/admin/categorie/ajout", name="admin.categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $nameCategorie = $request->get("name");
        $existingCategory = $this->categorieRepository->findOneBy(['name' => $nameCategorie]);
        if ($existingCategory) {
        return $this->redirectToRoute('admin.categories');
        }
        $categorie = new Categorie();
        $categorie->setName($nameCategorie);
        $this->categorieRepository->add($categorie, true);
        return $this->redirectToRoute('admin.categories');
    }
}

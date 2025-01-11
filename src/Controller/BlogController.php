<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\User;
use App\Entity\Users;
use App\Form\ArticlesType;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\SignUpType;
use App\Service\Article\ArticleService;
use Doctrine\Persistence\ManagerRegistry;
// use Html2Text\Html2Text;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class BlogController extends AbstractController
{
    private $security;
    public $id;
    public function __construct(Security $security, ArticleService $id)
    {

        $this->security = $security;
        $this->id = $id;
        
    }
    #[Route('/', name: 'accueil')]
    public function index(ArticleService $service): Response{
        if($this->security->getUser()){
            return $this->redirectToRoute('user_page');
        }
        $articles = $service->getAllArticles();
        // on converti en texte le texte html qui est en base de données 
        // $html2text = new \Html2Text\Html2Text($articles);
        // $html2text->getText();



        return $this->render('blog/index.html.twig', [
            'message'=>'C\'est l\'acceuil',
            'articles'=> $articles,
        ]);

    }



    #[Route('/creation-blog/{id}', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine,int $id ): Response{
        $idUrl = $request->attributes->get('id');
        $idUser = $this->security->getUser();
        if(!$this->security->getUser()){
            return $this->redirectToRoute('accueil');
        }
        $articles= new Articles();
        // on récupère l'id en paramètre pour le comparer a l'id de l'utilisateur en base de donnée 
        // si les id sont différents c'est que l'utilisateurs n'est pas a la bonne page create on doit dont le rediriger vers la page user
        // dd($idUrl);



        

        // on charge l'objet avec une dueDate
        $articles->setPublicationDate(new \DateTime('now'));
        // on charge l'objet avec une image 
        // dd($this->id->getAllArticless());

        $form =$this->createForm(ArticlesType::class, $articles, [
            'method'=>'POST'
        ]);
        $form = $this->createForm(ArticlesType::class, $articles);
        // occupe toi de la requette form 
        $form ->handleRequest($request);
        // si ya des truc il va faire se qu'il faut pour valider
        
        if($form->isSubmitted() && $form->isValid()) {
            $articles->setUserId($id);

            $articles = $form->getData();
            $doctrine->getManager()->persist($articles);
            $doctrine->getManager()->flush();
            
            $this->addFlash('success', "Article créé avec succès ! Vous êtes un Shakespeare des temps modernes !");
            return $this->redirectToRoute('user_page');
            
        }
        return $this->render('blog/create.html.twig', [
            'form' => $form,
            'idUrl'=>$idUrl,
            'idUser'=>$idUser,
        ]);

    }



    #[Route('/utilisateur', name: 'user_page')]
    public function page(ArticleService $service): Response{

        if(!$this->security->getUser()){
            return $this->redirectToRoute('accueil');
        }


        return $this->render('blog/user-page.html.twig', [
            'article'=>$service->getAllArticles(),
        ]);
    }

    #[Route('/blog/{id}', name: 'page_blog')]
    public function pageBlog(ArticleService $service, int $id): Response{
        if(!$this->security->getUser()){
            return $this->redirectToRoute('accueil');
        }
        return $this->render('blog/blog-user.html.twig', [
            'blog'=>$service->getOneArticles($id),
        ]);
    }

    #[Route('article/supprimer/{id}', name: 'supprimer_page_blog')]
    public function supprimerPageBlog(ArticleService $service, int $id): RedirectResponse{
        if($service->deleteOneArticles($id)){
            $this->addFlash('success', 'Tache supprimée');
        }else{
            $this->addFlash('error', 'Tache na pas été supprimer');
        }
        return $this->redirectToRoute('user_page');
    }

    

}
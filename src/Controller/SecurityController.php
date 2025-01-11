<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\Article\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $security;
    private $user;
    public function __construct(Security $security, User $user)
    {

        $this->security = $security;
        $this->user = $user;
        
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,Request $request,ArticleService $service): Response | RedirectResponse
    {

        if($this->security->getUser()){
            // dd($this->user);
            // dd($this->security->getUser());
            return $this->redirectToRoute('user_page');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
  

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $service->getAllArticles();
            dd($article);

            $lastUsername = $authenticationUtils->getLastUsername();
            $this->addFlash('success', "Heureux de vous re voir !");
            return $this->render('blog/user-page.html.twig', [
                'article'=> $article,

            ]);
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

     #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

     #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
      if ($request->isMethod('POST')){
          if (!empty($request->request->get('password'))
              && !empty($request->request->get('password2'))
              && $request->request->get('password') === $request->request->get ('password2')){

              $user = new User();
              $user->setFirstName ($request->request->get('firstName'))
                  ->setLastName ($request->request->get('LastNane'))
                  ->setEmail($request->request->get('email'))
                  ->setPassword($hasher->hashPassword($user, $request->request->get('password')));

              $entityManager->persist($user);
              $entityManager->flush();

              return $this->redirectToRoute('app_user_show', [
                'email' => $user->getEmail()
              ]);
          }

          return $this->render('security/register.html.twig', [
              'error' => 'Les deux password ne sont pas identiques'
          ]);
      }
      return $this->render('security/register.htmt.twig') ;
    }

}

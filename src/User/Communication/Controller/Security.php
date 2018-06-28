<?php


namespace App\User\Communication\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Security extends Controller
{
    /**
     * @Route("/", name="login")
     * @param Request             $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     *
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout(): void
    {
        throw new \RuntimeException('This should never be reached!');
    }

    /**
     * ONLY A PLACEHOLDER, FOR INDEX PAGE
     * @Route("/dashboard", name="dashboard")
     *
     * @param Request $request
     * @return Response
     */
    public function placeHolderFunction(Request $request): Response
    {
        return $this->render('base.html.twig');
    }
}
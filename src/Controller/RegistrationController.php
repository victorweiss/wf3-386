<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request, 
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGeneratorInterface $tokenGenerator,
        EmailService $emailService
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user
                ->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ))
                ->setToken($tokenGenerator->generateToken())
            ;

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Envoyer email
            $emailService->registrationConfirmEmail($user);
            
            // Confirmation
            $this->addFlash('success', "Nous vous avons envoyé un email à l'adresse ... Merci de cliquer sur le lien pour valider votre compte."); 
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register-confirm-email/{email}/{token}", name="register_confirm_email")
     */
    public function registerConfirmEmail(
        $email,
        $token,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        Request $request,
        GuardAuthenticatorHandler $guardHandler,
        AppAuthenticator $authenticator
    ) {
        $user = $userRepository->findUserConfirmEmail($email, $token);
        if (!$user) throw new NotFoundHttpException("Compte non trouvé");

        $user
            ->setActive(1)
            ->setToken($tokenGenerator->generateToken())
        ;

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );
    }

}

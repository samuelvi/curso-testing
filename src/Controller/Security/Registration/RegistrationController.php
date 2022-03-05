<?php

namespace App\Controller\Security\Registration;

use App\Context\Security\Form\RegistrationFormType;
use App\Context\Security\PasswordEncoder\PasswordEncoder;
use App\Context\Security\Verification\VerificationNotifier;
use App\Entity\UserEntity;
use App\Repository\User\UserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private VerificationNotifier $verificationNotifier;
    private UserCommand          $userCommand;
    private PasswordEncoder      $passwordEncoder;

    public function __construct(
        VerificationNotifier $verificationNotifier,
        UserCommand $userCommand,
        PasswordEncoder $passwordEncoder
    ) {
        $this->verificationNotifier = $verificationNotifier;
        $this->userCommand = $userCommand;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="app_register")
     */
    public function __invoke(Request $request): Response
    {
        $userEntity = new UserEntity();
        $form = $this->createForm(RegistrationFormType::class, $userEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->stablishEncodedPasswordToUser($userEntity, $form->get('plainPassword')->getData());

            $this->userCommand->saveUser($userEntity);
            $this->verificationNotifier->notify($userEntity);

            return $this->redirectToRoute('app_register_ok');
        }

        return $this->render('security/registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function stablishEncodedPasswordToUser(UserEntity $userEntity, $plainPassword): void
    {
        $userEntity->setPassword($this->passwordEncoder->encode($userEntity, $plainPassword));
    }
}

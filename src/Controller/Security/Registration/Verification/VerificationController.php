<?php

declare(strict_types=1);

namespace App\Controller\Security\Registration\Verification;

use App\Context\Security\Verification\VerificationHandler;
use App\Repository\User\UserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

final class VerificationController extends AbstractController
{
    private UserQuery     $userQuery;
    private VerificationHandler $verificationHandler;

    public function __construct(UserQuery $userQuery, VerificationHandler $verificationHandler)
    {
        $this->userQuery = $userQuery;
        $this->verificationHandler = $verificationHandler;
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function __invoke(Request $request): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->userQuery->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        try {
            $this->verificationHandler->handle($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_sign_in');
    }
}

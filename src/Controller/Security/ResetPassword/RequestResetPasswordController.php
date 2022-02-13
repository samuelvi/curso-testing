<?php

namespace App\Controller\Security\ResetPassword;

use App\Context\Security\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * @Route("/reset-password")
 */
class RequestResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private ResetPasswordHelperInterface $resetPasswordHelper;


    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * @Route("", name="app_forgot_password_request")
     */
    public function __invoke(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer
            );
        }

        return $this->render('security/reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): RedirectResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('app_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     'There was a problem handling your password reset request - %s',
            //     $e->getReason()
            // ));

            return $this->redirectToRoute('app_check_email');
        }

        $email = (new TemplatedEmail())
            ->from(new Address('symfonyfue@admin.com', 'Symfony FUE'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('security/reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ]);

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('app_check_email');
    }
}

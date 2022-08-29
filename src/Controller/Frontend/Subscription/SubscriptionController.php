<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Subscription;

use App\Annotation\Tracker;
use App\Context\Frontend\Subscription\Form\Type\SubscriptionType;
use App\Context\Frontend\Subscription\Handler\SubscriptionHandler;
use App\Entity\SubscriptionEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    private SubscriptionHandler $subscriptionHandler;

    public function __construct(SubscriptionHandler $subscriptionHandler)
    {
        $this->subscriptionHandler = $subscriptionHandler;
    }

    /**
     * @Route("/subscription/add", name="subscription_add")
     * @Tracker(subject="New Subscription")
     */
    public function __invoke(Request $request): Response
    {

        $subscriptionEntity = new SubscriptionEntity();
        $form = $this->createForm(SubscriptionType::class, $subscriptionEntity);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->render('frontend/subscription/subscription_form.html.twig', ['form' => $form->createView()]);
        }

        if ($form->isValid()) {

            $this->subscriptionHandler->handle($form->getData());

            $response = [
                'response' => [
                    'state' => 'OK',
                    'view' => $this->renderView('frontend/subscription/subscription_ok.html.twig'),
                ],
            ];
        } else {
            $form->addError(new FormError('The subscription could not be created'));

            // Build Error Response
            $response = [
                'response' => [
                    'state' => 'ERROR',
                    'view' => $this->renderView('frontend/subscription/subscription_form.html.twig',
                        ['form' => $form->createView()]
                    ),
                ],
            ];
        }

        return new JsonResponse($response);
    }
}

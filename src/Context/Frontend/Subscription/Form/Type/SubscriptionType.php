<?php
declare(strict_types=1);

namespace App\Context\Frontend\Subscription\Form\Type;

use App\Entity\SubscriptionEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email', TextType::class,
            [
                'label' => false,
                'required' => true,
            ]
        );

        $builder->add(
            'fullname', TextType::class,
            [
                'label' => false,
                'required' => true,
            ]
        );

        $builder->add(
            'legal', CheckboxType::class,
            [
                'required' => true,
                'mapped' => false,
            ]
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }

    public function onPostSubmit(FormEvent $event)
    {
        /** @var FormInterface $form */
        $form = $event->getForm();
        if (null === $form) {
            return;
        }

        $legal = $form->get('legal');
        if (!$legal->getData()) {
            $legal->addError(new FormError('You must accept terms and conditions'));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubscriptionEntity::class,
            'attr' => [
                'id' => $this->getBlockPrefix(),
            ],
            'custom_parameters' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'subscription_type';
    }
}

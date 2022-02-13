<?php

namespace App\Context\Frontend\ContactForm\Form;

use App\Model\ContactDetailModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email', TextType::class,
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'fullname', TextType::class,
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'subject', TextType::class,
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'message', TextareaType::class,
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'terms', CheckboxType::class,
            array(
                'label' => 'Accept terms and conditions *',
                'required' => true,
                'mapped' => true,
            )
        );

        $builder->add(
            'newsletter', CheckboxType::class,
            array(
                'label' => 'Subscribe to Newsletter',
                'required' => false,
                'mapped' => true,
            )
        );

    }

    // Prevent bad data from entering the message attribute by filtering it
    public function setMessage($message) {
        $this->message = strip_tags($message);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ContactDetailModel::class,
            'attr' => array(
                'id' => $this->getBlockPrefix()
            ),
            'custom_parameters' => null,
        ));
    }
}

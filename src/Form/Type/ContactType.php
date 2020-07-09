<?php

namespace App\Form\Type;

use App\Form\Request\ContactRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as NativeType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', NativeType\TextType::class)
            ->add('telephone', NativeType\TextType::class)
            ->add('email', NativeType\EmailType::class)
            ->add('note', NativeType\TextareaType::class, [
                'attr' => ['rows' => 20, 'cols' => 40]
            ])
            ->add('save', NativeType\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactRequest::class,
        ]);
    }
}

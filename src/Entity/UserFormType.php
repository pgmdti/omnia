<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 10/04/2018
 * Time: 12:06
 */

namespace App\Entity;


use App\Entity\dai\rh\Cargo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricula', NumberType::class)
            ->add('nome', TextType::class)
            ->add('cargo', EntityType::class, array(
                    'placeholder' => 'Selecione...',
                    'class' => Cargo::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.descricao', 'ASC');
                    },
                    'choice_label' => 'descricao',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'empty_data' => null
                )
            )
            ->add('lotacao', EntityType::class, array(
                    'placeholder' => 'Selecione...',
                    'class' => Lotacao::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.descricao', 'ASC');
                    },
                    'choice_label' => 'descricao',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => true,
                    'empty_data' => null
                )
            )
        ;
    }

    public function getParent()

    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()

    {
        return 'app_user_registration';
    }

    public function getName()

    {
        return $this->getBlockPrefix();
    }
}
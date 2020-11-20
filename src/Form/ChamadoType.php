<?php

namespace App\Form;

use App\Entity\Dti\Chamado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChamadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('descricao')
            ->add('status')
            ->add('datacadastro')
            ->add('dataabertura')
            ->add('datafechamento')
            ->add('solucaoadotada')
            ->add('departamento')
            ->add('responsavel')
            ->add('criado_por')
            ->add('solicitado_por')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chamado::class,
        ]);
    }
}

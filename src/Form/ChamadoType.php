<?php

namespace App\Form;

use App\Entity\dai\rh\Departamento;
use App\Entity\dai\rh\Employee;
use App\Entity\Dti\Chamado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChamadoType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class)
            ->add('status', ChoiceType::class, [
                'placeholder' => 'Status',
                'choices' => [
                    'Aberto' => 'aberto',
                    'Em andamento' => 'andamento',
                    'Resolvido' => 'resolvido',
                    'Não Resolvido' => 'nao_resolvido',
                ]
            ])
            ->add('descricao', TextareaType::class, array())
            ->add('datacadastro', DateType::class, array(
                'placeholder' => 'Data de cadastro',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']))
            ->add('dataabertura', DateType::class, array(
                'placeholder' => 'Data de abertura',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']))
            ->add('datafechamento', DateType::class, array(
                'placeholder' => 'Data de fechamento',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']))
            ->add('solucaoadotada')
            ->add('responsavel', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'nome',
            ])
            ->add('departamento', EntityType::class, [
                'class' => Departamento::class,
                'choice_label' => 'nome',
            ])
            ->add('criado_por', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'nome',
            ])
            ->add('solicitado_por', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'nome',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chamado::class,
        ]);
    }
}

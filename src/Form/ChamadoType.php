<?php

namespace App\Form;

use App\Entity\dai\rh\Employee;
use App\Entity\Dti\Chamado;
use App\Entity\Lotacao;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ChamadoType extends AbstractType
{

    public function __construct(TokenStorageInterface $tokenStorage, EmployeeRepository $employeeRepository)
    {
        $this->user = $tokenStorage->getToken('security.token_storage')->getUser();
        $this->employee = $employeeRepository->findOneBy(array('matricula', $this->user->getMatricula()));
//        $this->debug_to_console($this->user);
    }

    /**
     * Simple helper to debug to the console
     *
     * @param  Array, Object, String $data
     * @return String
     */
    function debug_to_console( $data ) {

        $output = '';

        if ( is_array( $data ) ) {
            $output .= "<script>console.warn( 'Debug Objects with Array.' ); console.log( '" . implode( ',', $data) . "' );</script>";
        } else if ( is_object( $data ) ) {
            $data    = var_export( $data, TRUE );
            $data    = explode( "\n", $data );
            foreach( $data as $line ) {
                if ( trim( $line ) ) {
                    $line    = addslashes( $line );
                    $output .= "console.log( '{$line}' );";
                }
            }
            $output = "<script>console.warn( 'Debug Objects with Object.' ); $output</script>";
        } else {
            $output .= "<script>console.log( 'Debug Objects: {$data}' );</script>";
        }

        echo $output;
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
                'required' => false,
                'placeholder' => 'Data de fechamento',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']))
            ->add('solucaoadotada')
            ->add('responsavel', EntityType::class, [
                'required' => false,
                'class' => Employee::class,
                'choice_label' => 'nome',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('u')->orderBy('u.nome', 'ASC');
                }
            ])
            ->add('departamento', EntityType::class, [
                'class' => Lotacao::class,
                'choice_label' => 'descricao',
            ])
            ->add('criado_por', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'nome',
//                'query_builder' => function(EntityRepository $er){
//                    return $er->createQueryBuilder('u')->where('u.id = ?1')->setParameter(1, $this->user);
//                }
            ])
            ->add('solicitado_por', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'nome',
                'query_builder' => function(EntityRepository $er){
//                    $employee = $this->
                    return $er->createQueryBuilder('u')->orderBy('u.nome', 'ASC');
                }
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

<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 16/04/2018
 * Time: 12:46
 */

namespace App\Controller\dai\rh;


use App\Entity\{
    dai\rh\Employee, dai\rh\Tipoausencia, dai\rh\Ausencia
};
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AusenciaController
 * @package App\Controller\dai\rh
 */
class AusenciaController extends Controller
{
    /**
     * @Route("/dai/rh/afastamento/novo", name="dai_rh_afastamento_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $ausencia = new Ausencia();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($ausencia)
            ->add('employee', EntityType::class, array(
                'placeholder' => 'Escolha...',
                'class' => Employee::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nome', 'ASC');
                },
                'choice_label' => 'nome',
                'required' => true,
                'empty_data' => null
            ))
            ->add('tipoausencia', EntityType::class, array(
                'placeholder' => 'Escolha...',
                'class' => Tipoausencia::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.descricao', 'ASC');
                },
                'choice_label' => 'descricao',
                'required' => true,
                'empty_data' => null
            ))
            ->add('descricao', TextareaType::class, array(
                'required' => false,
                'empty_data' => null
            ))
            ->add('dataini', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']
            ))
            ->add('datafim', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ausencia = $form->getData();
            $entityManager->persist($ausencia);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_afastamento_index');
        }

        return $this->render("dai/rh/afastamento/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/dai/rh/afastamento/editar/{id}", name="dai_rh_afastamento_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $ausencia = $this->getDoctrine()
            ->getRepository(Ausencia::class)
            ->find($id);

        $form = $this->createFormBuilder($ausencia)
            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('employee', EntityType::class, array(
                'placeholder' => 'Escolha...',
                'class' => Employee::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nome', 'ASC');
                },
                'choice_label' => 'nome',
                'required' => true,
                'empty_data' => null
            ))
            ->add('tipoausencia', EntityType::class, array(
                'placeholder' => 'Escolha...',
                'class' => Tipoausencia::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.descricao', 'ASC');
                },
                'choice_label' => 'descricao',
                'required' => true,
                'empty_data' => null
            ))
            ->add('descricao', TextareaType::class)
            ->add('dataini', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']
            ))
            ->add('datafim', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ausencia = $form->getData();
            $entityManager->persist($ausencia);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_afastamento_index');
        }

        return $this->render("dai/rh/afastamento/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/afastamento/deletar/{id}", name="dai_rh_afastamento_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $ausencia = $this->getDoctrine()
            ->getRepository(Ausencia::class)
            ->find($id);

        $entityManager->remove($ausencia);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_afastamento_index');

    }


    /**
     * @Route ("/dai/rh/afastamentos", name="dai_rh_afastamento_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder()
            ->select('u')
            ->from(Ausencia::class, 'u')
            ->innerJoin('u.tipoausencia', 'b')
            ->innerJoin('u.employee', 'c')
            ->orderBy('u.dataini', 'DESC')
            ->orderBy('c.nome', 'ASC');

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );


        return $this->render("dai/rh/afastamento/index.html.twig", array(
            'tiposausencia' => $result
        ));
    }
}
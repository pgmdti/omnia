<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 21/09/18
 * Time: 11:12
 */

namespace App\Controller\dti\equipamento;


use App\Entity\dti\Equipamento;
use App\Entity\dti\Marca;
use App\Entity\dti\Status;
use App\Entity\dti\TipoEquipamento;
use App\Entity\Lotacao;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class EquipamentoController extends Controller
{


    /**
     * @Route("/dti/equipamento", name="dti_equipamento_index")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder()
            ->select('u.id, u.serial, u.titulo, b.descricao, c.marca, d.status, e.descricao as lotacao')
            ->from(Equipamento::class, 'u')
            ->innerJoin('u.tipo', 'b', 'WITH', 'b.id = u.tipo')
            ->innerJoin('u.marca', 'c', 'WITH', 'c.id = u.marca')
            ->leftJoin('u.status', 'd', 'WITH', 'd.id = u.status')
            ->leftJoin('u.lotacao', 'e', 'WITH', 'e.id = u.lotacao')
            ->orderBy('u.id');

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 8)
        );


        return $this->render("dti/equipamento/index.html.twig", array(
            'eqpto' => $result
        ));
    }



    /**
     * @Route("/dti/equipamento/novo", name="dti_equipamento_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request)
    {

        $equipamento = new Equipamento();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($equipamento)
            ->add('titulo', TextType::class, array(
                'required' => true,
            ))
            ->add('descricao', TextareaType::class, array(
                'required' => false,
            ))
            ->add('serial', TextType::class, array(
                'required' => true,
            ))
            ->add('lotacao', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => Lotacao::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.descricao', 'ASC');
                },
                'choice_label' => 'descricao',
                'required' => false,
                'empty_data' => null
            ))
            ->add('status', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => Status::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.status', 'ASC');
                },
                'choice_label' => 'status',
                'required' => false,
                'empty_data' => null
            ))
            ->add('marca', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => Marca::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.marca', 'ASC');
                },
                'choice_label' => 'marca',
                'required' => true,
                'empty_data' => null
            ))
            ->add('tipo', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => TipoEquipamento::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.descricao', 'ASC');
                },
                'choice_label' => 'descricao',
                'required' => true,
                'empty_data' => null
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $equipamento = $form->getData();
            $entityManager->persist($equipamento);
            $entityManager->flush();
            return $this->redirectToRoute('dti_equipamento_index');
        }

        return $this->render("dti/equipamento/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dti/equipamento/editar/{id}", name="dti_equipamento_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $equipamento = $this->getDoctrine()
            ->getRepository(Equipamento::class)
            ->find($id);

        $form = $this->createFormBuilder($equipamento)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('titulo', TextType::class, array(
                'required' => true,
            ))
            ->add('descricao', TextareaType::class, array(
                'required' => false,
            ))
            ->add('serial', TextType::class, array(
                'required' => true,
            ))
            ->add('lotacao', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => Lotacao::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.descricao', 'ASC');
                },
                'choice_label' => 'descricao',
                'required' => false,
                'empty_data' => null
            ))
            ->add('status', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => Status::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.status', 'ASC');
                },
                'choice_label' => 'status',
                'required' => false,
                'empty_data' => null
            ))
            ->add('marca', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => Marca::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.marca', 'ASC');
                },
                'choice_label' => 'marca',
                'required' => true,
                'empty_data' => null
            ))
            ->add('tipo', EntityType::class, array(
                'placeholder' => 'Selecione...',
                'class' => TipoEquipamento::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.descricao', 'ASC');
                },
                'choice_label' => 'descricao',
                'required' => true,
                'empty_data' => null
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $equipamento = $form->getData();
            $entityManager->persist($equipamento);
            $entityManager->flush();
            return $this->redirectToRoute('dti_equipamento_index');
        }

        return $this->render("dti/equipamento/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dti/equipamento/deletar/{id}", name="dti_equipamento_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $equipamento = $this->getDoctrine()
            ->getRepository(Equipamento::class)
            ->find($id);

        $entityManager->remove($equipamento);
        $entityManager->flush();
        return $this->redirectToRoute('dti_equipamento_index');

    }
    
}

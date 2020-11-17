<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 17/07/2018
 * Time: 09:59
 */

namespace App\Controller;

use App\Entity\dai\rh\Cargo;
use App\Entity\Lotacao;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{

    /**
     * @Route("/users", name="users_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select("u")
            ->from(User::class, 'u')
            ->leftJoin("u.cargo", "s", "WITH", "s.id = u.cargo")
            ->orderBy('u.nome', 'ASC');
        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render("users/index.html.twig", array(
            'usr' => $result,
        ));

    }

    /**
     * @Route("/user-profile/{id}")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function show($id){



    }

    /**
     * @Route("/user-profile/edit/{id}")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id){

        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('id'=> $id));

        $session = $this->get('session');

        $form = $form = $this->createFormBuilder($user)
            ->add('matricula', NumberType::class)
            ->add('nome', TextType::class)
            ->add('email', TextType::class)
            ->add('username', TextType::class)
            ->add('roles', ChoiceType::class, array(
                'placeholder' => 'Selecione...',
                'choices' => array(
                    'Procurador Geral/Adjunto/Corregedor' => 'ROLE_CGR',
                    'Procurador Chefe de Especializada' => 'ROLE_CHESP',
                    'Procurador' => 'ROLE_ESP',
                    'Analista Administrativo' => 'ROLE_AESP',
                    'DAI (Div Adm Interna)' => 'ROLE_DAI',
                    'DTI (Div Tec Informação)' => 'ROLE_ADMIN',
                ),
                'multiple' => true,
                'expanded' => true,
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
                'expanded' => false,
                'multiple' => true,
                'empty_data' => null
            ))
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
            ))
            ->add('enabled', ChoiceType::class, array(
                    'choices' => array(
                        'Sim' => true,
                        'Nâo' => false,
                    ),
                    'multiple' => false,
                    'expanded' => true,
                ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $userManager->updateUser($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render("users/edit.html.twig", array(
            'form' => $form->createView(),
        ));

    }

}
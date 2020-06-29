<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 30/10/18
 * Time: 08:33
 */

namespace App\Controller\esp\eleicao;


use App\Entity\esp\eleicao\Eleicao;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EleicaoController
 * @package App\Controller\esp\eleicao
 */
class EleicaoController extends Controller
{

    /**
     * @Route("/esp/eleicao/pleito", name="esp_eleicao_pleito_index")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder()
            ->from(Eleicao::class, 'u')
            ->select("u")
            ->orderBy('u.inicio', 'DESC');

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render("esp/eleicao/pleito/index.html.twig", array(
            'eleicao' => $result,
        ));

    }

    /**
     * @Route("/esp/eleicao/pleito/novo", name="esp_eleicao_pleito_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $pleito = new Eleicao();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder($pleito)
            ->add('titulo', TextType::class)
            ->add('inicio', DateTimeType::class)
            ->add('termino', DateTimeType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $pleito = $form->getData();
            $entityManager->persist($pleito);
            $entityManager->flush();
            return $this->redirectToRoute('esp_eleicao_pleito_index');
        }

        return $this->render("esp/eleicao/pleito/novo.html.twig", array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/esp/eleicao/pleito/editar/{id}", name="esp_eleicao_pleito_editar")
     * @param Request $request
     * @param $id
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();
        $pleito = $entityManager->getRepository(Eleicao::class)
            ->find($id);

        $form = $this->createFormBuilder($pleito)
            ->add('titulo', TextType::class)
            ->add('inicio', DateTimeType::class)
            ->add('termino', DateTimeType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $pleito = $form->getData();
            $entityManager->persist($pleito);
            $entityManager->flush();
            return $this->redirectToRoute('esp_eleicao_pleito_index');
        }

        return $this->render("esp/eleicao/pleito/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/esp/eleicao/pleito/deletar/{id}", name="esp_eleicao_pleito_deletar")
     * @param $id
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){
        $entityManager = $this->getDoctrine()->getManager();
        $pleito = $entityManager->getRepository(Eleicao::class)
            ->find($id);
        $entityManager->remove($pleito);
        $entityManager->flush();
        return $this->redirectToRoute('esp_eleicao_pleito_index');
    }

    /**
     * @Route("/esp/eleicao/pleito/votantes/{id}", name="esp_eleicao_pleito_votantes")
     * @param $id
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function votantes($id){

        $entityManager = $this->getDoctrine()->getManager();
        $pleito = $entityManager->getRepository(Eleicao::class)
            ->find($id);

        return $this->render("esp/eleicao/pleito/votantes.html.twig", array(
            'eleicao' => $pleito,
        ));
    }
}
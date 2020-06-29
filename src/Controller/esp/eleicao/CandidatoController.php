<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 30/10/18
 * Time: 11:37
 */

namespace App\Controller\esp\eleicao;


use App\Entity\esp\eleicao\Candidato;
use App\Entity\esp\eleicao\Eleicao;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CandidatoController
 * @package App\Controller\esp\eleicao
 */
class CandidatoController extends Controller
{

    /**
     * @Route("/esp/eleicao/candidato/{pleitoid}", name="esp_eleicao_candidato_index")
     * @param Request $request
     * @param $pleitoid
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, $pleitoid){

        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository(Candidato::class)
            ->findBy(array("eleicao" => $pleitoid));

        $pleito = $em->getRepository(Eleicao::class)
            ->find($pleitoid);
        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render("esp/eleicao/candidato/index.html.twig", array(
                "candidato" => $result,
                "eleicao" => $pleito,
        ));

    }


    /**
     * @Route("/esp/eleicao/candidato/novo/{eleicaoid}", name="esp_eleicao_candidato_novo")
     * @param Request $request
     * @param $eleicaoid
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request, $eleicaoid){

        $entityManager = $this->getDoctrine()->getManager();

        $eleicao = $entityManager->getRepository(Eleicao::class)->find($eleicaoid);

        $candidato = new Candidato($eleicao);

        $form = $this->createFormBuilder($candidato)
            ->add('candidato', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $candidato = $form->getData();
            $entityManager->persist($candidato);
            $entityManager->flush();
            return $this->redirectToRoute('esp_eleicao_candidato_index', array("pleitoid" => $eleicaoid));
        }

        return $this->render("esp/eleicao/candidato/novo.html.twig", array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/esp/eleicao/candidato/editar/{id}", name="esp_eleicao_candidato_editar")
     * @param Request $request
     * @param $id
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();
        $candidato = $entityManager->getRepository(Candidato::class)
            ->find($id);

        $eleicaoid = $candidato->getEleicao()->getId();

        $form = $this->createFormBuilder($candidato)
            ->add('candidato', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $candidato = $form->getData();
            $entityManager->persist($candidato);
            $entityManager->flush();
            return $this->redirectToRoute('esp_eleicao_candidato_index', array("pleitoid" => $eleicaoid));
        }

        return $this->render("esp/eleicao/candidato/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/esp/eleicao/candidato/deletar/{id}", name="esp_eleicao_candidato_deletar")
     * @param $id
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){
        $entityManager = $this->getDoctrine()->getManager();
        $candidato = $entityManager->getRepository(Candidato::class)
            ->find($id);

        $eleicaoid = $candidato->getEleicao()->getId();

        $entityManager->remove($candidato);
        $entityManager->flush();
        return $this->redirectToRoute('esp_eleicao_candidato_index', array("pleitoid" => $eleicaoid));
    }


}
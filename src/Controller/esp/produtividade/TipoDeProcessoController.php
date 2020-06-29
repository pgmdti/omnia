<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 28/05/2018
 * Time: 08:25
 */

namespace App\Controller\esp\produtividade;

use App\Entity\TipoDeProcesso;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TipoDeProcessoController extends Controller
{

    /**
     * @Route("/esp/produtividade/tipo-de-processo", name="esp_produtividade_tipo-de-processo_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder()
            ->from(TipoDeProcesso::class, 'tpc')
            ->select("tpc")
            ->orderBy('tpc.descricao', 'ASC');

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render("esp/produtividade/tipodeprocesso/index.html.twig", array(
            'tprocs' => $result,
        ));
    }


    /**
     * @Route("/esp/produtividade/tipo-de-processo/novo", name="esp_produtividade_tipo-de-processo_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $tipodeprocesso = new TipoDeProcesso();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($tipodeprocesso)
            ->add('descricao', TextType::class)
            ->add('peso', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipodeprocesso = $form->getData();
            $entityManager->persist($tipodeprocesso);
            $entityManager->flush();
            return $this->redirectToRoute('esp_produtividade_tipo-de-processo_index');
        }

        return $this->render("esp/produtividade/tipodeprocesso/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/esp/produtividade/tipo-de-processo/editar/{id}", name="esp_produtividade_tipo-de-processo_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tipodeprocesso = $entityManager->getRepository(TipoDeProcesso::class)
            ->find($id);

        $form = $this->createFormBuilder($tipodeprocesso)
            ->add('descricao', TextType::class)
            ->add('peso', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipodeprocesso = $form->getData();
            $entityManager->persist($tipodeprocesso);
            $entityManager->flush();
            return $this->redirectToRoute('esp_produtividade_tipo-de-processo_index');
        }

        return $this->render("esp/produtividade/tipodeprocesso/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/esp/produtividade/tipo-de-processo/deletar/{id}", name="esp_produtividade_tipo-de-processo_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tipodeprocesso = $entityManager->getRepository(TipoDeProcesso::class)
            ->find($id);
        $entityManager->remove($tipodeprocesso);
        $entityManager->flush();
        return $this->redirectToRoute('esp_produtividade_tipo-de-processo_index');
    }    

}
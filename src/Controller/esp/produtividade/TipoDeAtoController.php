<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 28/05/2018
 * Time: 08:25
 */

namespace App\Controller\esp\produtividade;

use App\Entity\TipoDeAto;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TipoDeAtoController extends Controller
{

    /**
     * @Route("/esp/produtividade/tipo-de-ato", name="esp_produtividade_tipo-de-ato_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder()
            ->from(TipoDeAto::class, 'tpa')
            ->select("tpa")
            ->orderBy('tpa.descricao', 'ASC');

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render("esp/produtividade/tipodeato/index.html.twig", array(
            'tpatos' => $result,
        ));
    }

    /**
     * @Route("/esp/produtividade/tipo-de-ato/novo", name="esp_produtividade_tipo-de-ato_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $tipodeato = new TipoDeAto();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($tipodeato)
            ->add('descricao', TextType::class)
            ->add('peso', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipodeato = $form->getData();
            $entityManager->persist($tipodeato);
            $entityManager->flush();
            return $this->redirectToRoute('esp_produtividade_tipo-de-ato_index');
        }

        return $this->render("esp/produtividade/tipodeato/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/esp/produtividade/tipo-de-ato/editar/{id}", name="esp_produtividade_tipo-de-ato_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tipodeato = $entityManager->getRepository(TipoDeAto::class)
            ->find($id);

        $form = $this->createFormBuilder($tipodeato)
            ->add('descricao', TextType::class)
            ->add('peso', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipodeato = $form->getData();
            $entityManager->persist($tipodeato);
            $entityManager->flush();
            return $this->redirectToRoute('esp_produtividade_tipo-de-ato_index');
        }

        return $this->render("esp/produtividade/tipodeato/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/esp/produtividade/tipo-de-ato/deletar/{id}", name="esp_produtividade_tipo-de-ato_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tipodeato = $entityManager->getRepository(TipoDeAto::class)
            ->find($id);
        $entityManager->remove($tipodeato);
        $entityManager->flush();
        return $this->redirectToRoute('esp_produtividade_tipo-de-ato_index');
    }

}
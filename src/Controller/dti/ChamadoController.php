<?php

namespace App\Controller\dti;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dti\Chamado;

/**
 * Class ChamadoController
 * @package App\Controller\dti
 */
class ChamadoController extends Controller
{
    /**
     * @Route("/dti/chamado/novo", name="dti_chamado_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $chamado = new Chamado();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($chamado)
            ->add('nome', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $chamado = $form->getData();
            $entityManager->persist($chamado);
            $entityManager->flush();
            return $this->redirectToRoute('dti_listar_chamados');
        }

        return $this->render("dti/chamado/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dti/chamado/editar/{id}", name="dti_chamado_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $chamado = $this->getDoctrine()
                            ->getRepository(Chamado::class)
                            ->find($id);

        $form = $this->createFormBuilder($chamado)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('nome', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $chamado = $form->getData();
            $entityManager->persist($chamado);
            $entityManager->flush();
            return $this->redirectToRoute('dti_listar_chamados');
        }

        return $this->render("dti/chamado/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dti/chamado/deletar/{id}", name="dti_chamado_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $chamado = $this->getDoctrine()
            ->getRepository(Chamado::class)
            ->find($id);

            $entityManager->remove($chamado);
            $entityManager->flush();
            return $this->redirectToRoute('dti_listar_chamados');

    }


    /**
     * @Route ("/dti/chamado", name="dti_listar_chamado")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $dptos = $this->getDoctrine()
            ->getRepository(Chamado::class)
            ->findAll();

        return $this->render("dti/chamado/index.html.twig", array(
            'deptos' => $dptos
        ));
    }

}
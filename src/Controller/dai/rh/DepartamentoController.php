<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 21/03/2018
 * Time: 07:33
 */

namespace App\Controller\dai\rh;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Departamento;

/**
 * Class DepartamentoController
 * @package App\Controller\dai\rh
 */
class DepartamentoController extends Controller
{
    /**
     * @Route("/dai/rh/departamento/novo", name="dai_rh_departamento_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $departamento = new Departamento();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($departamento)
            ->add('nome', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $departamento = $form->getData();
            $entityManager->persist($departamento);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_departamentos');
        }

        return $this->render("dai/rh/departamento/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/departamento/editar/{id}", name="dai_rh_departamento_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $departamento = $this->getDoctrine()
                            ->getRepository(Departamento::class)
                            ->find($id);

        $form = $this->createFormBuilder($departamento)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('nome', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $departamento = $form->getData();
            $entityManager->persist($departamento);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_departamentos');
        }

        return $this->render("dai/rh/departamento/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/departamento/deletar/{id}", name="dai_rh_departamento_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $departamento = $this->getDoctrine()
            ->getRepository(Departamento::class)
            ->find($id);

            $entityManager->remove($departamento);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_departamentos');

    }


    /**
     * @Route ("/dai/rh/departamento", name="dai_rh_listar_departamentos")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $dptos = $this->getDoctrine()
            ->getRepository(Departamento::class)
            ->findAll();

        return $this->render("dai/rh/departamento/index.html.twig", array(
            'deptos' => $dptos
        ));
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 16/04/2018
 * Time: 11:17
 */

namespace App\Controller\dai\rh;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Tipoausencia;

/**
 * Class TipoausenciaController
 * @package App\Controller\dai\rh
 */
class TipoausenciaController extends Controller
{
    /**
     * @Route("/dai/rh/tipoausencia/novo", name="dai_rh_tipoausencia_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $tipoausencia = new Tipoausencia();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($tipoausencia)
            ->add('descricao', TextType::class)
            ->add('temperiodo', ChoiceType::class, array(
                'choices' => array(
                    'Não' => true,
                    'Sim' => false,
                )
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipoausencia = $form->getData();
            $entityManager->persist($tipoausencia);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_tipoausencias');
        }

        return $this->render("dai/rh/tipoausencia/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/dai/rh/tipoausencia/editar/{id}", name="dai_rh_tipoausencia_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $tipoausencia = $this->getDoctrine()
            ->getRepository(Tipoausencia::class)
            ->find($id);

        $form = $this->createFormBuilder($tipoausencia)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('descricao', TextType::class)
            ->add('temperiodo', ChoiceType::class, array(
                'choices' => array(
                    'Não' => true,
                    'Sim' => false,
                )
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipoausencia = $form->getData();
            $entityManager->persist($tipoausencia);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_tipoausencias');
        }

        return $this->render("dai/rh/tipoausencia/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/tipoausencia/deletar/{id}", name="dai_rh_tipoausencia_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $tipoausencia = $this->getDoctrine()
            ->getRepository(Tipoausencia::class)
            ->find($id);

        $entityManager->remove($tipoausencia);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_listar_tipoausencias');

    }


    /**
     * @Route ("dai/rh/tipoausencia", name="dai_rh_listar_tipoausencias")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $tiposausencia = $this->getDoctrine()
            ->getRepository(Tipoausencia::class)
            ->findAll();

        return $this->render("dai/rh/tipoausencia/index.html.twig", array(
            'tiposausencia' => $tiposausencia
        ));
    }    
}
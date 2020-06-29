<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 10/04/2018
 * Time: 07:50
 */

namespace App\Controller\dai\rh;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Escolaridade;

/**
 * Class EscolaridadeController
 * @package App\Controller\dai\rh
 */
class EscolaridadeController extends Controller
{

    /**
     * @Route("/dai/rh/escolaridade/novo", name="dai_rh_escolaridade_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $escolaridade = new Escolaridade();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($escolaridade)
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $escolaridade = $form->getData();
            $entityManager->persist($escolaridade);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_escolaridades');
        }

        return $this->render("dai/rh/escolaridade/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/escolaridade/editar/{id}", name="dai_rh_escolaridade_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $escolaridade = $this->getDoctrine()
            ->getRepository(Escolaridade::class)
            ->find($id);

        $form = $this->createFormBuilder($escolaridade)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $escolaridade = $form->getData();
            $entityManager->persist($escolaridade);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_escolaridades');
        }

        return $this->render("dai/rh/escolaridade/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/escolaridade/deletar/{id}", name="dai_rh_escolaridade_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $escolaridade = $this->getDoctrine()
            ->getRepository(Escolaridade::class)
            ->find($id);

        $entityManager->remove($escolaridade);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_listar_escolaridades');

    }


    /**
     * @Route ("/dai/rh/escolaridade", name="dai_rh_listar_escolaridades")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $escol = $this->getDoctrine()
            ->getRepository(Escolaridade::class)
            ->findAll();

        return $this->render("dai/rh/escolaridade/index.html.twig", array(
            'escol' => $escol
        ));
    }
}
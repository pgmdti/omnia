<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 09/04/2018
 * Time: 11:49
 */

namespace App\Controller\dai\rh;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Classificacao;

/**
 * Class ClassificacaoController
 * @package App\Controller\dai\rh
 */
class ClassificacaoController extends Controller
{

    /**
     * @Route("/dai/rh/classificacao/novo", name="dai_rh_classificacao_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $classificacao = new Classificacao();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($classificacao)
            ->add('nome', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $classificacao = $form->getData();
            $entityManager->persist($classificacao);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_classificacao_index');
        }

        return $this->render("dai/rh/classificacao/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/classificacao/editar/{id}", name="dai_rh_classificacao_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $classificacao = $this->getDoctrine()
            ->getRepository(Classificacao::class)
            ->find($id);

        $form = $this->createFormBuilder($classificacao)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('nome', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $classificacao = $form->getData();
            $entityManager->persist($classificacao);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_classificacao_index');
        }

        return $this->render("dai/rh/classificacao/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/classificacao/deletar/{id}", name="dai_rh_classificacao_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $classificacao = $this->getDoctrine()
            ->getRepository(Classificacao::class)
            ->find($id);

        $entityManager->remove($classificacao);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_classificacao_index');

    }


    /**
     * @Route ("/dai/rh/classificacao", name="dai_rh_classificacao_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $class = $this->getDoctrine()
            ->getRepository(Classificacao::class)
            ->findAll();

        return $this->render("dai/rh/classificacao/index.html.twig", array(
            'class' => $class
        ));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 28/03/2018
 * Time: 09:28
 */

namespace App\Controller\dai\rh;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Orgao;

/**
 * Class OrgaoController
 * @package App\Controller\dai\rh
 */
class OrgaoController extends Controller
{

    /**
     * @Route("/dai/rh/orgao/novo", name="dai_rh_orgao_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $orgao = new Orgao();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($orgao)
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $orgao = $form->getData();
            $entityManager->persist($orgao);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_orgaos');
        }

        return $this->render("dai/rh/orgao/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/orgao/editar/{id}", name="dai_rh_orgao_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $orgao = $this->getDoctrine()
            ->getRepository(Orgao::class)
            ->find($id);

        $form = $this->createFormBuilder($orgao)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $orgao = $form->getData();
            $entityManager->persist($orgao);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_orgaos');
        }

        return $this->render("dai/rh/orgao/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/orgao/deletar/{id}", name="dai_rh_orgao_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $orgao = $this->getDoctrine()
            ->getRepository(Orgao::class)
            ->find($id);

        $entityManager->remove($orgao);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_listar_orgaos');

    }


    /**
     * @Route ("/dai/rh/orgao", name="dai_rh_listar_orgaos")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $orgaos = $this->getDoctrine()
            ->getRepository(Orgao::class)
            ->findAll();

        return $this->render("dai/rh/orgao/index.html.twig", array(
            'orgaos' => $orgaos
        ));
    }

}
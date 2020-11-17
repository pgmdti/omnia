<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 10/04/2018
 * Time: 08:39
 */

namespace App\Controller\dai\rh;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Estadocivil;

/**
 * Class EstadocivilController
 * @package App\Controller\dai\rh
 */
class EstadocivilController extends Controller
{
    /**
     * @Route("/dai/rh/estadocivil/novo", name="dai_rh_estadocivil_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $estadocivil = new Estadocivil();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($estadocivil)
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $estadocivil = $form->getData();
            $entityManager->persist($estadocivil);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_estadocivis');
        }

        return $this->render("dai/rh/estadocivil/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/estadocivil/editar/{id}", name="dai_rh_estadocivil_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $estadocivil = $this->getDoctrine()
            ->getRepository(Estadocivil::class)
            ->find($id);

        $form = $this->createFormBuilder($estadocivil)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $estadocivil = $form->getData();
            $entityManager->persist($estadocivil);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_estadocivis');
        }

        return $this->render("dai/rh/estadocivil/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/estadocivil/deletar/{id}", name="dai_rh_estadocivil_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $estadocivil = $this->getDoctrine()
            ->getRepository(Estadocivil::class)
            ->find($id);

        $entityManager->remove($estadocivil);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_listar_estadocivis');

    }


    /**
     * @Route ("/dai/rh/estadocivil", name="dai_rh_listar_estadocivis")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $civil = $this->getDoctrine()
            ->getRepository(Estadocivil::class)
            ->findAll();

        return $this->render("dai/rh/estadocivil/index.html.twig", array(
            'civil' => $civil
        ));
    }
}
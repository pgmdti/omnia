<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 25/07/2018
 * Time: 09:04
 */

namespace App\Controller\dai\rh;


use App\Entity\dai\rh\Cargo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CargoController
 * @package App\Controller\dai\rh
 */
class CargoController extends Controller
{
    /**
     * @Route("/dai/rh/cargo/novo", name="dai_rh_cargo_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $cargo = new Cargo();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($cargo)
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cargo = $form->getData();
            $entityManager->persist($cargo);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_cargos');
        }

        return $this->render("dai/rh/cargo/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/cargo/editar/{id}", name="dai_rh_cargo_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $cargo = $this->getDoctrine()
            ->getRepository(Cargo::class)
            ->find($id);

        $form = $this->createFormBuilder($cargo)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('descricao', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cargo = $form->getData();
            $entityManager->persist($cargo);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_listar_cargos');
        }

        return $this->render("dai/rh/cargo/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/dai/rh/cargo/deletar/{id}", name="dai_rh_cargo_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $cargo = $this->getDoctrine()
            ->getRepository(Cargo::class)
            ->find($id);

        $entityManager->remove($cargo);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_listar_cargos');

    }


    /**
     * @Route ("/dai/rh/cargo", name="dai_rh_listar_cargos")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $cargo = $this->getDoctrine()
            ->getRepository(Cargo::class)
            ->findAll();

        return $this->render("dai/rh/cargo/index.html.twig", array(
            'cargo' => $cargo
        ));
    }
}
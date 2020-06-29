<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 19/11/18
 * Time: 08:14
 */

namespace App\Controller;

use App\Entity\NotifyParams;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class NotifyParamsController
 * @package App\Controller
 */
class NotifyParamsController extends Controller
{
    /**
     * @Route("/params", name="params_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(NotifyParams::class);
        $params = $rep->findAll();
        return $this->render("params/index.html.twig", array(
            'params' => $params
        ));
    }

    /**
     * @Route("/params/novo", name="params_novo")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function novo(Request $request){

        $params = new NotifyParams();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($params)
            ->add('descricao', TextType::class)
            ->add('periodicidade', ChoiceType::class, array(
                'choices' => array(
                    '90 dias' => 90,
                    '75 dias' => 75,
                    '60 dias' => 60,
                    '45 dias' => 45,
                    '30 dias' => 30,
                    '15 dias' => 15,
                    '10 dias' => 10,
                    '05 dias' => 5,
                ),
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ))
            ->add('emails', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();
            $em->persist($params);
            $em->flush();
            return $this->redirectToRoute('params_index');
        }

        return $this->render("params/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


    /**
     * @Route("/params/editar/{id}", name="params_editar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     * @param $id
     */
    public function editar(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $params = $em->getRepository(NotifyParams::class)->find($id);

        $form = $this->createFormBuilder($params)
            ->add('descricao', TextType::class)
            ->add('periodicidade', ChoiceType::class, array(
                'choices' => array(

                    '90 dias' => 90,
                    '75 dias' => 75,
                    '60 dias' => 60,
                    '45 dias' => 45,
                    '30 dias' => 30,
                    '15 dias' => 15,
                    '10 dias' => 10,
                    '05 dias' => 5,

                ),
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ))
            ->add('emails', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();
            $em->persist($params);
            $em->flush();
            return $this->redirectToRoute('params_index');
        }

        return $this->render("params/editar.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/params/deletar/{id}", name="params_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $params = $this->getDoctrine()
            ->getRepository(NotifyParams::class)
            ->find($id);

        $entityManager->remove($params);
        $entityManager->flush();
        return $this->redirectToRoute('params_index');

    }

}
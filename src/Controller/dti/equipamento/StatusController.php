<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 25/09/18
 * Time: 11:46
 */

namespace App\Controller\dti\equipamento;


use App\Entity\dti\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class StatusController extends Controller
{

    /**
     * @Route("/dti/status/novo", name="dti_status_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request)
    {

        $status = new Status();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($status)
            ->add('status', TextType::class, array(
                'required' => true,
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $status = $form->getData();
            $entityManager->persist($status);
            $entityManager->flush();
            return $this->redirectToRoute('dti_equipamento_index');
        }

        return $this->render("dti/status/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }
}
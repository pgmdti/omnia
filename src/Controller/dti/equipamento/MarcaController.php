<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 23/09/18
 * Time: 22:00
 */

namespace App\Controller\dti\equipamento;


use App\Entity\dti\Marca;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MarcaController extends Controller
{

    /**
     * @Route("/dti/marca/novo", name="dti_marca_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request)
    {

        $marca = new Marca();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($marca)
            ->add('marca', TextType::class, array(
                'required' => true,
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $marca = $form->getData();
            $entityManager->persist($marca);
            $entityManager->flush();
            return $this->redirectToRoute('dti_equipamento_index');
        }

        return $this->render("dti/marca/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }

}
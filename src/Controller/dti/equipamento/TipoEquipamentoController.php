<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 23/09/18
 * Time: 22:00
 */

namespace App\Controller\dti\equipamento;


use App\Entity\dti\TipoEquipamento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TipoEquipamentoController extends Controller
{

    /**
     * @Route("/dti/tipoequipamento/novo", name="dti_tipoequipamento_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request)
    {

        $tipoequipamento = new TipoEquipamento();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($tipoequipamento)
            ->add('descricao', TextType::class, array(
                'required' => true,
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipoequipamento = $form->getData();
            $entityManager->persist($tipoequipamento);
            $entityManager->flush();
            return $this->redirectToRoute('dti_equipamento_index');
        }

        return $this->render("dti/tipoequipamento/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }


}
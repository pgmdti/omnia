<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 16/03/2018
 * Time: 22:53
 */

namespace App\Controller\dti\printers;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\dti\printers\Status;
use App\Entity\dti\printers\Printer;

/**
 * Class PrinterController
 * @package App\Controller\dti\printers
 */
class PrinterController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/dti/printers/status", name="dti_printers_status")
     */
    public function printers()
    {
        $sts = new Status();
        $imps = $this->getDoctrine()->getRepository(Printer::class)
                ->findBy(array(), array('local' => 'ASC'));
        $sts->impressoras($imps);

        return $this->render("dti/printers/status.html.twig", array(
            'list_printers' => $imps,
        ));

    }

    /**
     * @Route("/dti/printers/novo", name="dti_printers_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request)
    {

        $printer = new Printer();

        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($printer)
            ->add('local', TextType::class)
            ->add('endereco', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $printer = $form->getData();
            $entityManager->persist($printer);
            $entityManager->flush();
            return $this->redirectToRoute('dti_printers_status');
        }

        return $this->render("dti/printers/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/dti/printers/editar/{id}", name="dti_printers_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $printer = $this->getDoctrine()
            ->getRepository(Printer::class)
            ->find($id);

        $form = $this->createFormBuilder($printer)

            ->add('id', NumberType::class, array(
                'disabled' => true
            ))
            ->add('local', TextType::class)
            ->add('endereco', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $printer = $form->getData();
            $entityManager->persist($printer);
            $entityManager->flush();
            return $this->redirectToRoute('dti_printers_status');
        }

        return $this->render("dti/printers/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/dti/printers/deletar/{id}", name="dti_printers_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $printer = $this->getDoctrine()
            ->getRepository(Printer::class)
            ->find($id);

        $entityManager->remove($printer);
        $entityManager->flush();
        return $this->redirectToRoute('dti_printers_status');

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 13/03/2018
 * Time: 11:21
 */

namespace App\Controller\dai\rh;

use App\Entity\dai\rh\Cidade;
use App\Entity\dai\rh\Documento;
use App\Form\EmployeeFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\dai\rh\Employee;


/**
 * Class EmployeeController
 * @package App\Controller\dai\rh
 */
class EmployeeController extends Controller
{
    /**
     * @Route("/dai/rh/cadastro/novo", name="dai_rh_cadastro_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $entityManager = $this->getDoctrine()->getManager();

        $employee = new Employee($entityManager);

        $form = $this->createForm(EmployeeFormType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $employee = $form->getData();

            /**
             * @var UploadedFile $files
             */
            $files = $employee->getFiles();

            $documents = array();

            foreach ($files as $file){
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('documents_directory'),
                    $fileName
                );
                $doc = new Documento();
                $doc->setEmployee($employee);
                $doc->setPath($fileName);
                $doc->setName($file->getClientOriginalName());
                $doc->setSize($file->getClientSize());
                $documents[] = $doc;
            }

            $employee->setFiles($documents);

            $entityManager->persist($employee);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_cadastro_index');
        }


        return $this->render("dai/rh/cadastro/novo.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    
    /**
     * @Route("/dai/rh/cadastro/editar/{id}", name="dai_rh_cadastro_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $employee = $this->getDoctrine()
                            ->getRepository(Employee::class)
                            ->findOneBy(array('matricula' => $id));

        $documents = $this->getDoctrine()
                          ->getRepository(Documento::class)
                          ->findBy(array('employee' => $employee));

        $files = array();

        foreach ($documents as $i){
            $files[] = $i;
        }

        $employee->setFiles($files);

        $form = $this->createForm(EmployeeFormType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $employee = $form->getData();

            /**
             * @var UploadedFile $files
             */
            $files = $employee->getFiles();

            $documents = array();

            foreach ($files as $file){
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('documents_directory'),
                    $fileName
                );
                $doc = new Documento();
                $doc->setEmployee($employee);
                $doc->setPath($fileName);
                $doc->setName($file->getClientOriginalName());
                $doc->setSize($file->getClientSize());
                $documents[] = $doc;
            }

            $employee->setFiles($documents);

            $entityManager->persist($employee);
            $entityManager->flush();
            return $this->redirectToRoute('dai_rh_cadastro_index');
        }


        return $this->render("dai/rh/cadastro/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }


        /**
     * @Route("/dai/rh/cadastro/deletar/{id}", name="dai_rh_cadastro_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id){

        $entityManager = $this->getDoctrine()->getManager();

        $employee = $this->getDoctrine()
            ->getRepository(Employee::class)
            ->findOneBy(array('matricula' => $id));

        $entityManager->remove($employee);
        $entityManager->flush();
        return $this->redirectToRoute('dai_rh_cadastro_index');

    }

    
    /**
     * @param Request $request
     * @Route ("/dai/rh/get-cidades-por-estado", name="dai_rh_get-cidades-por-estado")
     * @return JsonResponse
     */
    public function listCidadesOfUfAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $cidades = $em->getRepository(Cidade::class)
        ->findBy(array('ufid' => $request->query->get('uf')));

        return new JsonResponse($cidades);
    }

    /**
     * @Route ("/dai/rh/cadastro", name="dai_rh_cadastro_index")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function index(Request $request){

        $result = $this->getDoctrine()->getRepository(Employee::class)
            ->findAll();

        return $this->render("dai/rh/cadastro/index.html.twig", array(
            'empls' => $result
        ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
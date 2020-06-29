<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 13/04/2018
 * Time: 13:01
 */

namespace App\Controller\dai\rh;

use App\Entity\dai\rh\Documento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class DocumentoController
 * @package App\Controller\dai\rh
 */
class DocumentoController extends Controller
{

    /**
     * @Route("/dai/rh/documento/listar/{id}", name="dai_rh_documento_listar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function listar($id){

    }

    /**
     * @Route("/dai/rh/documento/download/{filename}", name="dai_rh_documento_download")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function download($filename){

        $dir = $this->getParameter('documents_directory');
        $pathfile = $dir.$filename;

        $response = new BinaryFileResponse($pathfile);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$filename);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename
        );

        return $response;
    }

    /**
     * @Route("/dai/rh/documento/deletar/{id}/{idemp}", name="dai_rh_documento_deletar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id, $idemp){

        $entityManager = $this->getDoctrine()->getManager();

        $documento = $this->getDoctrine()
            ->getRepository(Documento::class)
            ->find($id);

        $entityManager->remove($documento);
        $entityManager->flush();

        return $this->redirectToRoute('dai_rh_cadastro_editar', array('id' => $idemp));

    }
}
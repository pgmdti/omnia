<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 17/03/2018
 * Time: 00:19
 */

namespace App\Controller;

use App\Entity\esp\eleicao\Eleicao;
use App\Services\NotifyCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends Controller
{
    /**
     * @Route("/home", name="index_geral")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(){

        //$rolesTab = $this->getUser()->getRoles();

        $session = $this->get('session');

        if($session->get('current_location') == null){
            $session->set('current_location', $this->getUser()->getLotacao()[0]);
            $session->save();
        }

        $em = $this->getDoctrine()->getManager();

        $pleitos = $em->getRepository(Eleicao::class)->findAll();

        foreach ($pleitos as $i){
            if($i->verificaPleito()){
                if(strcmp(substr($this->getUser()->getCargo(), 0, 10), 'Procurador') == 0){
                    if($i->verificaVoto($this->getUser())){
                        return $this->redirectToRoute('esp_eleicao_voto_novo', array("pleitoid" => $i->getId()));
                    }
                }
            }
        }

            return $this->render("/index.html.twig", array(
            'index' => null,
        ));

    }

    /**
     * @Route("/", name="index_geral_root")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function indexRoot(){

        return $this->redirectToRoute('index_geral');

    }

}
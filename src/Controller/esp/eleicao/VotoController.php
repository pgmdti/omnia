<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 30/10/18
 * Time: 11:37
 */

namespace App\Controller\esp\eleicao;


use App\Entity\esp\eleicao\Eleicao;
use App\Entity\esp\eleicao\Voto;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VotoController
 * @package App\Controller\esp\eleicao
 */
class VotoController extends Controller
{

    /**
     * @Route("/esp/eleicao/voto/{pleitoid}", name="esp_eleicao_voto_novo")
     * @param Request $request
     * @param $pleitoid
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request, $pleitoid){

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $pleito = $em->getRepository(Eleicao::class)
            ->find($pleitoid);

        $voto = new Voto($user, $pleito);

        if(!$pleito->verificaPleito()){
            return $this->render("esp/eleicao/voto/confirm.html.twig", array(
                'confirmacao' => "Votação para este pleito encerrada!!",
            ));
        }

        $form = $this->createFormBuilder($voto)
            ->add('candidato', ChoiceType::class, array(
                'placeholder' => 'Escolha o candidato...',
                'choices' => $pleito->getCandidatos(),
                'choice_label' => 'candidato',
                'required' => true,
                'empty_data' => null
            ))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $voto = $form->getData();
            $mensagem = "Voto confirmado! Comprovante enviado para o e-mail ".$user->getEmail();

            if($pleito->verificaVoto($user)){
                $chave = MD5("eleitor:".$user->getId()."pleito:".$pleito->getId()."candidato:".$voto->getCandidato()->getId());
                $voto->setChave($chave);
                $em->persist($voto);
                $em->flush();

                $mailFrom = $this->getParameter("mailer_user");

                $message = (new \Swift_Message("Comprovante de Votação - ".$pleito->getTitulo()));

                $imagem = $message->embed(\Swift_Image::fromPath($this->getParameter("images_directory")."water-mark2.jpg"));

                $message->setFrom($mailFrom)
                    ->setTo($voto->getEleitor()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/voteconfirm.html.twig',
                            array(
                                "pleito" => strtoupper($pleito->getTitulo()),
                                "datapleito" => $pleito->getInicio(),
                                "eleitor" => strtoupper($voto->getEleitor()->getNome()),
                                "matricula" => $voto->getEleitor()->getMatricula(),
                                "chave" => strtoupper($voto->getChave()),
                                "img_src" => $imagem
                            )
                        ),
                        "text/html"
                    );

                $this->get('mailer')->send($message);

            }else{
                $mensagem = "Já existe voto registrado para este usuário/eleitor!";
            }
            return $this->render("esp/eleicao/voto/confirm.html.twig", array(
                'confirmacao' => $mensagem,
            ));
        }

        return $this->render("esp/eleicao/voto/novo.html.twig", array(
            'form' => $form->createView(),
            'eleicao' => $pleito,
        ));

    }
}
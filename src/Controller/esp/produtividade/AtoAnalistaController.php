<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 02/05/19
 * Time: 09:55
 */

namespace App\Controller\esp\produtividade;

use App\Entity\AtoAnalista;
use App\Entity\Lotacao;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AtoAnalistaController
 * @package App\Controller\esp\produtividade
 */
class AtoAnalistaController extends Controller
{

    /**
     * @Route("/esp/produtividade/analista/ato", name="esp_produtividade_analista_ato_index")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request){

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $session = $this->get('session');

        if($session->get('current_location') == null){
            $session->set('current_location', $this->getUser()->getLotacao()[0]);
            $session->save();
        }


        if(!empty($request->get('_dateini'))){
            $dateini = $request->get('_dateini');
            $datefim = $request->get('_datefim');
            $session->set('_dateini', $dateini);
            $session->set('_datefim', $datefim);
        }else{

            if(empty($session->get('_dateini'))){
                $datefim = date("Y-m-d");
                $dateini = date("Y-m-d", strtotime("-1 months"));
            }else{
                $dateini = $session->get('_dateini');
                $datefim = $session->get('_datefim');
            }
        }

        $query = $em->createQueryBuilder()
            ->select('u.id, u.numero, u.emissao, b.descricao as lotacao, c.descricao as tipodeato, d.nome')
            ->from(AtoAnalista::class, 'u')
            ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
            ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
            ->leftJoin('u.procurador', 'd', 'WITH', 'd.id = u.procurador')
            ->where('u.user = :userid and u.emissao between :dateini and :datefim')
            ->setParameters(array(
                'userid' => $user->getId(),
                'dateini' => $dateini,
                'datefim' => $datefim,
            ))
            ->orderBy('u.emissao', 'DESC');


        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render("esp/produtividade/atoanalista/index.html.twig", array(
            'atos' => $result,
            'dateini' => $dateini,
            'datefim' => $datefim,
        ));
    }

    /**
     * @Route("/esp/produtividade/analista/ato/novo", name="esp_produtividade_analista_ato_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $ato = new AtoAnalista();

        $session = $this->get('session');

        $location = $session->get('current_location');

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)
            ->find($user->getId());

        $lotacao = $entityManager->getRepository(Lotacao::class)
            ->find($location->getId());

        $procgeral = $entityManager->getRepository(Lotacao::class)
            ->findOneBy(array('descricao' => 'procuradoria geral'));

        $lotacaoid = $lotacao->getId();

        $form = $this->createFormBuilder($ato)
            ->add('emissao', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']
            ))
            ->add('numero', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'autofocus' => true
                )
            ))
            ->add('tipodeato', ChoiceType::class, array(
                'placeholder' => 'Selecione...',
                'choices' => $lotacao->getTiposdeato(),
                'choice_label' => 'descricao',
                'required' => true,
                'empty_data' => null
            ))
            ->add('procurador', EntityType::class, array(
                    'placeholder' => 'Selecione...',
                    'class' => User::class,
                    'query_builder' => function (EntityRepository $er) use ($lotacaoid, $procgeral) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb
                            ->select('u')
                            ->innerJoin('u.cargo','a', 'WITH', 'a.id = u.cargo')
                            ->innerJoin('u.lotacao','b')
                            ->where('u.enabled = true')
                            ->andWhere('a.descricao like :cargo')
                            ->andWhere($qb->expr()->orX(
                                $qb->expr()->eq('b.id', ':lotacaoid'),
                                $qb->expr()->eq('b.id', ':procgeral')
                            ))
                            ->setParameters(array(
                                "lotacaoid" => $lotacaoid,
                                "procgeral" => $procgeral->getId(),
                                "cargo" => '%procurador%',
                            ))
                            ->orderBy('u.nome', 'ASC');
                    },
                    'choice_label' => 'nome',
                    'required' => false,
                    'empty_data' => null
                )
            )
            ->add('descricao', TextareaType::class, array(
                'required' => false,
            ))
            ->getForm();

        $form->handleRequest($request);

        $save_action = $request->get('_save-action-form');

        if ($form->isSubmitted() && $form->isValid()) {

            $ato = $form->getData();

            $mensagem = 0;

            $ato->setUser($user);
            $ato->setLotacao($lotacao);
            $entityManager->persist($ato);
            $entityManager->flush();

            $response = new JsonResponse();
            $response->setData(['data' => $mensagem]);
            return $response;
        }

        return $this->render("esp/produtividade/atoanalista/novo.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/esp/produtividade/analista/ato/detalhe/{id}", name="esp_produtividade_analista_ato_detalhe")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function detalharAto($id){

        $ato = $this->getDoctrine()
            ->getRepository(AtoAnalista::class)
            ->findBy(array('id' => $id));

        return $this->render("esp/produtividade/atoanalista/detalhe.html.twig", array(
            'act' => $ato,
        ));
    }

    /**
     * @Route("/esp/produtividade/analista/ato/editar/{id}", name="esp_produtividade_analista_ato_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ato = $entityManager->getRepository(AtoAnalista::class)
            ->find($id);

        $lotacaoid = $ato->getLotacao()->getId();

        $procgeral = $entityManager->getRepository(Lotacao::class)
            ->findOneBy(array('descricao' => 'procuradoria geral'));

        $form = $this->createFormBuilder($ato)
            ->add('emissao', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker',
                    'data-mask' => '00/00/0000',
                    'placeholder' => '00/00/0000']
            ))
            ->add('numero', TextType::class, array(
                'required' => true
            ))
            ->add('tipodeato', ChoiceType::class, array(
                'placeholder' => 'Selecione...',
                'choices' => $ato->getLotacao()->getTiposdeato(),
                'choice_label' => 'descricao',
                'required' => true,
                'empty_data' => null
            ))
            ->add('procurador', EntityType::class, array(
                    'placeholder' => 'Selecione...',
                    'class' => User::class,
                    'query_builder' => function (EntityRepository $er) use ($lotacaoid, $procgeral) {
                        $qb = $er->createQueryBuilder('u');
                        return $qb
                            ->select('u')
                            ->innerJoin('u.cargo','a', 'WITH', 'a.id = u.cargo')
                            ->innerJoin('u.lotacao','b')
                            ->where('u.enabled = true')
                            ->andWhere('a.descricao like :cargo')
                            ->andWhere($qb->expr()->orX(
                                $qb->expr()->eq('b.id', ':lotacaoid'),
                                $qb->expr()->eq('b.id', ':procgeral')
                            ))
                            ->setParameters(array(
                                "lotacaoid" => $lotacaoid,
                                "procgeral" => $procgeral->getId(),
                                "cargo" => '%procurador%',
                            ))
                            ->orderBy('u.nome', 'ASC');
                    },
                    'choice_label' => 'nome',
                    'required' => false,
                    'empty_data' => null
                )
            )
            ->add('descricao', TextareaType::class, array(
                'required' => false,
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ato = $form->getData();

            $entityManager->persist($ato);
            $entityManager->flush();
            return $this->redirectToRoute('esp_produtividade_analista_ato_index');

        }

        return $this->render("esp/produtividade/atoanalista/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/esp/produtividade/analista/ato/deletar/{id}", name="esp_produtividade_analista_ato_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ato = $entityManager->getRepository(AtoAnalista::class)
            ->find($id);
        $entityManager->remove($ato);
        $entityManager->flush();
        return $this->redirectToRoute('esp_produtividade_analista_ato_index');
    }
}
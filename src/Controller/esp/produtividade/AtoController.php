<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 17/05/2018
 * Time: 12:24
 */

namespace App\Controller\esp\produtividade;

use App\Entity\Ato;
use App\Entity\Lotacao;
use App\Entity\TipoDeAto;
use App\Entity\TipoDeProcesso;
use App\Entity\Upload;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use League\Csv\Reader;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AtoController
 * @package App\Controller\esp\produtividade
 */
class AtoController extends Controller
{
    /**
     * @Route("/esp/produtividade/ato", name="esp_produtividade_ato_index")
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
            ->select('u.id, u.numero, u.emissao, u.assunto, u.numerodoprocesso, b.descricao as lotacao, c.descricao as tipodeato, d.descricao as tipodeprocesso')
            ->from(Ato::class, 'u')
            ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
            ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
            ->leftJoin('u.tipodeprocesso', 'd', 'WITH', 'd.id = u.tipodeprocesso')
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

        return $this->render("esp/produtividade/ato/index.html.twig", array(
            'atos' => $result,
            'dateini' => $dateini,
            'datefim' => $datefim,
        ));
    }

    /**
     * @Route("/esp/produtividade/ato/novo", name="esp_produtividade_ato_novo")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function novo(Request $request){

        $ato = new Ato();

        $user = $this->getUser();

        $session = $this->get('session');

        $location = $session->get('current_location');

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)
            ->find($user->getId());

        $lotacao = $entityManager->getRepository(Lotacao::class)
            ->find($location->getId());

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
           /* RETIRADO DO FORMULÁRIO EM 12/02/2019 A PEDIDO DO DR. MARCELO FANCO
            *  ->add('favoravel', ChoiceType::class, array(
                'placeholder' => 'Selecione...',
                'choices' => array(
                    'Sim' => true,
                    'Nâo' => false,
                ),
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'empty_data' => null
            )) */
            ->add('interessado', TextType::class, array(
                    'required' => false
                ))
                ->add('tipodeprocesso', ChoiceType::class, array(
                    'placeholder' => 'Selecione...',
                    'choices' => $lotacao->getTiposdeprocesso(),
                    'choice_label' => 'descricao',
                    'required' => false,
                    'empty_data' => null
                    ))
                ->add('numerodoprocesso', TextType::class, array(
                    'required' => false
                ))
                ->add('assunto', TextType::class, array(
                    'required' => true
                ))
                ->add('descricao', TextareaType::class, array(
                    'required' => false,
                ))
                ->getForm();

        $form->handleRequest($request);

        $save_action = $request->get('_save-action-form');

        if ($form->isSubmitted() && $form->isValid()) {

            $ato = $form->getData();

            $mensagem = 0;

            if($ato->verificaAto(8)){

                if($ato->getNumerodoprocesso() != null)
                {
                    if($save_action == '0'){

                        $atothat = $entityManager->getRepository(Ato::class)->findOneBy(array("numerodoprocesso" => $ato->getNumerodoprocesso()));
                        if($atothat != null)
                        {
                            $mensagem = 1;

                        }else{

                            $ato->setUser($user);
                            $ato->setLotacao($lotacao);
                            $entityManager->persist($ato);
                            $entityManager->flush();
                        }
                    }else{

                        $ato->setUser($user);
                        $ato->setLotacao($lotacao);
                        $entityManager->persist($ato);
                        $entityManager->flush();
                    }

                }else{

                    $ato->setUser($user);
                    $ato->setLotacao($lotacao);
                    $entityManager->persist($ato);
                    $entityManager->flush();
                }

            }else{
                $mensagem = 2;
                //return $this->render("error.html.twig", array(
                  //  'errormessage' => "Data de emissão do Ato não permitida. Prazo de registro encerrado!",
                //));
            }
            $response = new JsonResponse();
            $response->setData(['data' => $mensagem]);
            return $response;
        }

        return $this->render("esp/produtividade/ato/novo.html.twig", array(
            'form' => $form->createView(),
        ));
    }



    /**
     * @Route("/esp/produtividade/ato/upload", name="esp_produtividade_ato_upload")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function upload(Request $request){

        $upload = new Upload();

        $user = $this->getUser();

        $session = $this->get('session');

        $location = $session->get('current_location');

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)
            ->find($user->getId());

        $lotacao = $entityManager->getRepository(Lotacao::class)
            ->find($location->getId());


        $form = $this->createFormBuilder($upload)
            ->add('file', FileType::class, array(
                'multiple' => false,
                'required' => true,
                'attr' => array( 'accept' => 'text/csv',)
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $upload = $form->getData();

            /**
             * @var UploadedFile $file
             */
            $file = $upload->getFile();

            $fileName = md5(uniqid()).'.'.$file->getClientOriginalExtension();
            $file->move(
                $this->getParameter('documents_directory'),
                $fileName
            );

            $reader = Reader::createFromPath($this->getParameter('documents_directory').'/'.$fileName);
            $reader->setOutputBOM(Reader::BOM_UTF8);
            $reader->addStreamFilter('convert.iconv.ISO-8859-15/UTF-8');
            $reader->setDelimiter(";");
            $reader->setHeaderOffset(0);
            $results = $reader->getRecords();

            $errorarray = array();

            $atoarray = array();

            $key = 1;

            $now = new \DateTime();

            foreach ($results as $row){

                $key++;

                $ato = new Ato();
                $ato->setUser($user);
                $ato->setLotacao($lotacao);

                if($row['emissao'] != null){

                        $emissao = \DateTime::createFromFormat('d/m/Y', $row['emissao']);

                        if(\DateTime::getLastErrors()['warning_count'] > 0){
                            array_push($errorarray, 'Data inválida na linha '.$key);
                            continue;
                        }else if($emissao > $now){
                            array_push($errorarray, 'Data futura inválida na linha '.$key);
                            continue;
                        }else{
                            $ato->setEmissao($emissao);
                        }

                }else{
                    array_push($errorarray, 'Formato de data inválido na linha '.$key);
                    continue;
                }

                if($row['numeroato'] != null){
                    $ato->setNumero($row['numeroato']);
                }else{
                    array_push($errorarray, 'Número do ato inválido na linha '.$key);
                    continue;
                }

                if($row['tipodeato'] != null){

                    $tipodeato = $entityManager->getRepository(TipoDeAto::class)
                        ->findOneBy(array('descricao' => $row['tipodeato']));
                    if($tipodeato != null){
                        $ato->setTipodeato($tipodeato);
                    }else{
                        array_push($errorarray, 'Tipo de ato não encontrado na linha '.$key);
                        continue;
                    }

                }else{
                    array_push($errorarray, 'Tipo de ato inválido na linha '.$key);
                    continue;
                }

                if($row['assunto'] != null){
                    $ato->setAssunto($row['assunto']);
                }else{
                    array_push($errorarray, 'Assunto inválido na linha '.$key);
                    continue;
                }

                if($row['interessado'] != null){
                    $ato->setInteressado($row['interessado']);
                }

                if($row['tipodeprocesso'] != null){

                    $tipodeprocesso = $entityManager->getRepository(TipoDeProcesso::class)
                        ->findOneBy(array('descricao' => $row['tipodeprocesso']));
                    if($tipodeprocesso != null){
                        $ato->setTipodeprocesso($tipodeprocesso);
                    }else{
                        array_push($errorarray, 'Tipo de processo não encontrado na linha '.$key);
                        continue;
                    }
                }

                if($row['numeroprocesso'] != null){
                    $ato->setNumerodoprocesso($row['numeroprocesso']);
                }

                if($row['descricao'] != null){
                    $ato->setDescricao($row['descricao']);
                }

                array_push($atoarray, $ato);
            }

            if(empty($errorarray)){

                foreach ($atoarray as $atoi){
                    $entityManager->persist($atoi);
                    $entityManager->flush();
                }

                $key = $key - 1;
                array_push($errorarray, 'Foram cadastrados '.$key.' atos com sucesso!');

            }else{
                array_push($errorarray, 'Nenhum ato cadastrado. Corrija os erros e envie o arquivo novamente!');
            }

            return $this->render("esp/produtividade/ato/error.html.twig", array(
                'errormessage' => $errorarray,
            ));
        }

        return $this->render("esp/produtividade/ato/upload.html.twig", array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/esp/produtividade/ato/detalhe/{id}", name="esp_produtividade_ato_detalhe")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function detalharAto($id){

        $ato = $this->getDoctrine()
            ->getRepository(Ato::class)
            ->findBy(array('id' => $id));

        return $this->render("esp/produtividade/ato/detalhe.html.twig", array(
            'act' => $ato,
        ));
    }

    /**
     * @Route("/esp/produtividade/ato/editar/{id}", name="esp_produtividade_ato_editar")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function editar(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ato = $entityManager->getRepository(Ato::class)
            ->find($id);

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
            /* RETIRADO DO FORMULÁRIO EM 12/02/2019 A PEDIDO DO DR. MARCELO FANCO
             *  ->add('favoravel', ChoiceType::class, array(
                 'placeholder' => 'Selecione...',
                 'choices' => array(
                     'Sim' => true,
                     'Nâo' => false,
                 ),
                 'multiple' => false,
                 'expanded' => false,
                 'required' => false,
                 'empty_data' => null
             )) */
            ->add('interessado', TextType::class, array(
                'required' => false
            ))
            ->add('tipodeprocesso', ChoiceType::class, array(
                'placeholder' => 'Selecione...',
                'choices' => $ato->getLotacao()->getTiposdeprocesso(),
                'choice_label' => 'descricao',
                'required' => false,
                'empty_data' => null
            ))
            ->add('numerodoprocesso', TextType::class, array(
                'required' => false
            ))
            ->add('assunto', TextType::class, array(
                'required' => true
            ))
            ->add('descricao', TextareaType::class, array(
                'required' => false,
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ato = $form->getData();
            if($ato->verificaAto(5)) {
                $entityManager->persist($ato);
                $entityManager->flush();
                return $this->redirectToRoute('esp_produtividade_ato_index');
            }else{
                return $this->render("error.html.twig", array(
                    'errormessage' => "Data de emissão do Ato não permitida. Prazo de registro encerrado!",
                ));
            }
        }

        return $this->render("esp/produtividade/ato/editar.html.twig", array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/esp/produtividade/ato/deletar/{id}", name="esp_produtividade_ato_deletar")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function deletar($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ato = $entityManager->getRepository(Ato::class)
            ->find($id);
        $entityManager->remove($ato);
        $entityManager->flush();
        return $this->redirectToRoute('esp_produtividade_ato_index');
    }
}
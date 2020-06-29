<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 17/05/2018
 * Time: 12:27
 */

namespace App\Controller\esp\produtividade;

use App\Entity\Ato;
use App\Entity\Lotacao;
use App\Entity\TipoDeAto;
use App\Entity\User;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\JpegResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ProdutividadeController
 * @package App\Controller\esp\produtividade
 */
class ProdutividadeController extends Controller
{

    /**
     * @Route("/esp/produtividade/rels/esp-reports", name="esp_produtividade_esp-reports")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function espReports(Request $request)
    {
        $rolesTab = $this->getUser()->getRoles();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Ato::class);

        $type_filter = "Todos: ";
        $value_filter = "Todos";

        $datefim = date("Y-m-d");
        $dateini = date("Y-m-d", strtotime("-1 months"));


        $session = $this->get('session');

        $location = $session->get('current_location');

        if (in_array('ROLE_CHESP', $rolesTab, true)){

            $lotacao_id = $location->getId();

            $query = $repository->createQueryBuilder('u')
                ->select('YEAR(u.emissao) as ano, MONTH(u.emissao) as mes, b.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                ->where('b = :idlotacao and u.emissao between :dateini and :datefim')
                ->setParameters(array(
                    'idlotacao' => $lotacao_id,
                    'dateini' => $dateini,
                    'datefim' => $datefim,
                ))
                ->groupBy('ano, mes, b');
                //->orderBy('mes, b.descricao');

            $lotacoes = $repository->createQueryBuilder('u')
                ->select('distinct b.descricao')
                ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                ->where('b = :idlotacao')
                ->setParameters(array(
                    'idlotacao' => $lotacao_id,
                ))
                ->orderBy('b.descricao')
                ->getQuery()->getResult();

        }else{

            $query = $repository->createQueryBuilder('u')
                ->select('YEAR(u.emissao) as ano, MONTH(u.emissao) as mes, b.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                ->where('u.emissao between :dateini and :datefim')
                ->setParameters(array(
                    'dateini' => $dateini,
                    'datefim' => $datefim,
                ))
                ->groupBy('ano, mes, b');
                //->orderBy('b.descricao');

            $lotacoes = $repository->createQueryBuilder('u')
                ->select('distinct b.descricao')
                ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                ->orderBy('b.descricao')
                ->getQuery()->getResult();

        }


        /** GRÁFICO EM FORMA DE LINHAS **/
        $chart = $this->getLineChart($query, $lotacoes, $dateini, $datefim, $type_filter, $value_filter);


        /* GRÁFICO EM FORMA DE TABELA VAZIO */
        $table = new TableChart();
        $table->getData()->setArrayToDataTable(array(["..."]));


        return $this->render('esp/produtividade/reports/index.html.twig', array(
            'typefilter' => $type_filter,
            'valuefilter' => $value_filter,
            'chart' => $chart,
            'table' => $table,
            'dateini' => $dateini,
            'datefim' => $datefim
        ));

    }

    /**
     * @Route("/esp/produtividade/rels/esp-filter-reports", name="esp_produtividade_esp-filter-reports")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function espFiltersReports(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Ato::class);

        $session = $this->get('session');

        $location = $session->get('current_location');

        if(!empty($request->get('_filterType'))){
            $dateini = $request->get('_dateini');
            $datefim = $request->get('_datefim');
            $type = $request->get('_filterType');
            $value = $request->get('_filterValue');

            $session->set('_dateini', $dateini);
            $session->set('_datefim', $datefim);
            $session->set('_filterType', $type);
            $session->set('_filterValue', $value);
        }else{

            $dateini = $session->get('_dateini');
            $datefim = $session->get('_datefim');
            $type = $session->get('_filterType');
            $value = $session->get('_filterValue');
        }


        $rolesTab = $this->getUser()->getRoles();
        $ischesp = false;
        $lotacao_id = 0;

        if (in_array('ROLE_CHESP', $rolesTab, true)) {

            $ischesp = true;
            $lotacao_id = $location->getId();
        }

        $value_filter = "Todos";


        if($type == '1'){

            $type_filter = "Especializada: ";

            if($value == '0'){

                if($ischesp){

                    $query = $repository->createQueryBuilder('u')
                        ->select('b.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->where('b = :lotacaoid and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'lotacaoid' => $lotacao_id,
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('b')
                        ->orderBy('b.descricao');
                }else{

                    $query = $repository->createQueryBuilder('u')
                        ->select('b.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->where('u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('b')
                        ->orderBy('b.descricao');
                }

                /* GRÁFICO EM FORMA DE PIZZA */
                $chart = $this->getPierChart($query, $dateini, $datefim, $type_filter, $value_filter, 0);
                /* GRÁFICO EM FORMA DE TABELA */
                $table = $this->getTabChart($query);


            }else{

                $qb = $em->getRepository(Lotacao::class)

                    ->createQueryBuilder('u')
                    ->select('u.descricao')
                    ->where('u.id = :lotaid')
                    ->setParameters(
                        array(
                            'lotaid' => $value
                        )
                    )->getQuery()->getSingleResult();

                $value_filter = $qb['descricao'];

                $query = $repository->createQueryBuilder('u')
                    ->select('c.nome as descricao, SUM(d.peso) as pontos, COUNT(d.peso) as atos')
                    ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                    ->innerJoin('u.user', 'c', 'WITH', 'c.id = u.user')
                    ->innerJoin('u.tipodeato', 'd', 'WITH', 'd.id = u.tipodeato')
                    ->where('b.id = :lotacao and u.emissao between :dateini and :datefim')
                    ->setParameters(array(
                        'lotacao' => $value,
                        'dateini' => $dateini,
                        'datefim' => $datefim,
                    ))
                    ->groupBy('c')
                    ->orderBy('c.nome');

                /* GRÁFICO EM FORMA DE BARRAS */
                $chart = $this->getBarHorChart($query, $dateini, $datefim, $type_filter, $value_filter);
                /* GRÁFICO EM FORMA DE TABELA */
                $table = $this->getTabChart($query);

            }



        }elseif($type == '2'){

            $type_filter = "Procurador: ";

            if($value == '0'){

                if($ischesp){

                    $query = $repository->createQueryBuilder('u')
                        ->select('b.nome as descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                        ->innerJoin('u.lotacao', 'a', 'WITH', 'a.id = u.lotacao')
                        ->innerJoin('u.user', 'b', 'WITH', 'b.id = u.user')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->where('a = :lotacaoid and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'lotacaoid' => $lotacao_id,
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('b')
                        ->orderBy('b.nome');

                }else{

                    $query = $repository->createQueryBuilder('u')
                        ->select('b.nome as descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                        ->innerJoin('u.user', 'b', 'WITH', 'b.id = u.user')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->where('u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('b')
                        ->orderBy('b.nome');
                }


                /* GRÁFICO EM FORMA COMBO CHART BARRAS VERTICAIS */
                $chart = $this->getComboChart($query, $dateini, $datefim, $type_filter, $value_filter);
                /* GRÁFICO EM FORMA DE TABELA */
                $table = $this->getTabChart($query);


            }else{

                $qb = $em->getRepository(User::class)

                    ->createQueryBuilder('u')
                    ->select('u.nome')
                    ->where('u.id = :userid')
                    ->setParameters(
                        array(
                            'userid' => $value
                        )
                    )->getQuery()->getSingleResult();

                $value_filter = $qb['nome'];

                $query = $repository->createQueryBuilder('u')
                    ->select('c.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                    ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                    ->where('u.user = :usuario and u.emissao between :dateini and :datefim')
                    ->setParameters(array(
                        'usuario' => $value,
                        'dateini' => $dateini,
                        'datefim' => $datefim,
                    ))
                    ->groupBy('c')
                    ->orderBy('c.descricao');

                /* GRÁFICO EM FORMA DE PIZZA */
                $chart = $this->getPierChart($query, $dateini, $datefim, $type_filter, $value_filter, 0);
                //$chart = $this->getBarHorChart($query, $dateini, $datefim, $type_filter, $value_filter);
                /* GRÁFICO EM FORMA DE TABELA */
                $table = $this->getTabChart($query);

            }

        }elseif($type == '3'){

            $type_filter = "Tipo de Ato: ";

            if($value == '0'){

                if($ischesp){
                    $query = $repository->createQueryBuilder('u')
                        ->select('c.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->where('b = :lotacaoid and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'lotacaoid' => $lotacao_id,
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('c')
                        ->orderBy('c.descricao');
                }else{
                    $query = $repository->createQueryBuilder('u')
                        ->select('c.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->where('u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('c')
                        ->orderBy('c.descricao');
                }


                /* GRÁFICO EM FORMA DE PIZZA */
                $chart = $this->getPierChart($query, $dateini, $datefim, $type_filter, $value_filter, 0.4);
                /* GRÁFICO EM FORMA DE TABELA */
                $table = $this->getTabChart($query);


            }else{

                $qb = $em->getRepository(TipoDeAto::class)

                    ->createQueryBuilder('u')
                    ->select('u.descricao')
                    ->where('u.id = :atoid')
                    ->setParameters(
                        array(
                            'atoid' => $value
                        )
                    )->getQuery()->getSingleResult();

                $value_filter = $qb['descricao'];
                if($ischesp){

                    $query = $repository->createQueryBuilder('u')
                        ->select('c.nome as descricao, SUM(d.peso) as pontos, COUNT(d.peso) as atos')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.user', 'c', 'WITH', 'c.id = u.user')
                        ->innerJoin('u.tipodeato', 'd', 'WITH', 'd.id = u.tipodeato')
                        ->where('d.id = :ato and b = :lotacaoid and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'ato' => $value,
                            'lotacaoid' => $lotacao_id,
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('c')
                        ->orderBy('c.nome');

                }else{


                    $query = $repository->createQueryBuilder('u')
                        ->select('c.nome as descricao, SUM(d.peso) as pontos, COUNT(d.peso) as atos')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.user', 'c', 'WITH', 'c.id = u.user')
                        ->innerJoin('u.tipodeato', 'd', 'WITH', 'd.id = u.tipodeato')
                        ->where('d.id = :ato and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'ato' => $value,
                            'dateini' => $dateini,
                            'datefim' => $datefim,
                        ))
                        ->groupBy('c')
                        ->orderBy('c.nome');
                }

                /* GRÁFICO EM FORMA DE BARRAS */
                $chart = $this->getBarHorChart($query, $dateini, $datefim, $type_filter, $value_filter);

                /* GRÁFICO EM FORMA DE TABELA */
                $table = $this->getTabChart($query);

            }

        }else{

            $type_filter = "Todos: ";

            $value_filter = "Todos";

            if($ischesp){

                $query = $repository->createQueryBuilder('u')
                    ->select('YEAR(u.emissao) as ano, MONTH(u.emissao) as mes, b.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                    ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                    ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                    ->where('b = :lotacaoid and u.emissao between :dateini and :datefim')
                    ->setParameters(array(
                        'lotacaoid' => $lotacao_id,
                        'dateini' => $dateini,
                        'datefim' => $datefim,
                    ))
                    ->groupBy('ano, mes, b');
                    //->orderBy('mes, b.descricao');

                $lotacoes = $repository->createQueryBuilder('u')
                    ->select('distinct b.descricao')
                    ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                    ->where('b = :lotacaoid')
                    ->setParameters(array(
                        'lotacaoid' => $lotacao_id,
                    ))
                    ->orderBy('b.descricao')
                    ->getQuery()->getResult();

            }else{

                $query = $repository->createQueryBuilder('u')
                    ->select('YEAR(u.emissao) as ano, MONTH(u.emissao) as mes, b.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
                    ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                    ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                    ->where('u.emissao between :dateini and :datefim')
                    ->setParameters(array(
                        'dateini' => $dateini,
                        'datefim' => $datefim,
                    ))
                    ->groupBy('ano, mes, b');
                    //->orderBy('mes, b.descricao');

                $lotacoes = $repository->createQueryBuilder('u')
                    ->select('distinct b.descricao')
                    ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                    ->orderBy('b.descricao')
                    ->getQuery()->getResult();

            }


            /** GRÁFICO EM FORMA DE LINHAS **/
            $chart = $this->getLineChart($query, $lotacoes, $dateini, $datefim, $type_filter, $value_filter);


            /* GRÁFICO EM FORMA DE TABELA VAZIO */
            $table = new TableChart();
            $table->getData()->setArrayToDataTable(array(["..."]));
        }

        $template = $this->render('esp/produtividade/reports/esp_partial.html.twig',
            array(
                'typefilter' => $type_filter,
                'valuefilter' => $value_filter,
                'filtertype' => $type,
                'filtervalue' => $value,
                'chart' => $chart,
                'table' => $table,
                'dateini' => $dateini,
                'datefim' => $datefim

            ))->getContent();

        return new JsonResponse($template);

    }


    /**
     * @Route("/esp/produtividade/rels/esp-reports-proc", name="esp_produtividade_esp-reports-proc")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function espReportsProc(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Ato::class);

        $datefim = date("Y-m-d");
        $dateini = date("Y-m-d", strtotime("-1 months"));


        $type_filter = 'Procurador: ';

        $value = $this->getUser()->getId();

        $value_filter = $this->getUser()->getNome();

        $query = $repository->createQueryBuilder('u')
            ->select('c.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
            ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
            ->where('u.user = :usuario and u.emissao between :dateini and :datefim')
            ->setParameters(array(
                'usuario' => $value,
                'dateini' => $dateini,
                'datefim' => $datefim,
            ))
            ->groupBy('c')
            ->orderBy('c.descricao');

        /* GRÁFICO EM FORMA DE PIZZA */
        $chart = $this->getPierChart($query, $dateini, $datefim, $type_filter, $value_filter, 0);
        //$chart = $this->getBarHorChart($query, $dateini, $datefim, $type_filter, $value_filter);
        /* GRÁFICO EM FORMA DE TABELA */
        $table = $this->getTabChart($query);



        return $this->render('esp/produtividade/reports/index_procurador.html.twig', array(
            'typefilter' => $type_filter,
            'valuefilter' => $value_filter,
            'chart' => $chart,
            'table' => $table,
            'dateini' => $dateini,
            'datefim' => $datefim
        ));

    }    

    /**
     * @Route("/esp/produtividade/rels/esp-filter-reports-proc", name="esp_produtividade_esp-filter-reports-proc")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function espFiltersReportsProc(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Ato::class);

        $dateini = $request->get('_dateini');
        $datefim = $request->get('_datefim');

        $type_filter = 'Procurador: ';

        $value = $this->getUser()->getId();

        $value_filter = $this->getUser()->getNome();

        $query = $repository->createQueryBuilder('u')
            ->select('c.descricao, SUM(c.peso) as pontos, COUNT(c.peso) as atos')
            ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
            ->where('u.user = :usuario and u.emissao between :dateini and :datefim')
            ->setParameters(array(
                'usuario' => $value,
                'dateini' => $dateini,
                'datefim' => $datefim,
            ))
            ->groupBy('c')
            ->orderBy('c.descricao');

        /* GRÁFICO EM FORMA DE PIZZA */
        $chart = $this->getPierChart($query, $dateini, $datefim, $type_filter, $value_filter, 0);
        //$chart = $this->getBarHorChart($query, $dateini, $datefim, $type_filter, $value_filter);
        /* GRÁFICO EM FORMA DE TABELA */
        $table = $this->getTabChart($query);


        $template = $this->render('esp/produtividade/reports/esp_partial.html.twig',
            array(
                'typefilter' => $type_filter,
                'valuefilter' => $value_filter,
                'chart' => $chart,
                'table' => $table,
                'dateini' => $dateini,
                'datefim' => $datefim

            ))->getContent();

        return new JsonResponse($template);

    }

    /**
     * @Route("/esp/produtividade/rels/export-image-chart", name="esp_produtividade_export-image-chart")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function exportImageChart(Request $request)
    {
        $imgdata = $request->get("imageData");

        $template =  $this->render('esp/produtividade/reports/esp_img.html.twig', array(
            'imglink' => $imgdata
        ))->getContent();

        return new JsonResponse($template);
    }


    /**
     * @Route("/esp/produtividade/rels/list-acts", name="esp_produtividade_list-acts")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function listarAtos(Request $request)
    {

        $session = $this->get('session');

        if(!empty($request->get("_valueselection"))){

            $valueselection = $request->get("_valueselection");
            $typefilter = $request->get("_typefilter");
            $valuefilter = $request->get("_valuefilter");
            $dateinifilter = $request->get("_dateinifilter");
            $datefimfilter = $request->get("_datefimfilter");

            $session->set('_valueselection', $valueselection);
            $session->set('_typefilter', $typefilter);
            $session->set('_valuefilter', $valuefilter);
            $session->set('_dateinifilter', $dateinifilter);
            $session->set('_datefimfilter', $datefimfilter);

        }else{

            $valueselection = $session->get("_valueselection");
            $typefilter = $session->get("_typefilter");
            $valuefilter = $session->get("_valuefilter");
            $dateinifilter = $session->get("_dateinifilter");
            $datefimfilter = $session->get("_datefimfilter");
        }

        $em = $this->getDoctrine()->getManager();

        if($valuefilter != '0'){

            switch ($typefilter){

                case '1':

                    $qb = $em->getRepository(User::class)

                        ->createQueryBuilder('u')
                        ->select('u.id')
                        ->where('u.nome = :username')
                        ->setParameters(
                            array(
                                'username' => $valueselection
                            )
                        )->getQuery()->getSingleResult();

                    $user_id = $qb['id'];

                    $query = $em->createQueryBuilder()
                        ->select('u')
                        ->from(Ato::class, 'u')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->leftJoin('u.tipodeprocesso', 'd', 'WITH', 'd.id = u.tipodeprocesso')
                        ->where('u.user = :user and u.lotacao = :espec and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'user' => intval($user_id),
                            'espec' => intval($valuefilter),
                            'dateini' => $dateinifilter,
                            'datefim' => $datefimfilter,
                        ))
                        ->orderBy('u.emissao', 'DESC');

                    break;

                case '2':

                    $qb = $em->getRepository(TipoDeAto::class)

                        ->createQueryBuilder('u')
                        ->select('u.id')
                        ->where('u.descricao = :descricao')
                        ->setParameters(
                            array(
                                'descricao' => $valueselection
                            )
                        )->getQuery()->getSingleResult();

                    $tipodeato_id = $qb['id'];

                    $query = $em->createQueryBuilder()
                        ->select('u')
                        ->from(Ato::class, 'u')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->leftJoin('u.tipodeprocesso', 'd', 'WITH', 'd.id = u.tipodeprocesso')
                        ->where('c.id = :ato and u.user = :user and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'ato' => $tipodeato_id,
                            'user' => intval($valuefilter),
                            'dateini' => $dateinifilter,
                            'datefim' => $datefimfilter,
                        ))
                        ->orderBy('u.emissao', 'DESC');
                    break;

                case '3':

                    $qb = $em->getRepository(User::class)

                        ->createQueryBuilder('u')
                        ->select('u.id')
                        ->where('u.nome = :username')
                        ->setParameters(
                            array(
                                'username' => $valueselection
                            )
                        )->getQuery()->getSingleResult();

                    $user_id = $qb['id'];

                    $query = $em->createQueryBuilder()
                        ->select('u')
                        ->from(Ato::class, 'u')
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                        ->leftJoin('u.tipodeprocesso', 'd', 'WITH', 'd.id = u.tipodeprocesso')
                        ->where('c.id = :ato and u.user = :user and u.emissao between :dateini and :datefim')
                        ->setParameters(array(
                            'ato' => intval($valuefilter),
                            'user' => $user_id,
                            'dateini' => $dateinifilter,
                            'datefim' => $datefimfilter,
                        ))
                        ->orderBy('u.emissao', 'DESC');
                    break;

            }

        }else{

            if($typefilter == '2'){

                $qb = $em->getRepository(User::class)

                    ->createQueryBuilder('u')
                    ->select('u.id')
                    ->where('u.nome = :username')
                    ->setParameters(
                        array(
                            'username' => $valueselection
                        )
                    )->getQuery()->getSingleResult();

                $user_id = $qb['id'];

                $query = $em->createQueryBuilder()
                    ->select('u')
                    ->from(Ato::class, 'u')
                    ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                    ->innerJoin('u.tipodeato', 'c', 'WITH', 'c.id = u.tipodeato')
                    ->leftJoin('u.tipodeprocesso', 'd', 'WITH', 'd.id = u.tipodeprocesso')
                    ->where('u.user = :user and u.emissao between :dateini and :datefim')
                    ->setParameters(array(
                        'user' => $user_id,
                        'dateini' => $dateinifilter,
                        'datefim' => $datefimfilter,
                    ))
                    ->orderBy('u.emissao', 'DESC');
            }
        }

        $result = $query->getQuery()->getResult();

        $template = $this->render("esp/produtividade/reports/list-acts.html.twig", array(
            'acts' => $result,
            'valueselection' => $valueselection,
            'dateinifilter' => $dateinifilter,
            'datefimfilter' => $datefimfilter,
        ))->getContent();

        return new JsonResponse($template);
    }

    /**
     * @Route("/esp/produtividade/rels/visualizar-ato/{id}", name="esp_produtividade_visualizar-ato")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function visualizarAto($id){

        $ato = $this->getDoctrine()
            ->getRepository(Ato::class)
            ->findBy(array('id' => $id));

        $template = $this->render("esp/produtividade/ato/view.html.twig", array(
            'act' => $ato,
        ))->getContent();

        return new JsonResponse($template);

    }


    /**
     * @Route("/esp/produtividade/rels/detalhar-ato/{id}", name="esp_produtividade_detalhar-ato")
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
     * @Route("/esp/produtividade/rels/esp-filters", name="esp_produtividade_esp-filters")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function filterValues(Request $request)
    {

        $rolesTab = $this->getUser()->getRoles();
        $ischesp = false;
        $lotacao_id = 0;

        $session = $this->get('session');

        $location = $session->get('current_location');

        if (in_array('ROLE_CHESP', $rolesTab, true)) {

            $ischesp = true;
            $lotacao_id = $location->getId();
        }

        $type = $request->get('_filterType');

        $em = $this->getDoctrine()->getManager();
        $result = null;
        switch ($type){

            case '1':

                if($ischesp){
                    $repository = $em->getRepository(Lotacao::class);
                    $query = $repository->createQueryBuilder('u')
                        ->select('DISTINCT u.id, u.descricao')
                        ->innerJoin('u.tiposdeato', 't')
                        ->where('u = :lotacaoid')
                        ->setParameters(array(
                            'lotacaoid' => $lotacao_id,
                        ))
                        ->orderBy('u.descricao');
                    $result = $query->getQuery()->getResult();
                }else{
                    $repository = $em->getRepository(Lotacao::class);
                    $query = $repository->createQueryBuilder('u')
                        ->select('DISTINCT u.id, u.descricao')
                        ->innerJoin('u.tiposdeato', 't')
                        ->innerJoin('u.atos', 'w')
                        ->orderBy('u.descricao');
                    $result = $query->getQuery()->getResult();
                }

                break;

            case '2':

                if($ischesp){
                    $repository = $em->getRepository(Ato::class);
                    $query = $repository->createQueryBuilder('u')
                        ->select("DISTINCT t.id, t.nome as descricao")
                        ->innerJoin('u.lotacao', 'b', 'WITH', 'b.id = u.lotacao')
                        ->innerJoin('u.user', 't', 'WITH', 't.id = u.user')
                        ->where('b = :lotacaoid')
                        ->setParameters(array(
                            'lotacaoid' => $lotacao_id,
                        ))
                        ->orderBy('t.nome');
                    $result = $query->getQuery()->getResult();
                }else{
                    $repository = $em->getRepository(Ato::class);
                    $query = $repository->createQueryBuilder('u')
                        ->select("DISTINCT t.id, t.nome as descricao")
                        ->innerJoin('u.user', 't', 'WITH', 't.id = u.user')
                        ->orderBy('t.nome');
                    $result = $query->getQuery()->getResult();
                }

                break;

            default:

                if($ischesp){
                    $repository = $em->getRepository(TipoDeAto::class);
                    $query = $repository->createQueryBuilder('u')
                        ->select("DISTINCT u.id, u.descricao")
                        ->innerJoin("u.atos", "t")
                        ->innerJoin("u.lotacoes", "s")
                        ->where('s = :lotacaoid and t.tipodeato = u')
                        ->setParameters(array(
                            'lotacaoid' => $lotacao_id,
                        ))
                        ->orderBy('u.descricao');
                    $result = $query->getQuery()->getResult();
                }else{
                    $repository = $em->getRepository(TipoDeAto::class);
                    $query = $repository->createQueryBuilder('u')
                        ->select("DISTINCT u.id, u.descricao")
                        ->innerJoin("u.atos", "t")
                        ->innerJoin("u.lotacoes", "s")
                        ->where('t.tipodeato = u')
                        ->orderBy('u.descricao');
                    $result = $query->getQuery()->getResult();
                }

                break;
        }
        return new JsonResponse($result);
    }


    /**
     * @Route("/esp/produtividade/rels/criticas", name="esp_produtividade_esp-criticas")
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    function setRelatorioDeCriticas()
    {
        $datefim = date("Y-m-d");
        $dateini = date("Y-m-d", strtotime("-2 months"));

        return $this->render('esp/produtividade/reports/esp_criticas.html.twig', array(
            'dateini' => $dateini,
            'datefim' => $datefim,
        ));
    }

    /**
     * @Route("/esp/produtividade/rels/criticas-detalhe/{dini}/{dfim}/{idesp}/{idproc}/{nproc}", name="esp_produtividade_esp-criticas-detalhe", requirements={"nproc"=".+"})
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    function getDetalhesDeCriticas($dini, $dfim, $idesp, $idproc, $nproc)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository(Ato::class);

        $query = $repository->createQueryBuilder('a')
            ->select("a.id, b.nome, a.emissao, a.assunto, c.descricao as tipodeato, d.descricao as tipodeprocesso, a.numerodoprocesso, a.descricao")
            ->innerJoin('a.user', 'b', 'WITH', 'b.id = a.user')
            ->innerJoin('a.tipodeato', 'c', 'WITH', 'c.id = a.tipodeato')
            ->innerJoin('a.tipodeprocesso', 'd', 'WITH', 'd.id = a.tipodeprocesso')
            ->innerJoin('a.lotacao', 'e', 'WITH', 'e.id = a.lotacao')
            ->where('a.emissao between :dateini and :datefim and e = :idesp and d = :idproc and a.numerodoprocesso = :nproc')
            ->setParameters(array(
                'dateini' => $dini,
                'datefim' => $dfim,
                'idesp' => $idesp,
                'idproc' => $idproc,
                'nproc' => $nproc,
            ))
            ->orderBy('b.nome');

        $result = $query->getQuery()->getResult();

        return $this->render('esp/produtividade/reports/esp_criticas_detalhe.html.twig', array(
            'dateini' => $dini,
            'datefim' => $dfim,
            'detalhe' => $result,
        ));

    }

        /**
     * @Route("/esp/produtividade/rels/criticas-report", name="esp_produtividade_esp-criticas-report")
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    function getRelatorioDeCriticas(Request $request){

        $rolesTab = $this->getUser()->getRoles();
        $ischesp = false;
        $lotacao_id = 0;

        $session = $this->get('session');

        $location = $session->get('current_location');

        $dateini = $request->get('_dateini');
        $datefim = $request->get('_datefim');

        $em = $this->getDoctrine()->getManager();

        if (in_array('ROLE_CHESP', $rolesTab, true)) {

            $ischesp = true;
            $lotacao_id = $location->getId();
        }

        $repository = $em->getRepository(Ato::class);

        if($ischesp){
            $query = $repository->createQueryBuilder('u')
                ->select("a.id, a.descricao as lotacao, b.id as idtipoprocesso, b.descricao as tipoprocesso, u.numerodoprocesso, COUNT(u.numerodoprocesso) as atos")
                ->innerJoin('u.lotacao', 'a', 'WITH', 'a.id = u.lotacao')
                ->innerJoin('u.tipodeprocesso', 'b', 'WITH', 'b.id = u.tipodeprocesso')
                ->where('u.emissao between :dateini and :datefim and a = :lotacaoid')
                ->setParameters(array(
                    'dateini' => $dateini,
                    'datefim' => $datefim,
                    'lotacaoid' => $lotacao_id,
                ))
                ->groupBy('a, b, u.numerodoprocesso')
                ->orderBy('a.descricao')
                ->having('COUNT(u.numerodoprocesso) > 1');

            $result = $query->getQuery()->getResult();
        }else{
            $query = $repository->createQueryBuilder('u')
                ->select("a.id, a.descricao as lotacao, b.id as idtipoprocesso, b.descricao as tipoprocesso, u.numerodoprocesso, COUNT(u.numerodoprocesso) as atos")
                ->innerJoin('u.lotacao', 'a', 'WITH', 'a.id = u.lotacao')
                ->innerJoin('u.tipodeprocesso', 'b', 'WITH', 'b.id = u.tipodeprocesso')
                ->where('u.emissao between :dateini and :datefim')
                ->setParameters(array(
                    'dateini' => $dateini,
                    'datefim' => $datefim,
                ))
                ->groupBy('a, b, u.numerodoprocesso')
                ->orderBy('a.descricao')
                ->having('COUNT(u.numerodoprocesso) > 1');

            $result = $query->getQuery()->getResult();
        }

        return $this->render('esp/produtividade/reports/esp_criticas_report.html.twig', array(
            'criticas' => $result,
            'dateini' => $dateini,
            'datefim' => $datefim
        ));

    }


    function getPierChart($query, $dateini, $datefim, $type, $value, $piehole){

        $chart = new PieChart();

        if($query->getQuery()->getResult()) {
            $result = array();
            array_push($result, ['Descrição', 'Produtividade']);
            $qry = $query->getQuery()->getResult();
            foreach ($qry as $k => $v) {
                array_push($result, [$v['descricao'], floatval($v['pontos'])]);
            }

            $chart->getData()->setArrayToDataTable(
                $result
            );
            $chart->getOptions()->setPieHole($piehole);
            $chart->getOptions()->setFontSize(13);
            $chart->getOptions()->setTitle($type . ": " . $value . " - período: " . date("d/m/Y", strtotime($dateini)) . " a " . date("d/m/Y", strtotime($datefim)));
            $chart->getOptions()->setHeight(500);
            $chart->getOptions()->setWidth('auto');
            $chart->getOptions()->getLegend()->setPosition('right');
            $chart->getOptions()->setIs3D(true);
        }else{
            $chart->getData()->setArrayToDataTable(array(["..."]));
        }
        return $chart;
    }

    function getTabChart($query){

        $table = new TableChart();

        if($query->getQuery()->getResult()) {
            $result = array();
            array_push($result, ['Descrição', 'Nº de Atos', 'Produtividade']);
            $qry = $query->getQuery()->getResult();
            $totpts = 0;
            $totats = 0;
            foreach ($qry as $k => $v) {
                array_push($result, [
                    $v['descricao'],
                    floatval($v['atos']),
                    floatval($v['pontos'])
                ]);
                $totpts += floatval($v['pontos']);
                $totats += floatval($v['atos']);
            }

            array_push($result, [
                'TOTAL GERAL',
                $totats,
                $totpts
            ]);

            $table->getData()->setArrayToDataTable(
                $result
            );
            $table->getOptions()->setAllowHtml(true);
            $table->getOptions()->setShowRowNumber(true);
            $table->getOptions()->setHeight('auto');
            $table->getOptions()->setWidth('auto');
        }else{
            $table->getData()->setArrayToDataTable(array(["..."]));
        }

        return $table;
    }

    function getBarHorChart($query, $dateini, $datefim, $type, $value){
        $chart = new BarChart();
        if($query->getQuery()->getResult()) {
            $result = array();
            array_push($result, ['Descrição', 'Produtividade']);
            $qry = $query->getQuery()->getResult();
            foreach ($qry as $k => $v) {
                array_push($result, [$v['descricao'], floatval($v['pontos'])]);
            }

            $chart->getData()->setArrayToDataTable(
                $result
            );
            $chart->getOptions()->setTitle($type . ": " . $value . " - período: " . date("d/m/Y", strtotime($dateini)) . " a " . date("d/m/Y", strtotime($datefim)));
            $chart->getOptions()->getHAxis()->setTitle('Produtividade');
            $chart->getOptions()->getBar()->setGroupWidth('60%');
            $chart->getOptions()->getHAxis()->setMinValue(0);
            $chart->getOptions()->getLegend()->setPosition('none');
            $chart->getOptions()->setFontSize(12)
                ->setHeight(500)
                ->setWidth('auto');
            $chart->getOptions()->getAnimation()->setDuration(1000)->setEasing('out')->setStartup(true);
        }else{
            $chart->getData()->setArrayToDataTable(array(["..."]));
        }
        return $chart;
    }

    function getComboChart($query, $dateini, $datefim, $type, $value){
        $chart = new ComboChart();
        if($query->getQuery()->getResult()) {
            $result = array();
            array_push($result, ['Descrição', 'Produtividade']);
            $qry = $query->getQuery()->getResult();
            foreach ($qry as $k => $v) {
                array_push($result, [$v['descricao'], floatval($v['pontos'])]);
            }

            $chart->getData()->setArrayToDataTable(
                $result
            );
            $chart->getOptions()->setTitle($type . ": " . $value . " - período: " . date("d/m/Y", strtotime($dateini)) . " a " . date("d/m/Y", strtotime($datefim)));
            $chart->getOptions()
                ->setFontSize(12)
                ->setHeight(500)
                ->setWidth('auto');
            $chart->getOptions()->getVAxis()->setTitle("Produtividade");
            $chart->getOptions()->getBar()->setGroupWidth('60%');
            $chart->getOptions()->getLegend()->setPosition('none');
            $chart->getOptions()->setSeriesType('bars');
            $chart->getOptions()->getAnimation()->setDuration(1000)->setEasing('out')->setStartup(true);
        }else{
            $chart->getData()->setArrayToDataTable(array(["..."]));
        }
        return $chart;
    }

    function getLineChart($query, $lotacoes, $dateini, $datefim, $type, $value){

        $chart = new LineChart();

        if($query->getQuery()->getResult()){
            $esps = array("MES");
            $result = array();

            foreach ($lotacoes as $k => $v){
                array_push($esps, $v['descricao']);
            }

            array_push($result, $esps);

            $qry = $query->getQuery()->getResult();
            $mesant = intval(0);

            setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
            date_default_timezone_set( 'America/Sao_Paulo' );

            foreach ($qry as $k => $v) {

                $key = array_search($v['descricao'], $esps);

                $year = $v['ano'];

                if($mesant != intval($v['mes'])){
                    if(isset($value_array)){

                        array_push($result, $value_array);

                        $monthNum  = intval($v['mes']);
                        $dateObj   = \DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $year."/".strftime( '%b', $dateObj -> getTimestamp() );#$dateObj->format('M'); // March

                        $value_array = array($monthName);

                        $mesant = intval($v['mes']);

                        for($i = 1; $i < sizeof($esps); $i++){
                            if($key == $i){
                                $value_array[$i] = floatval($v['pontos']);
                            }else{
                                $value_array[$i] = floatval(0);
                            }
                        }

                    }else{
                        $monthNum  = intval($v['mes']);
                        $dateObj   = \DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $year."/".strftime( '%b', $dateObj -> getTimestamp() );#$dateObj->format('M'); // March

                        $value_array = array($monthName);

                        $mesant = intval($v['mes']);
                        for($i = 1; $i < sizeof($esps); $i++){
                            if($key == $i){
                                $value_array[$i] = floatval($v['pontos']);
                            }else{
                                $value_array[$i] = floatval(0);
                            }
                        }
                    }
                }else{
                    for($i = 1; $i < sizeof($esps); $i++){
                        if($key == $i){
                            $value_array[$i] = floatval($v['pontos']);
                        }
                    }
                    $mesant = intval($v['mes']);
                }
            }

            array_push($result, $value_array);

            $chart->getData()->setArrayToDataTable(
                $result
            );

            $chart->getOptions()->setTitle($type.": ".$value." - período: ".date("d/m/Y", strtotime($dateini))." a ".date("d/m/Y", strtotime($datefim)))
                ->setFontSize(12)
                ->setHeight(500)
                ->setWidth('auto')
                ->setCurveType('function')
                ->setLineWidth(4)
                ->getLegend()->setPosition('right');
                $chart->getOptions()->getAnimation()->setDuration(1000)->setEasing('out')->setStartup(true);
        }else{
            $chart->getData()->setArrayToDataTable(array(["..."]));
        }

        return $chart;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 26/04/2018
 * Time: 07:55
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Ato
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="ato")
 */
class Ato
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="numero", type="string", nullable=true)
     */
    protected $numero;

    /**
     * @ORM\Column(name="interessado", type="string", nullable=true)
     */
    protected $interessado;

    /**
     * @ORM\Column(name="favoravel", type="boolean", nullable=true)
     */
    protected $favoravel;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="emissao", type="date", nullable=false)
     */
    protected $emissao;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="assunto", type="string", nullable=false)
     */
    protected $assunto;

    /**
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    protected $descricao;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="TipoDeAto", inversedBy="atos")
     * @ORM\JoinColumn(name="tipodeato_id", referencedColumnName="id")
     */
    protected $tipodeato;

    /**
     * @ORM\ManyToOne(targetEntity="TipoDeProcesso", inversedBy="atos")
     * @ORM\JoinColumn(name="tipodeprocesso_id", referencedColumnName="id")
     */
    protected $tipodeprocesso;

    /**
     * @ORM\Column(name="numerodoprocesso", type="string", nullable=true)
     */
    protected $numerodoprocesso;


    /**
     * @ORM\ManyToOne(targetEntity="Lotacao", inversedBy="atos")
     * @ORM\JoinColumn(name="lotacao_id", referencedColumnName="id")
     */
    protected $lotacao;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="atos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(name="datacadastro", type="date", nullable=true)
     */
    protected $datacadastro;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\dai\rh\Documento", mappedBy="ato", cascade={"persist","remove"})
     */
    protected $files;


    public function __construct()
    {
        $this->emissao = new \DateTime();
        $this->datacadastro = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmissao()
    {
        return $this->emissao;
    }

    /**
     * @param mixed $emissao
     */
    public function setEmissao($emissao)
    {
        $this->emissao = $emissao;
    }

    /**
     * @return mixed
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }


    /**
     * @return mixed
     */
    public function getTipodeato()
    {
        return $this->tipodeato;
    }

    /**
     * @param mixed $tipodeato
     */
    public function setTipodeato($tipodeato)
    {
        $this->tipodeato = $tipodeato;
    }

    /**
     * @return mixed
     */
    public function getTipodeprocesso()
    {
        return $this->tipodeprocesso;
    }

    /**
     * @param mixed $tipodeprocesso
     */
    public function setTipodeprocesso($tipodeprocesso)
    {
        $this->tipodeprocesso = $tipodeprocesso;
    }

    /**
     * @return mixed
     */
    public function getNumerodoprocesso()
    {
        return $this->numerodoprocesso;
    }

    /**
     * @param mixed $numerodoprocesso
     */
    public function setNumerodoprocesso($numerodoprocesso)
    {
        $this->numerodoprocesso = $numerodoprocesso;
    }

    /**
     * @return mixed
     */
    public function getLotacao()
    {
        return $this->lotacao;
    }

    /**
     * @param mixed $lotacao
     */
    public function setLotacao($lotacao)
    {
        $this->lotacao = $lotacao;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getInteressado()
    {
        return $this->interessado;
    }

    /**
     * @param mixed $interessado
     */
    public function setInteressado($interessado)
    {
        $this->interessado = $interessado;
    }

    /**
     * @return mixed
     */
    public function getFavoravel()
    {
        return $this->favoravel;
    }

    /**
     * @param mixed $favoravel
     */
    public function setFavoravel($favoravel)
    {
        $this->favoravel = $favoravel;
    }

    /**
     * @return mixed
     */
    public function getDatacadastro()
    {
        return $this->datacadastro;
    }

    /**
     * @param mixed $datacadastro
     */
    public function setDatacadastro($datacadastro)
    {
        $this->datacadastro = $datacadastro;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Permite verificar se o registro/alteração de um ato do mês está ocorrendo até o 5 dia do mês posterior
     * @param $dia integer
     * @return boolean
     */
    public function verificaAto($dia){

        $data_do_ato = $this->emissao;
        $mes_do_registro = date('m');
        $ano_do_registro = date('Y');
        $dia_do_registro = date('d');
        $quinto_dia_util = $this->getDiaUtil($dia, $mes_do_registro, $ano_do_registro);
        $mes_anterior = date('m', strtotime('-1 months', strtotime(date('m'))));

        $mes_do_ato = $data_do_ato->format('m');
        $ano_do_ato = $data_do_ato->format('Y');
        return true;
        /*
        if($mes_do_ato == $mes_do_registro && $ano_do_ato == $ano_do_registro){
            return true;
        } else if($mes_do_ato == $mes_anterior && $dia_do_registro <= $quinto_dia_util){
            return true;
        }else{
            return false;
        }*/

    }

    /**
     * Informa qual é o dia útil do mês
     * Ex.: Caso deseja saber qual é o 15º útil do mês
     * @param int $iDia = dia
     * @param int $iMes = Mês, se não informado pega o mês atual
     * @param int $iAno = Ano, se não informado pega o ano atual
     * @return int
     */
    function getDiaUtil($iDia, $iMes = null, $iAno = null, $aDiasIgnorar = array()) {

        $iMes = empty($iMes) ? date('m') : $iMes;
        $iAno = empty($iAno) ? date('Y') : $iAno;
        $iUltimoDiaMes = date("t", mktime(0, 0, 0, $iMes, '01', $iAno));

        for ($i = 1; $i <= $iUltimoDiaMes; $i++) {
            $iDiaSemana = date('N', mktime(0, 0, 0, $iMes, $i, $iAno));
            //inclui apenas os dias úteis
            if ($iDiaSemana < 6) {
                $aDias[] = date('j', mktime(0, 0, 0, $iMes, $i, $iAno));
            }
        }
        //ignorando os feriados
        if (sizeof($aDiasIgnorar) > 0) {
            foreach ($aDiasIgnorar as $iDia) {
                $iKey = array_search($iDia, $aDias);
                unset($aDias[$iKey]);
            }
        }

        if (isset($aDias[$iDia - 1])) {
            return $aDias[$iDia - 1];
        } else {
            //retorna o último dia útil
            return $aDias[count($aDias) - 1];
        }
    }


}

<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 26/10/18
 * Time: 08:28
 */

namespace App\Entity\esp\eleicao;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Voto
 * @package App\Entity\esp\eleicao
 * @ORM\Entity
 * @ORM\Table(name="voto")
 */
class Voto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="votos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $eleitor;

    /**
     * @ORM\Column(name="peso", type="integer", nullable=false)
     */
    protected $peso;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $chave;

    /**
     * @ORM\ManyToOne(targetEntity="Candidato", inversedBy="votos")
     * @ORM\JoinColumn(name="candidato_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $candidato;

    /**
     * @ORM\ManyToOne(targetEntity="Eleicao", inversedBy="votos")
     * @ORM\JoinColumn(name="eleicao_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $eleicao;

    public function __construct($eleitor, $eleicao)
    {
        $this->eleitor = $eleitor;
        $this->eleicao = $eleicao;
        $this->peso = 1;
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
    public function getEleitor()
    {
        return $this->eleitor;
    }

    /**
     * @param mixed $eleitor
     */
    public function setEleitor($eleitor)
    {
        $this->eleitor = $eleitor;
    }

    /**
     * @return mixed
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @param mixed $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    /**
     * @return mixed
     */
    public function getChave()
    {
        return $this->chave;
    }

    /**
     * @param mixed $chave
     */
    public function setChave($chave)
    {
        $this->chave = $chave;
    }

    /**
     * @return mixed
     */
    public function getCandidato()
    {
        return $this->candidato;
    }

    /**
     * @param mixed $candidato
     */
    public function setCandidato($candidato)
    {
        $this->candidato = $candidato;
    }

    /**
     * @return mixed
     */
    public function getEleicao()
    {
        return $this->eleicao;
    }

    /**
     * @param mixed $eleicao
     */
    public function setEleicao($eleicao)
    {
        $this->eleicao = $eleicao;
    }
}
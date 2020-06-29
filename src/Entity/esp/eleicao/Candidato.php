<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 26/10/18
 * Time: 08:28
 */

namespace App\Entity\esp\eleicao;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Candidato
 * @package App\Entity\esp\eleicao
 * @ORM\Entity
 * @ORM\Table(name="candidato")
 */
class Candidato
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=254, nullable=false)
     */
    protected $candidato;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Voto", mappedBy="candidato")
     */
    protected $votos;

    /**
     * @ORM\ManyToOne(targetEntity="Eleicao", inversedBy="candidatos")
     * @ORM\JoinColumn(name="eleicao_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $eleicao;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0})
     */
    protected $total;

    /**
     * Candidato constructor.
     * @param $eleicao
     */
    public function __construct($eleicao)
    {
        $this->eleicao = $eleicao;
        $this->total = 0;
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
    public function getVotos()
    {
        return $this->votos;
    }

    /**
     * @param mixed $votos
     */
    public function setVotos($votos)
    {
        $this->votos = $votos;
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

    /**
     * @return mixed
     */
    public function getTotal()
    {
        foreach ($this->votos as $i){
            $this->total += $i->getPeso();
        }
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 23/05/2018
 * Time: 10:38
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TipoDeProcesso
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="tipodeprocesso")
 */
class TipoDeProcesso
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=false)
     */
    protected $descricao;

    /**
     * @ORM\Column(name="peso", type="float", nullable=false)
     */
    protected $peso;


    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Lotacao", mappedBy="tiposdeprocesso")
     */
    protected $lotacoes;


    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Ato", mappedBy="tipodeprocesso")
     */
    protected $atos;

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
     * @return ArrayCollection
     */
    public function getLotacoes(): ArrayCollection
    {
        return $this->lotacoes;
    }

    /**
     * @param ArrayCollection $lotacoes
     */
    public function setLotacoes(ArrayCollection $lotacoes)
    {
        $this->lotacoes = $lotacoes;
    }

    /**
     * @return ArrayCollection
     */
    public function getAtos(): ArrayCollection
    {
        return $this->atos;
    }

    /**
     * @param ArrayCollection $atos
     */
    public function setAtos(ArrayCollection $atos)
    {
        $this->atos = $atos;
    }
}
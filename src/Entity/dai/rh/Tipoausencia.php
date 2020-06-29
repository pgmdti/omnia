<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 20/03/2018
 * Time: 10:44
 */

namespace App\Entity\dai\rh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tipoausencia
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="tipoausencia")
 */
class Tipoausencia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=false)
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     */
    protected $descricao;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Ausencia", mappedBy="tipoausencia")
     */
    protected $ausencias;

    /**
     * @var boolean
     * @ORM\Column(name="temperiodo", type="boolean", nullable=false)
     */
    protected $temperiodo;

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
     * @return ArrayCollection
     */
    public function getAusencias(): ArrayCollection
    {
        return $this->ausencias;
    }

    /**
     * @param ArrayCollection $ausencias
     */
    public function setAusencias(ArrayCollection $ausencias)
    {
        $this->ausencias = $ausencias;
    }

    /**
     * @return mixed $temperiodo
     */
    public function isTemperiodo()
    {
        return $this->temperiodo;
    }

    /**
     * @param mixed $temperiodo
     */
    public function setTemperiodo(bool $temperiodo)
    {
        $this->temperiodo = $temperiodo;
    }

}
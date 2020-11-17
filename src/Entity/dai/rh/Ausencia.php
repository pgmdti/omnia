<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 28/03/2018
 * Time: 08:09
 */

namespace App\Entity\dai\rh;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Ausencia
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="ausencia")
 */
class Ausencia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=true)
     */
    protected $descricao;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Tipoausencia", inversedBy="ausencias")
     * @ORM\JoinColumn(name="tipoausencia_id", referencedColumnName="id")
     */
    protected $tipoausencia;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="dataini", type="date", nullable=true)
     */
    protected $dataini;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="datafim", type="date", nullable=true)
     */
    protected $datafim;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="ausencias")
     * @ORM\JoinColumns(
     *      @ORM\JoinColumn(name="employee_matricula", referencedColumnName="matricula"),
     *      @ORM\JoinColumn(name="employee_cpf", referencedColumnName="cpf")
     * )
     */
    protected $employee;

    /**
     *
     * @ORM\OneToMany(targetEntity="Documento", mappedBy="ausencia", cascade={"persist"})
     *
     */
    protected $files;

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
    public function getTipoausencia()
    {
        return $this->tipoausencia;
    }

    /**
     * @param mixed $tipoausencia
     */
    public function setTipoausencia($tipoausencia)
    {
        $this->tipoausencia = $tipoausencia;
    }

    /**
     * @return mixed
     */
    public function getDataini()
    {
        return $this->dataini;
    }

    /**
     * @param mixed $dataini
     */
    public function setDataini($dataini)
    {
        $this->dataini = $dataini;
    }

    /**
     * @return mixed
     */
    public function getDatafim()
    {
        return $this->datafim;
    }

    /**
     * @param mixed $datafim
     */
    public function setDatafim($datafim)
    {
        $this->datafim = $datafim;
    }

    /**
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param mixed $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
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
}
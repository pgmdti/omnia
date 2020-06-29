<?php

namespace App\Entity\dai\rh;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Asset\Package;

/**
 * Class Documento
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="documento")
 */
class Documento{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="files")
     * @ORM\JoinColumns(
     *      @ORM\JoinColumn(name="employee_matricula", referencedColumnName="matricula"),
     *      @ORM\JoinColumn(name="employee_cpf", referencedColumnName="cpf")
     * )
     */
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity="Ausencia", inversedBy="files")
     * @ORM\JoinColumn(name="ausencia_id", referencedColumnName="id")
     */
    protected $ausencia;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ato", inversedBy="files")
     * @ORM\JoinColumn(name="ato_id", referencedColumnName="id")
     */
    protected $ato;

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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
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
    public function getAusencia()
    {
        return $this->ausencia;
    }

    /**
     * @param mixed $ausencia
     */
    public function setAusencia($ausencia)
    {
        $this->ausencia = $ausencia;
    }

    /**
     * @return mixed
     */
    public function getAto()
    {
        return $this->ato;
    }

    /**
     * @param mixed $ato
     */
    public function setAto($ato)
    {
        $this->ato = $ato;
    }


}
<?php

namespace App\Entity\dti;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Chamado
 * @package App\Entity\dti
 * @ORM\Entity
 * @ORM\Table(name="chamado")
 */
class Chamado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dai\rh\Departamento", inversedBy="chamados")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    protected $departamento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dai\rh\Employee", inversedBy="chamados")
     * @ORM\JoinColumn(name="responsavel", referencedColumnName="matricula")
     */
    protected $responsavel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dai\rh\Employee", inversedBy="chamados")
     * @ORM\JoinColumn(name="criado_por", referencedColumnName="matricula")
     */
    protected $criado_por;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dai\rh\Employee", inversedBy="chamados")
     * @ORM\JoinColumn(name="solicitado_por", referencedColumnName="matricula")
     */
    protected $solicitado_por;

    /**
     * @ORM\Column(name="titulo", type="string", length=255, nullable=false)
     */
    protected $titulo;

    /**
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    protected $status;

    /**
     * @ORM\Column(name="datacadastro", type="date", nullable=true)
     */
    protected $datacadastro;

    /**
     * @ORM\Column(name="dataabertura", type="date", nullable=true)
     */
    protected $dataabertura;
    
    /**
     * @ORM\Column(name="datafechamento", type="date", nullable=true)
     */
    protected $datafechamento;

    /**
     * @ORM\Column(name="solucaoadotada", type="text", length=65535, nullable=true)
     */
    protected $solucaoadotada;

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getSolicitadoPor()
    {
        return $this->solicitado_por;
    }

    /**
     * @param mixed $solicitado_por
     */
    public function setSolicitadoPor($solicitado_por)
    {
        $this->solicitado_por = $solicitado_por;
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
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * @param mixed $responsavel
     */
    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;
    }

    /**
     * @return mixed
     */
    public function getCriadoPor()
    {
        return $this->criado_por;
    }

    /**
     * @param mixed $criado_por
     */
    public function setCriadoPor($criado_por)
    {
        $this->criado_por = $criado_por;
    }

    /**
     * @return mixed
     */
    public function getDataabertura()
    {
        return $this->dataabertura;
    }

    /**
     * @param mixed $dataabertura
     */
    public function setDataabertura($dataabertura)
    {
        $this->dataabertura = $dataabertura;
    }

    /**
     * @return mixed
     */
    public function getDatafechamento()
    {
        return $this->datafechamento;
    }

    /**
     * @param mixed $datafechamento
     */
    public function setDatafechamento($datafechamento)
    {
        $this->datafechamento = $datafechamento;
    }

    /**
     * @return mixed
     */
    public function getSolucaoadotada()
    {
        return $this->solucaoadotada;
    }

    /**
     * @param mixed $solucaoadotada
     */
    public function setSolucaoadotada($solucaoadotada)
    {
        $this->solucaoadotada = $solucaoadotada;
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
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }
}

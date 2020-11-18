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
}

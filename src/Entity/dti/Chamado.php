<?php

namespace App\Entity\dti;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChamadoRepository")
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
     * @ORM\ManyToOne(targetEntity="Departamento", inversedBy="chamados")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    protected $departamento;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="chamados")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
    protected $responsavel;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="chamados")
     * @ORM\JoinColumn(name="criado_por_id", referencedColumnName="id")
     */
    protected $criado_por;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="chamados")
     * @ORM\JoinColumn(name="solicitado_por_id", referencedColumnName="id")
     */
    protected $solicitado_por;

    /**
     * @ORM\Column(name="titulo", type="varchar", length=255, nullable=false)
     */
    protected $titulo;

    /**
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\Column(name="status", type="varchar", length=20, nullable=false)
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

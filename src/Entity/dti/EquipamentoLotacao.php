<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 21/09/18
 * Time: 12:18
 */

namespace App\Entity\dti;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EquipamentoLotacao
 * @package App\Entity\dti
 * @ORM\Entity
 * @ORM\Table(name="equipamentolotacao")
 */
class EquipamentoLotacao
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="emissao", type="date", nullable=true)
     */
    protected $emissao;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="Equipamento", inversedBy="local")
     * @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     */
    protected $equipamento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lotacao", inversedBy="equipamentos")
     * @ORM\JoinColumn(name="lotacao_id", referencedColumnName="id")
     */
    protected $lotacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dai\rh\Employee", inversedBy="equipamentos")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="matricula")
     */
    protected $employee;

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
    public function getEquipamento()
    {
        return $this->equipamento;
    }

    /**
     * @param mixed $equipamento
     */
    public function setEquipamento($equipamento)
    {
        $this->equipamento = $equipamento;
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

}
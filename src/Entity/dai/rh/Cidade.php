<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 21/03/2018
 * Time: 08:34
 */

namespace App\Entity\dai\rh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Cidade
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="cidade")
 */
class Cidade implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $codigo;

    /**
     * @ORM\Column(name="uf", type="string", nullable=false, length=2)
     */
    protected $uf;

    /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="cidades")
     * @ORM\JoinColumn(name="ufid", referencedColumnName="id")
     */
    protected $ufid;

    /**
     * @ORM\Column(name="nome", type="string", nullable=false)
     */
    protected $nome;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="cidade")
     */
    protected $employees;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="naturalidade")
     */
    protected $employeesnatu;

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    /**
     * @return ArrayCollection
     */
    public function getEmployees(): ArrayCollection
    {
        return $this->employees;
    }

    /**
     * @param ArrayCollection $employees
     */
    public function setEmployees(ArrayCollection $employees)
    {
        $this->employees = $employees;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmployeesnatu(): ArrayCollection
    {
        return $this->employeesnatu;
    }

    /**
     * @param ArrayCollection $employeesnatu
     */
    public function setEmployeesnatu(ArrayCollection $employeesnatu)
    {
        $this->employeesnatu = $employeesnatu;
    }



    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'codigo' => $this->getCodigo(),
            'uf'     => $this->getUf(),
            'nome'   => $this->getNome()
        ];
    }
}

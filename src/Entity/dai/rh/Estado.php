<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 21/03/2018
 * Time: 08:37
 */

namespace App\Entity\dai\rh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Estado
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="estado")
 */
class Estado
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=2)
     */
    protected $uf;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Cidade", mappedBy="ufid")
     */
    protected $cidades;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="uf")
     */
    protected $employees;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="ufnatu")
     */
    protected $employeesnatu;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="ufrg")
     */
    protected $employeesrg;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="ufeleitor")
     */
    protected $employeeseleitor;

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
     * @return ArrayCollection
     */
    public function getCidades(): ArrayCollection
    {
        return $this->cidades;
    }

    /**
     * @param ArrayCollection $cidades
     */
    public function setCidades(ArrayCollection $cidades)
    {
        $this->cidades = $cidades;
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
     * @return ArrayCollection
     */
    public function getEmployeesrg(): ArrayCollection
    {
        return $this->employeesrg;
    }

    /**
     * @param ArrayCollection $employeesrg
     */
    public function setEmployeesrg(ArrayCollection $employeesrg)
    {
        $this->employeesrg = $employeesrg;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmployeeseleitor(): ArrayCollection
    {
        return $this->employeeseleitor;
    }

    /**
     * @param ArrayCollection $employeeseleitor
     */
    public function setEmployeeseleitor(ArrayCollection $employeeseleitor)
    {
        $this->employeeseleitor = $employeeseleitor;
    }


}
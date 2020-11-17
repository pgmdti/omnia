<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 28/03/2018
 * Time: 09:21
 */

namespace App\Entity\dai\rh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Orgao
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="orgao")
 */
class Orgao
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $descricao;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="orgao")
     */
    protected $employees;

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
}
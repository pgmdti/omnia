<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 20/03/2018
 * Time: 10:19
 */

namespace App\Entity\dai\rh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Departamento
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="departamento")
 */
class Departamento
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nome", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $nome;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="departamento")
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
<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 23/09/18
 * Time: 19:42
 */

namespace App\Entity\dti;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Marca
 * @package App\Entity\dti
 * @ORM\Entity
 * @ORM\Table(name="marca")
 */
class Marca
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="marca", type="string", nullable=true)
     */
    protected $marca;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Equipamento", mappedBy="marca")
     */
    protected $equipamentos;

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
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getEquipamentos()
    {
        return $this->equipamentos;
    }

    /**
     * @param mixed $equipamentos
     */
    public function setEquipamentos($equipamentos)
    {
        $this->equipamentos = $equipamentos;
    }

}
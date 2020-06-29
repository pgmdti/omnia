<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 25/09/18
 * Time: 11:36
 */

namespace App\Entity\dti;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Status
 * @package App\Entity\dti
 * @ORM\Entity
 * @ORM\Table(name="status")
 */
class Status
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    protected $status;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Equipamento", mappedBy="status")
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
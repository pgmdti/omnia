<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 23/09/18
 * Time: 20:12
 */

namespace App\Entity\dti;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TipoEquipamento
 * @package App\Entity\dti
 * @ORM\Entity
 * @ORM\Table(name="tipoequipamento")
 */
class TipoEquipamento
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=true)
     */
    protected $descricao;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Equipamento", mappedBy="tipo")
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
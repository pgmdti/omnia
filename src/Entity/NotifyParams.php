<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 19/11/18
 * Time: 07:48
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NotifyParams
 * @package App\Services
 * @ORM\Entity
 * @ORM\Table(name="params")
 */
class NotifyParams
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $descricao;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $emails;


    /**
     * @ORM\Column(type="array", nullable=false)
     */
    protected $periodicidade;

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
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param mixed $emails
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return mixed
     */
    public function getPeriodicidade()
    {
        return $this->periodicidade;
    }

    /**
     * @param mixed $periodicidade
     */
    public function setPeriodicidade($periodicidade)
    {
        $this->periodicidade = $periodicidade;
    }
}
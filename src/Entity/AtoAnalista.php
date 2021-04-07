<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 02/05/19
 * Time: 09:36
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AtoAnalista
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="atoanalista")
 */
class AtoAnalista
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="numero", type="string", nullable=true)
     */
    protected $numero;

    /**
     * @ORM\Column(name="emissao", type="date", nullable=false)
     */
    protected $emissao;

    /**
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="TipoDeAto", inversedBy="atosanalistas")
     * @ORM\JoinColumn(name="tipodeato_id", referencedColumnName="id")
     */
    protected $tipodeato;

    /**
     * @ORM\ManyToOne(targetEntity="Lotacao", inversedBy="atosanalistas")
     * @ORM\JoinColumn(name="lotacao_id", referencedColumnName="id")
     */
    protected $lotacao;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="atosanalistas")
     * @ORM\JoinColumn(name="analista_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="procuradoresanalistas")
     * @ORM\JoinColumn(name="procurador_id", referencedColumnName="id")
     */
    protected $procurador;

    /**
     * @ORM\Column(name="datacadastro", type="date", nullable=true)
     */
    protected $datacadastro;


    public function __construct()
    {
        $this->emissao = new \DateTime();
        $this->datacadastro = new \DateTime();
    }

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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
    public function getTipodeato()
    {
        return $this->tipodeato;
    }

    /**
     * @param mixed $tipodeato
     */
    public function setTipodeato($tipodeato)
    {
        $this->tipodeato = $tipodeato;
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProcurador()
    {
        return $this->procurador;
    }

    /**
     * @param mixed $procurador
     */
    public function setProcurador($procurador)
    {
        $this->procurador = $procurador;
    }


    /**
     * @return mixed
     */
    public function getDatacadastro()
    {
        return $this->datacadastro;
    }

    /**
     * @param mixed $datacadastro
     */
    public function setDatacadastro($datacadastro)
    {
        $this->datacadastro = $datacadastro;
    }

}
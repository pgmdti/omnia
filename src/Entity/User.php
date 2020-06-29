<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 10/04/2018
 * Time: 11:30
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="app_users", uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"matricula"})})
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $matricula;

    /**
     * @ORM\Column(type="string", length=254, nullable=false)
     */
    protected $nome;

    /**
     * @ORM\ManyToMany(targetEntity="Lotacao", inversedBy="users")
     * @ORM\JoinColumn(name="lotacao_id", referencedColumnName="id")
     * @ORM\OrderBy({"descricao" = "ASC"})
     */
    protected $lotacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dai\rh\Cargo", inversedBy="users")
     * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
     * @ORM\OrderBy({"descricao" = "ASC"})
     */
    protected $cargo;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Ato", mappedBy="user_id")
     * @ORM\OrderBy({"emissao" = "DESC"})
     */
    protected $atos;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AtoAnalista", mappedBy="analista_id")
     * @ORM\OrderBy({"emissao" = "DESC"})
     */
    protected $atosanalistas;


    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AtoAnalista", mappedBy="procurador_id")
     * @ORM\OrderBy({"emissao" = "DESC"})
     */
    protected $procuradoresanalistas;


    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\esp\eleicao\Voto", mappedBy="eleitor")
     */
    protected $votos;

    public function __construct()
    {
        $this->roles = array('ROLE_AESP');
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
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
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @param mixed $cargo
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }


    /**
     * @return mixed
     */
    public function getAtos()
    {
        return $this->atos;
    }

    /**
     * @param mixed $atos
     */
    public function setAtos($atos)
    {
        $this->atos = $atos;
    }

    /**
     * @return ArrayCollection
     */
    public function getAtosanalistas(): ArrayCollection
    {
        return $this->atosanalistas;
    }

    /**
     * @param ArrayCollection $atosanalistas
     */
    public function setAtosanalistas(ArrayCollection $atosanalistas)
    {
        $this->atosanalistas = $atosanalistas;
    }

    /**
     * @return ArrayCollection
     */
    public function getProcuradoresanalistas(): ArrayCollection
    {
        return $this->procuradoresanalistas;
    }

    /**
     * @param ArrayCollection $procuradoresanalistas
     */
    public function setProcuradoresanalistas(ArrayCollection $procuradoresanalistas)
    {
        $this->procuradoresanalistas = $procuradoresanalistas;
    }

    /**
     * @return mixed
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param mixed $matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * @return mixed
     */
    public function getVotos()
    {
        return $this->votos;
    }

    /**
     * @param mixed $votos
     */
    public function setVotos($votos)
    {
        $this->votos = $votos;
    }

}
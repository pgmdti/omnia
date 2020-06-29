<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 26/10/18
 * Time: 08:28
 */

namespace App\Entity\esp\eleicao;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Eleicao
 * @package App\Entity\esp\eleicao
 * @ORM\Entity
 * @ORM\Table(name="eleicao")
 */
class Eleicao
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=254, nullable=false)
     */
    protected $titulo;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $inicio;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $termino;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Candidato", mappedBy="eleicao")
     */
    protected $candidatos;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Voto", mappedBy="eleicao")
     */
    protected $votos;

    /**
     * Eleicao constructor.
     * @param $titulo
     */
    public function __construct()
    {
        date_default_timezone_set("America/Fortaleza");
        $this->inicio = new \DateTime();
        $this->termino = new \DateTime();
    }


    public function verificaPleito(){
       date_default_timezone_set("America/Fortaleza");
       $now = new \DateTime();
       $hourbegin = $this->inicio;
       $hourend = $this->termino;
       $hournow = $now;
       return (($hournow >= $hourbegin) && ($hournow <= $hourend));
    }

    public function verificaVoto($user){
        /**
         * @var boolean $confirma
         */
        $confirma = true;
        foreach ($this->votos as $i){
            if($i->getEleitor()->getMatricula() == $user->getMatricula()){
                $confirma = false;
                break;
            }
        }
        return $confirma;
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
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }

    /**
     * @return mixed
     */
    public function getTermino()
    {
        return $this->termino;
    }

    /**
     * @param mixed $termino
     */
    public function setTermino($termino)
    {
        $this->termino = $termino;
    }

    /**
     * @return mixed
     */
    public function getCandidatos()
    {
        return $this->candidatos;
    }

    /**
     * @param mixed $candidatos
     */
    public function setCandidatos($candidatos)
    {
        $this->candidatos = $candidatos;
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
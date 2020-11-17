<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 26/04/2018
 * Time: 08:57
 */

namespace App\Entity\esp\produtividade;

use App\Entity\Ato;
use App\Entity\Lotacao;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class Produtividade
 * @package App\Entity\esp\produtividade
 */
class Produtividade
{

    /**
     * @var mixed
     */
    protected $ano;

    /**
     * @var Date
     */
    protected $dataini;

    /**
     * @var Date
     */
    protected $datafim;

    /**
     * @var Lotacao
     */
    protected $especializada;

    /**
     * @var User
     */
    protected $procurador;

    /**
     * @var Collection
     */
    protected $atos;

    /**
     * @return mixed
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param mixed $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    /**
     * @return Date
     */
    public function getDataini(): Date
    {
        return $this->dataini;
    }

    /**
     * @param Date $dataini
     */
    public function setDataini(Date $dataini)
    {
        $this->dataini = $dataini;
    }

    /**
     * @return Date
     */
    public function getDatafim(): Date
    {
        return $this->datafim;
    }

    /**
     * @param Date $datafim
     */
    public function setDatafim(Date $datafim)
    {
        $this->datafim = $datafim;
    }

    /**
     * @return Lotacao
     */
    public function getEspecializada(): Lotacao
    {
        return $this->especializada;
    }

    /**
     * @param Lotacao $especializada
     */
    public function setEspecializada(Lotacao $especializada)
    {
        $this->especializada = $especializada;
    }

    /**
     * @return User
     */
    public function getProcurador(): User
    {
        return $this->procurador;
    }

    /**
     * @param User $procurador
     */
    public function setProcurador(User $procurador)
    {
        $this->procurador = $procurador;
    }

    /**
     * @return Collection
     */
    public function getAtos(): Collection
    {
        return $this->atos;
    }

    /**
     * @param Collection $atos
     */
    public function setAtos(Collection $atos)
    {
        $this->atos = $atos;
    }

}
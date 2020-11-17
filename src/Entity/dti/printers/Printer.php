<?php

namespace App\Entity\dti\printers;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Printer
 * @package App\Entity\dti\printers
 * @ORM\Entity
 * @ORM\Table(name="printer")
 */
class Printer{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="local", type="string", nullable=false)
     */
    protected $local;

    /**
     * @ORM\Column(name="endereco", type="string", nullable=false, length=15)
     */
    protected $endereco;

    protected $uri;
    protected $modelo;
    protected $tipo;
    protected $serial;
    protected $status_toner;
    protected $status_imagem;
    protected $on_off;
    protected $ultima_troca;
    protected $mensagem;
    protected $kit_manutencao;

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
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $local
     */
    public function setLocal($local)
    {
        $this->local = $local;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * @param mixed $serial
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    }

    /**
     * @return mixed
     */
    public function getStatusToner()
    {
        return $this->status_toner;
    }

    /**
     * @param mixed $status_toner
     */
    public function setStatusToner($status_toner)
    {
        $this->status_toner = $status_toner;
    }

    /**
     * @return mixed
     */
    public function getStatusImagem()
    {
        return $this->status_imagem;
    }

    /**
     * @param mixed $status_imagem
     */
    public function setStatusImagem($status_imagem)
    {
        $this->status_imagem = $status_imagem;
    }

    /**
     * @return mixed
     */
    public function getOnOff()
    {
        return $this->on_off;
    }

    /**
     * @param mixed $on_off
     */
    public function setOnOff($on_off)
    {
        $this->on_off = $on_off;
    }

    /**
     * @return mixed
     */
    public function getUltimaTroca()
    {
        return $this->ultima_troca;
    }

    /**
     * @param mixed $ultima_troca
     */
    public function setUltimaTroca($ultima_troca)
    {
        $this->ultima_troca = $ultima_troca;
    }

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param mixed $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return mixed
     */
    public function getKitManutencao()
    {
        return $this->kit_manutencao;
    }

    /**
     * @param mixed $kit_manutencao
     */
    public function setKitManutencao($kit_manutencao)
    {
        $this->kit_manutencao = $kit_manutencao;
    }



}
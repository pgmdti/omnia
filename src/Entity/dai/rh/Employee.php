<?php

namespace App\Entity\dai\rh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Employee
 * @package App\Entity\dai\rh
 * @ORM\Entity
 * @ORM\Table(name="employee")
 */
class Employee{


    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $matricula;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Classificacao", inversedBy="employees")
     * @ORM\JoinColumn(name="classificacao_id", referencedColumnName="id")
     */
    protected $classificacao;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="employees")
     * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
     */
    protected $cargo;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="nome", type="string", nullable=true)
     */
    protected $nome;
    
    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="endereco", type="string", nullable=true)
     */
    protected $endereco;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="numero", type="string", nullable=true, length=10)
     */
    protected $numero;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="bairro", type="string", nullable=true)
     */
    protected $bairro;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Cidade", inversedBy="employees")
     * @ORM\JoinColumn(name="cidade_id", referencedColumnName="codigo")
     */
    protected $cidade;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="employees")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */
    protected $uf;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="cep", type="string", nullable=true, length=9)
     */
    protected $cep;

    /**
     * @ORM\Column(name="fone", type="string", nullable=true)
     */
    protected $fone;

    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    protected $email;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="mae", type="string", nullable=true)
     */
    protected $mae;

    /**
     * @ORM\Column(name="pai", type="string", nullable=true)
     */
    protected $pai;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Escolaridade", inversedBy="employees")
     * @ORM\JoinColumn(name="escolaridade_id", referencedColumnName="id")
     */
    protected $grauinstrucao;

    /**
     * @ORM\Column(name="especializacoes", type="string", nullable=true)
     */
    protected $especializacoes;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Estadocivil", inversedBy="employees")
     * @ORM\JoinColumn(name="estadocivil_id", referencedColumnName="id")
     */
    protected $estadocivil;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="datanascimento", type="date", nullable=true)
     */
    protected $datanascimento;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Cidade", inversedBy="employeesnatu")
     * @ORM\JoinColumn(name="cidadenatu_id", referencedColumnName="codigo")
     */
    protected $naturalidade;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="employeesnatu")
     * @ORM\JoinColumn(name="estadonatu_id", referencedColumnName="id")
     */
    protected $ufnatu;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="sexo", type="string", nullable=true)
     */
    protected $sexo;

    /**
     * @ORM\Column(name="cnh", type="string", nullable=true, length=20)
     */
    protected $cnh;

    /**
     * @ORM\Column(name="categoria", type="string", nullable=true, length=2)
     */
    protected $categoria;
    
    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="rg", type="string", nullable=true, length=20)
     */
    protected $rg;
    
    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="orgaoemissor", type="string", nullable=true, length=140)
     */
    protected $orgaoemissor;
    
    /**
     * @ORM\Column(name="dataemissao", type="date", nullable=true)
     */
    protected $dataemissao;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="employeesrg")
     * @ORM\JoinColumn(name="estadorg_id", referencedColumnName="id")
     */
    protected $ufrg;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Id
     * @ORM\Column(name="cpf", type="string", nullable=false, length=20)
     */
    protected $cpf;

    /**
     * @ORM\Column(name="pispasep", type="string", nullable=true, length=30)
     */
    protected $pispasep;

    /**
     * @ORM\Column(name="oab", type="string", nullable=true, length=30)
     */
    protected $oab;

    /**
     * @ORM\Column(name="ctps", type="string", nullable=true, length=20)
     */
    protected $ctps;
    
    /**
     * @ORM\Column(name="seriectps", type="string", nullable=true, length=20)
     */
    protected $seriectps;    
    
    /**
     * @ORM\Column(name="cermil", type="string", nullable=true, length=20)
     */
    protected $certmil;    
    
    /**
     * @ORM\Column(name="seriecertmil", type="string", nullable=true, length=20)
     */
    protected $seriecertmil;    
    
    /**
     * @ORM\Column(name="titulo", type="string", nullable=true, length=20)
     */
    protected $titulo;    
    
    /**
     * @ORM\Column(name="secao", type="string", nullable=true, length=5)
     */
    protected $secao;    
    
    /**
     * @ORM\Column(name="zona", type="string", nullable=true, length=5)
     */
    protected $zona;

    /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="employeeseleitor")
     * @ORM\JoinColumn(name="estadoeleitor_id", referencedColumnName="id")
     */
    protected $ufeleitor;    
    
    /**
     * @ORM\Column(name="banco", type="string", nullable=true, length=50)
     */
    protected $banco;    
    
    /**
     * @ORM\Column(name="agencia", type="string", nullable=true, length=10)
     */
    protected $agencia;    
    
    /**
     * @ORM\Column(name="conta", type="string", nullable=true, length=20)
     */
    protected $conta;

    /**
     * @Assert\NotNull(
     *     message = "Selecione uma opção!"
     * )
     * @ORM\ManyToOne(targetEntity="App\Entity\Lotacao", inversedBy="employees")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    protected $departamento;

    /**
     * @ORM\ManyToOne(targetEntity="Orgao", inversedBy="employees")
     * @ORM\JoinColumn(name="orgao_id", referencedColumnName="id")
     */
    protected $orgao;

    /**
     * @ORM\Column(name="cedido", type="boolean", nullable=false)
     */
    protected $cedido;

    /**
     * @Assert\NotBlank(
     *     message = "Campo vazio. Favor, preencher!"
     * )
     * @ORM\Column(name="dataposse", type="date", nullable=true)
     */
    protected $dataposse;

    /**
     * @ORM\Column(name="datatermino", type="date", nullable=true)
     */
    protected $datatermino;

    /**
     *
     * @ORM\OneToMany(targetEntity="Documento", mappedBy="employee", cascade={"persist","remove"})
     *
     */
    protected $files;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Ausencia", mappedBy="employees")
     */
    protected $ausencias;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\dti\EquipamentoLotacao", mappedBy="employee")
     */
    protected $equipamentos;

    /**
     * @ORM\Column(name="duracao", type="integer", nullable=true)
     */
    protected $duracao;

    public function getEventTermino(){
        $now = new \DateTime();
        if($this->datatermino == null) return null;
        return date_diff($now, $this->datatermino)->format('%a');
    }

    /**
     * @return Collection
     */
    public function getEquipamentos(): Collection
    {
        return $this->equipamentos;
    }

    /**
     * @param Collection $equipamentos
     */
    public function setEquipamentos(Collection $equipamentos)
    {
        $this->equipamentos = $equipamentos;
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
    public function getDataposse()
    {
        return $this->dataposse;
    }

    /**
     * @param mixed $dataposse
     */
    public function setDataposse($dataposse)
    {
        $this->dataposse = $dataposse;
    }

    /**
     * @return mixed
     */
    public function getDatatermino()
    {
        return $this->datatermino;
    }

    /**
     * @param mixed $datatermino
     */
    public function setDatatermino($datatermino)
    {
        $this->datatermino = $datatermino;
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
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * @param mixed $fone
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMae()
    {
        return $this->mae;
    }

    /**
     * @param mixed $mae
     */
    public function setMae($mae)
    {
        $this->mae = $mae;
    }

    /**
     * @return mixed
     */
    public function getPai()
    {
        return $this->pai;
    }

    /**
     * @param mixed $pai
     */
    public function setPai($pai)
    {
        $this->pai = $pai;
    }

    /**
     * @return mixed
     */
    public function getGrauinstrucao()
    {
        return $this->grauinstrucao;
    }

    /**
     * @param mixed $grauinstrucao
     */
    public function setGrauinstrucao($grauinstrucao)
    {
        $this->grauinstrucao = $grauinstrucao;
    }

    /**
     * @return mixed
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * @param mixed $estadocivil
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;
    }

    /**
     * @return mixed
     */
    public function getDatanascimento()
    {
        return $this->datanascimento;
    }

    /**
     * @param mixed $datanascimento
     */
    public function setDatanascimento($datanascimento)
    {
        $this->datanascimento = $datanascimento;
    }

    /**
     * @return mixed
     */
    public function getNaturalidade()
    {
        return $this->naturalidade;
    }

    /**
     * @param mixed $naturalidade
     */
    public function setNaturalidade($naturalidade)
    {
        $this->naturalidade = $naturalidade;
    }

    /**
     * @return mixed
     */
    public function getUfnatu()
    {
        return $this->ufnatu;
    }

    /**
     * @param mixed $ufnatu
     */
    public function setUfnatu($ufnatu)
    {
        $this->ufnatu = $ufnatu;
    }


    /**
     * @return mixed
     */
    public function getUfrg()
    {
        return $this->ufrg;
    }

    /**
     * @param mixed $ufrg
     */
    public function setUfrg($ufrg)
    {
        $this->ufrg = $ufrg;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getCnh()
    {
        return $this->cnh;
    }

    /**
     * @param mixed $cnh
     */
    public function setCnh($cnh)
    {
        $this->cnh = $cnh;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @param mixed $rg
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    /**
     * @return mixed
     */
    public function getOrgaoemissor()
    {
        return $this->orgaoemissor;
    }

    /**
     * @param mixed $orgaoemissor
     */
    public function setOrgaoemissor($orgaoemissor)
    {
        $this->orgaoemissor = $orgaoemissor;
    }

    /**
     * @return mixed
     */
    public function getDataemissao()
    {
        return $this->dataemissao;
    }

    /**
     * @param mixed $dataemissao
     */
    public function setDataemissao($dataemissao)
    {
        $this->dataemissao = $dataemissao;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getPispasep()
    {
        return $this->pispasep;
    }

    /**
     * @param mixed $pispasep
     */
    public function setPispasep($pispasep)
    {
        $this->pispasep = $pispasep;
    }

    /**
     * @return mixed
     */
    public function getOab()
    {
        return $this->oab;
    }

    /**
     * @param mixed $oab
     */
    public function setOab($oab)
    {
        $this->oab = $oab;
    }

    /**
     * @return mixed
     */
    public function getCtps()
    {
        return $this->ctps;
    }

    /**
     * @param mixed $ctps
     */
    public function setCtps($ctps)
    {
        $this->ctps = $ctps;
    }

    /**
     * @return mixed
     */
    public function getSeriectps()
    {
        return $this->seriectps;
    }

    /**
     * @param mixed $seriectps
     */
    public function setSeriectps($seriectps)
    {
        $this->seriectps = $seriectps;
    }

    /**
     * @return mixed
     */
    public function getCertmil()
    {
        return $this->certmil;
    }

    /**
     * @param mixed $certmil
     */
    public function setCertmil($certmil)
    {
        $this->certmil = $certmil;
    }

    /**
     * @return mixed
     */
    public function getSeriecertmil()
    {
        return $this->seriecertmil;
    }

    /**
     * @param mixed $seriecertmil
     */
    public function setSeriecertmil($seriecertmil)
    {
        $this->seriecertmil = $seriecertmil;
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
    public function getSecao()
    {
        return $this->secao;
    }

    /**
     * @param mixed $secao
     */
    public function setSecao($secao)
    {
        $this->secao = $secao;
    }

    /**
     * @return mixed
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * @param mixed $zona
     */
    public function setZona($zona)
    {
        $this->zona = $zona;
    }

    /**
     * @return mixed
     */
    public function getUfeleitor()
    {
        return $this->ufeleitor;
    }

    /**
     * @param mixed $ufeleitor
     */
    public function setUfeleitor($ufeleitor)
    {
        $this->ufeleitor = $ufeleitor;
    }

    /**
     * @return mixed
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param mixed $banco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
    }

    /**
     * @return mixed
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param mixed $agencia
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }

    /**
     * @return mixed
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param mixed $conta
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
    }

    /**
     * @return mixed
     */
    public function getEspecializacoes()
    {
        return $this->especializacoes;
    }

    /**
     * @param mixed $especializacoes
     */
    public function setEspecializacoes($especializacoes)
    {
        $this->especializacoes = $especializacoes;
    }


    /**
     * @return mixed
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }


    /**
     * @return mixed
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * @param mixed $classificacao
     */
    public function setClassificacao($classificacao)
    {
        $this->classificacao = $classificacao;
    }

    /**
     * @return mixed
     */
    public function getOrgao()
    {
        return $this->orgao;
    }

    /**
     * @param mixed $orgao
     */
    public function setOrgao($orgao)
    {
        $this->orgao = $orgao;
    }

    /**
     * @return boolean
     */
    public function getCedido()
    {
        return $this->cedido;
    }

    /**
     * @param boolean $cedido
     */
    public function setCedido($cedido)
    {
        $this->cedido = $cedido;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return ArrayCollection
     */
    public function getAusencias(): ArrayCollection
    {
        return $this->ausencias;
    }

    /**
     * @param ArrayCollection $ausencias
     */
    public function setAusencias(ArrayCollection $ausencias)
    {
        $this->ausencias = $ausencias;
    }

    /**
     * @return mixed
     */
    public function getDuracao()
    {
        return $this->duracao;
    }

    /**
     * @param mixed $duracao
     */
    public function setDuracao($duracao)
    {
        $this->duracao = $duracao;
    }

}
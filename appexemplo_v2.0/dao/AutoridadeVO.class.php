<?php
class AutoridadeVO
{
    private $idautoridade = null;
    private $dat_inclusao = null;
    private $dat_evento = null;
    private $ordem = null;
    private $cargo = null;
    private $nome_pessoa = null;
    public function __construct( $idautoridade=null, $dat_inclusao=null, $dat_evento=null, $ordem=null, $cargo=null, $nome_pessoa=null )
    {
        $this->setIdautoridade($idautoridade);
        $this->setDat_inclusao($dat_inclusao);
        $this->setDat_evento($dat_evento);
        $this->setOrdem($ordem);
        $this->setCargo($cargo);
        $this->setNome_pessoa($nome_pessoa);
    }
    //--------------------------------------------------------------------------------
    function setIdautoridade( $strNewValue = null )
    {
        $this->idautoridade = $strNewValue;
    }
    function getIdautoridade()
    {
        return $this->idautoridade;
    }
    //--------------------------------------------------------------------------------
    function setDat_inclusao( $strNewValue = null )
    {
        $this->dat_inclusao = $strNewValue;
    }
    function getDat_inclusao()
    {
        return is_null($this->dat_inclusao) ? date('Y-m-d h:i:s') : $this->dat_inclusao;
    }
    //--------------------------------------------------------------------------------
    function setDat_evento( $strNewValue = null )
    {
        $this->dat_evento = $strNewValue;
    }
    function getDat_evento()
    {
        return is_null($this->dat_evento) ? date('Y-m-d h:i:s') : $this->dat_evento;
    }
    //--------------------------------------------------------------------------------
    function setOrdem( $strNewValue = null )
    {
        $this->ordem = $strNewValue;
    }
    function getOrdem()
    {
        return $this->ordem;
    }
    //--------------------------------------------------------------------------------
    function setCargo( $strNewValue = null )
    {
        $this->cargo = $strNewValue;
    }
    function getCargo()
    {
        return $this->cargo;
    }
    //--------------------------------------------------------------------------------
    function setNome_pessoa( $strNewValue = null )
    {
        $this->nome_pessoa = $strNewValue;
    }
    function getNome_pessoa()
    {
        return $this->nome_pessoa;
    }
    //--------------------------------------------------------------------------------
}
?>

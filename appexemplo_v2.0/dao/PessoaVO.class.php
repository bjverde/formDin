<?php
class PessoaVO
{
    private $idpessoa = null;
    private $nome = null;
    private $tipo = null;
    private $dat_inclusao = null;
    public function __construct( $idpessoa=null, $nome=null, $tipo=null, $dat_inclusao=null )
    {
        $this->setIdpessoa($idpessoa);
        $this->setNome($nome);
        $this->setTipo($tipo);
        $this->setDat_inclusao($dat_inclusao);
    }
    //--------------------------------------------------------------------------------
    function setIdpessoa( $strNewValue = null )
    {
        $this->idpessoa = $strNewValue;
    }
    function getIdpessoa()
    {
        return $this->idpessoa;
    }
    //--------------------------------------------------------------------------------
    function setNome( $strNewValue = null )
    {
        $this->nome = $strNewValue;
    }
    function getNome()
    {
        return $this->nome;
    }
    //--------------------------------------------------------------------------------
    function setTipo( $strNewValue = null )
    {
        $this->tipo = $strNewValue;
    }
    function getTipo()
    {
        return $this->tipo;
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
}
?>

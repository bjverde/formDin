<?php
class Vw_pedido_qtd_itensVO
{
    private $id_pedido = null;
    private $data_pedido = null;
    private $nome_comprador = null;
    private $forma_pagamento = null;
    private $des_forma_pagamento = null;
    private $qtd = null;
    public function __construct($id_pedido = null, $data_pedido = null, $nome_comprador = null, $forma_pagamento = null, $des_forma_pagamento = null, $qtd = null)
    {
        $this->setId_pedido($id_pedido);
        $this->setData_pedido($data_pedido);
        $this->setNome_comprador($nome_comprador);
        $this->setForma_pagamento($forma_pagamento);
        $this->setDes_forma_pagamento($des_forma_pagamento);
        $this->setQtd($qtd);
    }
    //--------------------------------------------------------------------------------
    function setId_pedido($strNewValue = null)
    {
        $this->id_pedido = $strNewValue;
    }
    function getId_pedido()
    {
        return $this->id_pedido;
    }
    //--------------------------------------------------------------------------------
    function setData_pedido($strNewValue = null)
    {
        $this->data_pedido = $strNewValue;
    }
    function getData_pedido()
    {
        return is_null($this->data_pedido) ? date('Y-m-d h:i:s') : $this->data_pedido;
    }
    //--------------------------------------------------------------------------------
    function setNome_comprador($strNewValue = null)
    {
        $this->nome_comprador = $strNewValue;
    }
    function getNome_comprador()
    {
        return $this->nome_comprador;
    }
    //--------------------------------------------------------------------------------
    function setForma_pagamento($strNewValue = null)
    {
        $this->forma_pagamento = $strNewValue;
    }
    function getForma_pagamento()
    {
        return $this->forma_pagamento;
    }
    //--------------------------------------------------------------------------------
    function setDes_forma_pagamento($strNewValue = null)
    {
        $this->des_forma_pagamento = $strNewValue;
    }
    function getDes_forma_pagamento()
    {
        return $this->des_forma_pagamento;
    }
    //--------------------------------------------------------------------------------
    function setQtd($strNewValue = null)
    {
        $this->qtd = $strNewValue;
    }
    function getQtd()
    {
        return $this->qtd;
    }
    //--------------------------------------------------------------------------------
}

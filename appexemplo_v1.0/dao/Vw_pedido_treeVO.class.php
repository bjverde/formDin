<?php
class Vw_pedido_treeVO
{
    private $idparent = null;
    private $id = null;
    private $text = null;
    private $idgrupo = null;
    public function __construct($idparent = null, $id = null, $text = null, $idgrupo = null)
    {
        $this->setIdparent($idparent);
        $this->setId($id);
        $this->setText($text);
        $this->setIdgrupo($idgrupo);
    }
    //--------------------------------------------------------------------------------
    function setIdparent($strNewValue = null)
    {
        $this->idparent = $strNewValue;
    }
    function getIdparent()
    {
        return $this->idparent;
    }
    //--------------------------------------------------------------------------------
    function setId($strNewValue = null)
    {
        $this->id = $strNewValue;
    }
    function getId()
    {
        return $this->id;
    }
    //--------------------------------------------------------------------------------
    function setText($strNewValue = null)
    {
        $this->text = $strNewValue;
    }
    function getText()
    {
        return $this->text;
    }
    //--------------------------------------------------------------------------------
    function setIdgrupo($strNewValue = null)
    {
        $this->idgrupo = $strNewValue;
    }
    function getIdgrupo()
    {
        return $this->idgrupo;
    }
    //--------------------------------------------------------------------------------
}

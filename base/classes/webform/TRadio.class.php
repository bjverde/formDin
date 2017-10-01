<?php
class TRadio extends TOption
{
    /**
    * Classe para criação de campos do tipo RadioButtons, onde apenas uma opção poderá ser selecionada
    *
    * @param string $strName
    * @param array $arrOptions
    * @param array $arrValues
    * @param boolean $boolRequired
    * @param integer $intQtdColumns
    * @param integer $intWidth
    * @param integer $intHeight
    * @param integer $intPaddingItems
    * @example RadioButtons.php
    * @return TEditRadio
    */
    public function __construct($strName,$arrOptions,$arrValues=null,$boolRequired=null,$intQtdColumns=null,$intWidth=null,$intHeight=null,$intPaddingItems=null)
    {
         parent::__construct($strName,$arrOptions,$arrValues,$boolRequired,$intQtdColumns,$intWidth,$intHeight,$intPaddingItems,false,'radio');
    }
    public function show($print=true)
    {
    	// se o controle etiver desativado, gerar um campo oculto com mesmo nome e id para não perder o post e
    	// renomear o input para "id"_disabled
    	if( ! $this->getEnabled() )
    	{
    		$value = $this->getValue();
   			$h = new THidden($this->getId());
   			if( $this->getRequired() )
   			{
   				$h->setProperty('needed','true');
			}
			if( isset($value[0] ) )
   			{
				$h->setValue($value[0]);
   			}
			$this->add($h);
		}
		return parent::show($print);
    }
}
/*
return;
for($i=0;$i<50;$i++)
{
	$arr[$i]= 'Opcao '.$i;
}
$radio = new TEditRadio('tip_bioma',$arr,null,true,10);
//$radio->setEnabled(false);

//$radio->setcss('color','red');
//$radio->setcss('font-size','18');
$radio->show();
*/
?>
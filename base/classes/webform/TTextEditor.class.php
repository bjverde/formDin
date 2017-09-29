<?php
/**
* Classe para implementar campos de entrada de dados de varias linhas (textareas)
*
*/
class TTextEditor extends TMemo
{
	private $showCounter;
	private $onlineSearch;
	private $resizeEnabled;

	public function __construct($strName,$strValue=null,$intMaxLength,$boolRequired=null,$intColumns=null,$intRows=null,$boolShowCounter=null)
	{
		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired,$intColumns,$intRows,$boolShowCounter);
		parent::setFieldType('textEditor');
	}

	/**
	 * @return the $resizeEnabled
	 */
	public function getResizeEnabled() {
		return $this->resizeEnabled;
	}

	/**
	 * @param field_type $resizeEnabled
	 */
	public function setResizeEnabled($boolResizeEnabled) {
		if (is_bool($boolResizeEnabled))
			$this->resizeEnabled = $boolResizeEnabled;
		return $this;
	}

	public function show($print=true) {
		if ($this->getResizeEnabled()) {
//			$script=new TElement('<script>');
//			$script->add('CKEDITOR.config.resize_enabled = false;');
//			$script->show();

			$div = new TElement('div');
			$div->setId($this->getId().'_div');
			$div->add( parent::show(false).$this->getOnlineSearch());
//			$counter = new TElement('span');
//			$counter->setId($this->getId().'_counter');
//			$counter->setCss('border','none');
//			$counter->setCss('font-size','11');
//			$counter->setCss('color','#00000');
//			$div->add('<br>');
//			$div->add($counter);
			$script=new TElement('<script>');
			$script->add('// comentario.');
			$script->add('CKEDITOR.config.resize_enabled = false;');
			$div->add($script);
			return $div->show($print);
		}
		return parent::show($print).$this->getOnlineSearch();
	}

	public function getValue() {
		return str_replace(chr(147), '"', parent::getValue()); //substitui aspas erradas pelas corretas
	}


}
/*
return;
$memo = new TTextEditor('obs_exemplo','Luis',500,false,50,10);
$memo->setValue('<b>Luis Eugênio Barbosa,</b><br><br> estou lhe enviando este e-mail para confirmar se o precos da propsota está de acordo com o que combinamos ontem.');
$memo->show();
*/
?>
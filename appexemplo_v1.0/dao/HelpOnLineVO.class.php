<?php
class HelpOnLineVO {
	private $help_form = null;
	private $help_field = null;
	private $help_title = null;
	private $help_text = null;
	public function __construct( $help_form=null, $help_field=null, $help_title=null, $help_text=null ) {
		$this->setHelp_form( $help_form );
		$this->setHelp_field( $help_field );
		$this->setHelp_title( $help_title );
		$this->setHelp_text( $help_text );
	}
	//--------------------------------------------------------------------------------
	function setHelp_form( $strNewValue = null )
	{
		$this->help_form = $strNewValue;
	}
	function getHelp_form()
	{
		return $this->help_form;
	}
	//--------------------------------------------------------------------------------
	function setHelp_field( $strNewValue = null )
	{
		$this->help_field = $strNewValue;
	}
	function getHelp_field()
	{
		return $this->help_field;
	}
	//--------------------------------------------------------------------------------
	function setHelp_title( $strNewValue = null )
	{
		$this->help_title = $strNewValue;
	}
	function getHelp_title()
	{
		return $this->help_title;
	}
	//--------------------------------------------------------------------------------
	function setHelp_text( $strNewValue = null )
	{
		$this->help_text = $strNewValue;
	}
	function getHelp_text()
	{
		return $this->help_text;
	}
	//--------------------------------------------------------------------------------
}
?>
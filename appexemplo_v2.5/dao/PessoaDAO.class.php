<?php
class PessoaDAO extends TPDOConnection
{

    public static function insert(PessoaVO $objVo)
    {
        if ($objVo->getIdpessoa()) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getNome()
                        , $objVo->getTipo()
                        , $objVo->getDat_inclusao()
                        );
        return self::executeSql('insert into pessoa(
								 nome
								,tipo
								,dat_inclusao
								) values (?,?,?)', $values);
    }
    //--------------------------------------------------------------------------------
    public static function delete($id)
    {
        $values = array($id);
        return self::executeSql('delete from pessoa where idpessoa = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function select($id)
    {
        $values = array($id);
        return self::executeSql('select
								 idpessoa
								,nome
								,tipo
								,dat_inclusao
								from pessoa where idpessoa = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function selectAll($orderBy = null, $where = null)
    {
        return self::executeSql('select
								 idpessoa
								,nome
								,tipo
								,dat_inclusao
								from pessoa'.
        ( ($where)? ' where '.$where:'').
        ( ($orderBy) ? ' order by '.$orderBy:''));
    }
    //--------------------------------------------------------------------------------
    public static function update(PessoaVO $objVo)
    {
        $values = array( $objVo->getNome()
                        ,$objVo->getTipo()
                        ,$objVo->getDat_inclusao()
                        ,$objVo->getIdpessoa() );
        return self::executeSql('update pessoa set 
								 nome = ?
								,tipo = ?
								,dat_inclusao = ?
								where idpessoa = ?', $values);
    }
    //--------------------------------------------------------------------------------
}

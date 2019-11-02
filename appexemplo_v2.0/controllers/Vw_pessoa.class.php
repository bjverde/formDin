<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.9.0-alpha
 * FormDin Version: 4.7.5
 * 
 * System appev2 created in: 2019-09-10 09:04:47
 */
class Vw_pessoa
{


    private $dao = null;

    public function __construct($tpdo = null)
    {
        $this->dao = new Vw_pessoaDAO($tpdo);
    }
    public function getDao()
    {
        return $this->dao;
    }
    public function setDao($dao)
    {
        $this->dao = $dao;
    }
    //--------------------------------------------------------------------------------
    public function selectById( $id )
    {
        $result = $this->dao->selectById( $id );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectCount( $where=null )
    {
        $result = $this->dao->selectCount( $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null)
    {
        $result = $this->dao->selectAllPagination( $orderBy, $where, $page,  $rowsPerPage );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAll( $orderBy=null, $where=null )
    {
        $result = $this->dao->selectAll( $orderBy, $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAllPF( $orderBy=null)
    {
        $where = array();
        $where['TIPO'] = 'PF';
        $result = $this->dao->selectAll( $orderBy, $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAllPJ( $orderBy=null)
    {
        $where = array();
        $where['TIPO'] = 'PJ';
        $result = $this->dao->selectAll( $orderBy, $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectByCpfCnpj( $CpfCnpj )
    {
        $where = array();
        $where['CPFCNPJ'] = $CpfCnpj;
        $result = $this->dao->selectAll( 'NOME', $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function validateUmCpfCnpj( Vw_pessoaVO $objVo )
    {
        $CpfCnpj = $objVo->getCpfcnpj();
        if( empty($CpfCnpj) ){
            $CpfCnpj = $objVo->getCpf();
        }else{
            $CpfCnpj = $objVo->getCnpj();
        }
        if( empty($CpfCnpj) ){
            throw new InvalidArgumentException(Message::ERROR.' '.Message::ERROR_CAMPO_OBRIGATORIO. ': CPF/CNPJ em branco');
        }
        $dados = $this->selectByCpfCnpj($CpfCnpj);
        $CpfCnpjBanco = ArrayHelper::getArrayFormKey($dados,'CPFCNPJ',0);
        if( empty($idpessoa) && !empty($CpfCnpjBanco) ){
            throw new DomainException(Message::ERROR_PESSOA_CPFCNPJ);
        }
    }
    //--------------------------------------------------------------------------------
    public function validateCamposObrigatorios( Vw_pessoaVO $objVo )
    {
        $tipo = $objVo->getTipo();
        if( $tipo == Pessoa::PF ){
            if( empty($objVo->getCpf()) ){
                throw new DomainException(Message::ERROR_CAMPO_OBRIGATORIO.' CPF');
            }
        }else{
            if( empty($objVo->getCnpj()) ){
                throw new DomainException(Message::ERROR_CAMPO_OBRIGATORIO.' CNPJ');
            }
        }
    }
    //--------------------------------------------------------------------------------
    public function validate( Vw_pessoaVO $objVo )
    {
        $this->validateCamposObrigatorios( $objVo );
        $this->validateUmCpfCnpj( $objVo );
    }   
    //--------------------------------------------------------------------------------
    public function save( Vw_pessoaVO $objVo )
    {
        $this->validate($objVo);
        $result = null;
        $tpdo = New TPDOConnectionObj();
        $tpdo->beginTransaction();
        try{                        
            $objVoPessoa = new PessoaVO();
            $objVoPessoa->setIdpessoa( $objVo->getIdpessoa() );
            $objVoPessoa->setNome( $objVo->getNome() );
            $objVoPessoa->setTipo( $objVo->getTipo() );
            $objVoPessoa->setSit_ativo( 'S' );
            $controllerPessoa = new Pessoa($tpdo);
            $result = $controllerPessoa->save($objVoPessoa);

            $objVo->setIdpessoa($result);
            $tipo = $objVo->getTipo();
            if( $tipo == Pessoa::PF ){
                $objVoPessoaPF = new Pessoa_fisicaVO();
                $objVoPessoaPF->setIdpessoa_fisica( $objVo->getIdpessoa_fisica() );
                $objVoPessoaPF->setIdpessoa( $objVo->getIdpessoa() );
                $objVoPessoaPF->setCpf( $objVo->getCpf() );
                $objVoPessoaPF->setDat_nascimento( $objVo->getDat_nascimento() );
                $objVoPessoaPF->setCod_municipio_nascimento( $objVo->getCod_municipio_nascimento() );
                $controllerPessoaPF = new Pessoa_fisica($tpdo);
                $result = $controllerPessoaPF->save($objVoPessoaPF);
            }else{
                $objVoPessoaPJ = new Pessoa_juridicaVO();
                $controllerPessoaPJ = new Pessoa_juridica($tpdo);
                $result = $controllerPessoaPJ->save($objVoPessoaPJ);
            }
            $tpdo->commit();
        }
        catch (DomainException $e) {
            $tpdo->rollBack();
            throw new DomainException($e->getMessage());
        }        
        catch (Exception $e) {
            $tpdo->rollBack();
            MessageHelper::logRecord($e);
            throw new Exception($e->getMessage());
        }
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function delete( $id )
    {
        $tpdo = New TPDOConnectionObj();
        $tpdo->beginTransaction();
        try{
            $controllerPessoaPF = new Pessoa_fisica($tpdo);
            $controllerPessoaPF->delete($id);
            $controllerPessoaPJ = new Pessoa_juridica($tpdo);
            $controllerPessoaPJ->delete($id);
            $controllerPessoa = new Pessoa($tpdo);
            $result = $controllerPessoa->delete($id);
            $tpdo->commit();
        }
        catch (DomainException $e) {
            $tpdo->rollBack();
            throw new DomainException($e->getMessage());
        }        
        catch (Exception $e) {
            $tpdo->rollBack();
            MessageHelper::logRecord($e);
            throw new Exception($e->getMessage());
        }
        return $result;
    }    
    //--------------------------------------------------------------------------------
    public function getVoById( $id )
    {
        $result = $this->dao->getVoById( $id );
        return $result;
    }

}
?>
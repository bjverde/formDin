<?php
class mockFormDinArray
{
    
    /**
     *
     * @var TGrid
     */
    private $tGrid;
    private $dataGrid;
    
    
    public function incluirPessoa($dadosPessoa, $id, $nome, $tipo, $cpf, $cnpj){
        $dadosPessoa['IDPESSOA'][]=$id;
        $dadosPessoa['NMPESSOA'][]=$nome;
        $dadosPessoa['TPPESSOA'][]=$tipo;
        $dadosPessoa['NMCPF'][]=$cpf;
        $dadosPessoa['NMCNPJ'][]=$cnpj;        
        return $dadosPessoa;
    }
    
    public function generateTable(){
        $dadosPessoa = array();
        $dadosPessoa = $this->incluirPessoa($dadosPessoa, 1, 'Joao Silva', 'F', '123456789', null);
        $dadosPessoa = $this->incluirPessoa($dadosPessoa, 2, 'Maria Laranja', 'F', '52798074002', null);
        $dadosPessoa = $this->incluirPessoa($dadosPessoa, 3, 'Dell', 'J', null, '72381189000110');
        $dadosPessoa = $this->incluirPessoa($dadosPessoa, 4, 'Microsoft', 'J', null, '72381189000110');
        
        return $dadosPessoa;
    }
    
    public function incluirPessoaPDO($id, $nome, $tipo, $cpf, $cnpj){
        $dadosPessoa=array();
        $dadosPessoa['IDPESSOA']=$id;
        $dadosPessoa['NMPESSOA']=$nome;
        $dadosPessoa['TPPESSOA']=$tipo;
        $dadosPessoa['NMCPF']=$cpf;
        $dadosPessoa['NMCNPJ']=$cnpj;
        return $dadosPessoa;
    }
    
    public function generateTablePessoaPDO(){
        $dadosPessoa = array();
        $dadosPessoa[] = $this->incluirPessoaPDO(1, 'Joao Silva', 'F', '123456789', null);
        $dadosPessoa[] = $this->incluirPessoaPDO(2, 'Maria Laranja', 'F', '52798074002', null);
        $dadosPessoa[] = $this->incluirPessoaPDO(3, 'Dell', 'J', null, '72381189000110');
        $dadosPessoa[] = $this->incluirPessoaPDO(4, 'Microsoft', 'J', null, '72381189000110');
        
        return $dadosPessoa;
    }
}
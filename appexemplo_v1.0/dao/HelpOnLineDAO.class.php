<?php
class HelpOnLineDAO extends TPDOConnection
{

    private static $sqlBasicSelect = 'select
									  help_form
									 ,help_field
									 ,help_title
									 ,help_text
									 from helpOnLine ';

    private static function processWhereGridParameters($whereGrid)
    {
        $result = $whereGrid;
        if (is_array($whereGrid)) {
            $where = ' 1=1 ';
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'HELP_FORM', ' AND HELP_FORM like \'%'.$whereGrid['HELP_FORM'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'HELP_FIELD', ' AND HELP_FIELD like \'%'.$whereGrid['HELP_FIELD'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'HELP_TITLE', ' AND HELP_TITLE like \'%'.$whereGrid['HELP_TITLE'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'HELP_TEXT', ' AND HELP_TEXT like \'%'.$whereGrid['HELP_TEXT'].'%\' ', null) );
            $result = $where;
        }
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectById($id)
    {
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where help_form = ?';
        $result = self::executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectCount($where = null)
    {
        $where = self::processWhereGridParameters($where);
        $sql = 'select count(help_form) as qtd from helpOnLine';
        $sql = $sql.( ($where)? ' where '.$where:'');
        $result = self::executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public static function selectAll($orderBy = null, $where = null)
    {
        $where = self::processWhereGridParameters($where);
        $sql = self::$sqlBasicSelect
        .( ($where)? ' where '.$where:'')
        .( ($orderBy) ? ' order by '.$orderBy:'');

        $result = self::executeSql($sql);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function insert(HelpOnLineVO $objVo)
    {
        if ($objVo->getHelp_form()) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getHelp_field()
                        , $objVo->getHelp_title()
                        , $objVo->getHelp_text()
                        );
        $sql = 'insert into helpOnLine(
								 help_field
								,help_title
								,help_text
								) values (?,?,?)';
        $result = self::executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function update(HelpOnLineVO $objVo)
    {
        $values = array( $objVo->getHelp_field()
                        ,$objVo->getHelp_title()
                        ,$objVo->getHelp_text()
                        ,$objVo->getHelp_form() );
        return self::executeSql('update helpOnLine set 
								 help_field = ?
								,help_title = ?
								,help_text = ?
								where help_form = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function delete($id)
    {
        $values = array($id);
        return self::executeSql('delete from helpOnLine where helpOnLine = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function createFile()
    {
        if (!FileHelper::exists(DATABASE)) {
            $aFileParts = pathinfo(DATABASE);
            $baseName = $aFileParts[ 'basename' ];
            $fileName = $aFileParts[ 'filename' ];
            $dirName = $aFileParts[ 'dirname' ];
            if ($dirName && ! FileHelper::exists($dirName)) {
                if (! mkdir($dirName, 0775, true)) {
                    die('Não foi possivel criar o diretório '.$dirName);
                }
            }
        }
    }
    //--------------------------------------------------------------------------------
    public static function createTableHelpOnLine()
    {
        
        $qtd = self::selectCount(' 1=1 ');
        
        if ($qtd == 0) {
            $sql = 'CREATE TABLE [helpOnLine] (
					[help_form] VARCHAR(50)  NULL,
					[help_field] VARCHAR(50)  NOT NULL,
					[help_title] VARCHAR(50)  NULL,
					[help_text] TEXT  NULL,
					PRIMARY KEY ([help_form],[help_field])
					)';
            $result = self::executeSql($sql, null);
        }
    }
    //--------------------------------------------------------------------------------
    public static function createFileAndTable()
    {
        self::createFile();
        self::createTableHelpOnLine();
    }
}

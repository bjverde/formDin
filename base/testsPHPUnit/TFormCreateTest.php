<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */
require_once '../classes/constants.php';
require_once '../classes/webform/TFormCreate.class.php';


/**
 * TFormCreate test case.
 */
class TFormCreateTest extends PHPUnit_Framework_TestCase {

    /**
     *
     * @var TFormCreate
     */
    private $tFormCreate;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(){
        parent::setUp();        
        $this->tFormCreate = new TFormCreate();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(){
        // TODO Auto-generated TFormCreateTest::tearDown()
        $this->tFormCreate = null;        
        parent::tearDown();
    }

    /**
     * Tests TFormCreate->setFormTitle()
     */
    public function testSetFormTitle_null(){
        $expected = 'titulo';
        //$this->tFormCreate->setFormTitle(null);
        $result = $this->tFormCreate->getFormTitle();        
        $this->assertEquals( $expected, $result);
    }

    /**
     * Tests TFormCreate->setFormTitle()
     */
    public function testSetFormTitle_setValue(){
        $expected = 'KTg';
        $this->tFormCreate->setFormTitle($expected);
        $result = $this->tFormCreate->getFormTitle();
        $this->assertEquals( $expected, $result);
    }
    
    /**
     * Tests TFormCreate->setFormPath()
     */
    public function testSetFormPath()
    {
        // TODO Auto-generated TFormCreateTest->testSetFormPath()
        $this->markTestIncomplete("setFormPath test not implemented");
        
        $this->tFormCreate->setFormPath(/* parameters */);
    }

    /**
     * Tests TFormCreate->setFormFileName()
     */
    public function testSetFormFileName()
    {
        // TODO Auto-generated TFormCreateTest->testSetFormFileName()
        $this->markTestIncomplete("setFormFileName test not implemented");
        
        $this->tFormCreate->setFormFileName(/* parameters */);
    }

    /**
     * Tests TFormCreate->setPrimaryKeyTable()
     */
    public function testSetPrimaryKeyTable()
    {
        // TODO Auto-generated TFormCreateTest->testSetPrimaryKeyTable()
        $this->markTestIncomplete("setPrimaryKeyTable test not implemented");
        
        $this->tFormCreate->setPrimaryKeyTable(/* parameters */);
    }

    /**
     * Tests TFormCreate->setTableRef()
     */
    public function testSetTableRef()
    {
        // TODO Auto-generated TFormCreateTest->testSetTableRef()
        $this->markTestIncomplete("setTableRef test not implemented");
        
        $this->tFormCreate->setTableRef(/* parameters */);
    }

    /**
     * Tests TFormCreate->setListColunnsName()
     */
    public function testSetListColunnsName()
    {
        // TODO Auto-generated TFormCreateTest->testSetListColunnsName()
        $this->markTestIncomplete("setListColunnsName test not implemented");
        
        $this->tFormCreate->setListColunnsName(/* parameters */);
    }

    /**
     * Tests TFormCreate->setGridType()
     */
    public function testSetGridType()
    {
        // TODO Auto-generated TFormCreateTest->testSetGridType()
        $this->markTestIncomplete("setGridType test not implemented");
        
        $this->tFormCreate->setGridType(/* parameters */);
    }

    /**
     * Tests TFormCreate->addGridPagination_jsScript()
     */
    public function testAddGridPagination_jsScript()
    {
        // TODO Auto-generated TFormCreateTest->testAddGridPagination_jsScript()
        $this->markTestIncomplete("addGridPagination_jsScript test not implemented");
        
        $this->tFormCreate->addGridPagination_jsScript(/* parameters */);
    }

    /**
     * Tests TFormCreate->addGrid()
     */
    public function testAddGrid()
    {
        // TODO Auto-generated TFormCreateTest->testAddGrid()
        $this->markTestIncomplete("addGrid test not implemented");
        
        $this->tFormCreate->addGrid(/* parameters */);
    }

    /**
     * Tests TFormCreate->showForm()
     */
    public function testShowForm()
    {
        // TODO Auto-generated TFormCreateTest->testShowForm()
        $this->markTestIncomplete("showForm test not implemented");
        
        $this->tFormCreate->showForm(/* parameters */);
    }

    /**
     * Tests TFormCreate->saveForm()
     */
    public function testSaveForm()
    {
        // TODO Auto-generated TFormCreateTest->testSaveForm()
        $this->markTestIncomplete("saveForm test not implemented");
        
        $this->tFormCreate->saveForm(/* parameters */);
    }
}


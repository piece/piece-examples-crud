<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP versions 4 and 5
 *
 * Copyright (c) Piece Project, All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Piece_Examples_CRUD
 * @copyright  2007 Piece Project
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    SVN: $Id$
 * @since      File available since Release 1.0.0
 */

require_once 'Piece/Unity/Service/FlowAction.php';
require_once 'Piece/Unity/Service/FlexyElement.php';
require_once 'Piece/ORM.php';
require_once 'Piece/ORM/Error.php';

// {{{ Entry_EditAction

/**
 * Action class for the flow Registration.
 *
 * @package    Piece_Examples_CRUD
 * @copyright  2007 Piece Project
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 1.0.0
 */
class Entry_EditAction extends Piece_Unity_Service_FlowAction
{

    // {{{ properties

    /**#@+
     * @access public
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    var $_entry;

    /**#@-*/

    /**#@+
     * @access public
     */

    function doActivityOnDisplayShow()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());

        $viewElement = &$this->_context->getViewElement();
        $viewElement->setElementByRef('entry', $this->_entry);
    }

    function doActivityOnDisplayEdit()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());
        $flexyElement->restoreValues('Entry_New', $this->_entry);
    }

    function doActivityOnProcessValidateEdit()
    {
        $validation = &$this->_context->getValidation();
        if ($validation->validate('Entry_New', $this->_entry)) {
            return 'DisplayEditConfirmFromProcessValidateEdit';
        } else {
            return 'DisplayEditFromProcessValidateEdit';
        }
    }

    function doActivityOnDisplayEditConfirm()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());

        $viewElement = &$this->_context->getViewElement();
        $viewElement->setElementByRef('entry', $this->_entry);
    }

    function doActivityOnDisplayDeleteConfirmViaDisplayShow()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());

        $viewElement = &$this->_context->getViewElement();
        $viewElement->setElementByRef('entry', $this->_entry);
    }

    function doActivityOnDisplayDeleteConfirmViaDisplayEdit()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());

        $viewElement = &$this->_context->getViewElement();
        $viewElement->setElementByRef('entry', $this->_entry);
    }

    function doActivityOnProcessFind()
    {
        $mapper = &Piece_ORM::getMapper('Entry');
        if (Piece_ORM_Error::hasErrors('exception')) {
            return;
        }

        $entry = &$mapper->findById($this->_entry);
        if (!is_null($entry)) {
            $this->_entry = &$entry;
            return 'DisplayShowFromProcessFind';
        } else {
            return 'DisplayErrorFromProcessFind';
        }
    }

    function doActivityOnProcessUpdate()
    {
        $mapper = &Piece_ORM::getMapper('Entry');
        if (Piece_ORM_Error::hasErrors('exception')) {
            return;
        }

        $affectedRows = $mapper->update($this->_entry);
        if ($affectedRows) {
            return 'ProcessFindFromProcessUpdate';
        } else {
            return 'DisplayErrorFromProcessUpdate';
        }
    }

    function doActivityOnProcessValidateID()
    {
        $validation = &$this->_context->getValidation();
        if ($validation->validate('Entry_ID', $this->_entry)) {
            return 'ProcessFindFromProcessValidateID';
        } else {
            return 'DisplayErrorFromProcessValidateID';
        }
    }

    function doActivityOnProcessDelete()
    {
        $mapper = &Piece_ORM::getMapper('Entry');
        if (Piece_ORM_Error::hasErrors('exception')) {
            return;
        }

        $affectedRows = $mapper->delete($this->_entry);
        if ($affectedRows) {
            return 'DisplayDeleteFinishFromProcessDelete';
        } else {
            return 'DisplayErrorFromProcessDelete';
        }
    }

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    // }}}
}

// }}}

function displayTextArea($value)
{
    return strip_tags(nl2br($value), '<br>');
}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
?>

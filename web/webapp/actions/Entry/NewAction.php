<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP versions 4 and 5
 *
 * Copyright (c) 2007 KUBO Atsuhiro <iteman@users.sourceforge.net>,
 * All rights reserved.
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
 * @copyright  2007 KUBO Atsuhiro <iteman@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    SVN: $Id$
 * @since      File available since Release 1.0.0
 */

require_once 'Piece/Unity/Service/FlowAction.php';
require_once 'Piece/Unity/Service/FlexyElement.php';
require_once 'Piece/ORM.php';
require_once 'Piece/ORM/Error.php';

// {{{ Entry_NewAction

/**
 * Action class for the flow Registration.
 *
 * @package    Piece_Examples_CRUD
 * @copyright  2007 KUBO Atsuhiro <iteman@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 1.0.0
 */
class Entry_NewAction extends Piece_Unity_Service_FlowAction
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

    function Entry_NewAction()
    {
        $this->_entry = &Piece_ORM::createObject('Entry');
    }

    function doActivityOnDisplayNew()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());
        $flexyElement->restoreValues('Entry_New', $this->_entry);
    }

    function doActivityOnProcessValidateNew()
    {
        $validation = &$this->_context->getValidation();
        if ($validation->validate('Entry_New', $this->_entry)) {
            return 'DisplayNewConfirmFromProcessValidateNew';
        } else {
            return 'DisplayNewFromProcessValidateNew';
        }
    }

    function doActivityOnDisplayNewConfirm()
    {
        $flexyElement = &new Piece_Unity_Service_FlexyElement();
        $flexyElement->addForm($this->_flow->getView(), $this->_context->getScriptName());

        $viewElement = &$this->_context->getViewElement();
        $viewElement->setElementByRef('entry', $this->_entry);
    }

    function doActivityOnProcessCreateNew()
    {
        $mapper = &Piece_ORM::getMapper('Entry');
        if (Piece_ORM_Error::hasErrors('exception')) {
            return;
        }

        $mapper->insert($this->_entry);

        return 'DisplayNewFinishFromProcessCreateNew';
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

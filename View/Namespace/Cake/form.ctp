<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('echo $this->%s->create(%s, %s); $formEnd = %s;', $this->_helpers['Form'], $this->_processAttribute($attributes, 'model'), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'submit'));
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('echo $this->%s->end((!empty($formEnd))? $formEnd : null);', $this->_helpers['Form']);
}


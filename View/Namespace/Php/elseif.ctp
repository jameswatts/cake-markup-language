<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('elseif (%s):', str_replace(array('isset(', 'empty('), array('$this->_isset(', '$this->_empty('), $this->resolve($attrs, 'expr', array('default' => 'true', 'format' => '%s', 'parse' => true))));
}


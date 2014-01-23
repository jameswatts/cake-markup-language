<?php
switch ($state) {
	case self::TAG_OPEN:
		echo 'case ' . str_replace(array('isset(', 'empty('), array('$this->_isset(', '$this->_empty('), $this->resolve($attrs, 'expr', array('default' => 'null', 'format' => '%s'))) . ': ?>';
		break;
	case self::TAG_CLOSE:
		echo '<?php ';
}


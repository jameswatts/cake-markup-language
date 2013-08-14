<?php
switch ($state) {
	case self::TAG_OPEN:
		echo '<?php $var = $this->_processVariable(' . $this->_processAttribute($attributes, 'var', array('format' => "'%s'")) . '); switch ($var):';
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('endswitch;');
}


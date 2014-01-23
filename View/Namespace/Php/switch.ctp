<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('$var = $this->variable(' . $this->resolve($attrs, 'var', array('format' => "'%s'")) . '); switch ($var):');
		break;
	case self::TAG_CLOSE:
		echo $this->compile('endswitch;');
}


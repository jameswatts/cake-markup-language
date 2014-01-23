<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('$this->start%s(%s);', ($this->resolve($attrs, 'empty', array('default' => true, 'format' => null)))? '' : 'IfEmpty', $this->resolve($attrs, 'name'));
		break;
	case self::TAG_CLOSE:
		echo $this->compile('$this->end();');
}


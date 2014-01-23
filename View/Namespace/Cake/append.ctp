<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('$this->append(%s);', $this->resolve($attrs, 'name'));
		break;
	case self::TAG_SELF:
		echo $this->compile('ob_start();') . $this->resolve($attrs, 'value', array('format' => null)) . $this->compile('$value = ob_get_clean(); $this->append(%s, $value);', $this->resolve($attrs, 'name'));
		break;
	case self::TAG_CLOSE:
		echo $this->compile('$this->end();');
}


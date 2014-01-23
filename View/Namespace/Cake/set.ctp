<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$this->set(%s, %s);', $this->resolve($attrs, 'name'), $this->resolve($attrs, 'value', array('default' => '')));
}


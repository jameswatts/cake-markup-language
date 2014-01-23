<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$this->log(%s, %s);', $this->resolve($attrs, 'message'), $this->resolve($attrs, 'type', array('default' => 'debug')));
}


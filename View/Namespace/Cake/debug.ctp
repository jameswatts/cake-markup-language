<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('debug($this->value(%s));', $this->resolve($attrs, 'var'));
}


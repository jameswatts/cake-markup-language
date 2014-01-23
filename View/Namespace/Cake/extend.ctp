<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$this->extend(%s);', $this->resolve($attrs, 'view', array('default' => '')));
}


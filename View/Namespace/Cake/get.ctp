<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('echo $this->getVar(%s);', $this->resolve($attrs, 'name'));
}


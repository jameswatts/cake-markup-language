<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('echo htmlentities(%s);', $this->resolve($attrs, 'expr', array('default' => 'true', 'format' => '%s', 'parse' => true)));
}


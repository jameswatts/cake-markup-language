<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('ob_start();') . $this->resolve($attrs, 'value', array('format' => null)) . $this->compile('$value = ob_get_clean(); $this->assign(%s, $value);', $this->resolve($attrs, 'name'));
}


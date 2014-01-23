<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		$set = $this->resolve($attrs, 'set', array('format' => null));
		echo $this->compile('ob_start();') . $this->resolve($attrs, 'default', array('format' => null)) . $this->compile('$default = ob_get_clean(); %s $this->fetch(%s, $default);', ($set)? '$this->viewVars["' . $set . '"] = ' : 'echo', $this->resolve($attrs, 'name'));
}


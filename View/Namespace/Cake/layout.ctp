<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$this->viewVars[\'Cake\'][\'layout\'] = $this->layout = %s;', $this->resolve($attrs, 'name'));
}


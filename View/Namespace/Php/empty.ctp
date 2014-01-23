<?php
switch ($state) {
	case self::TAG_OPEN:
		$var = uniqid();
		if ($this->resolve($attrs, 'not', array('type' => self::TYPE_BOOLEAN)) === 'false') {
			echo $this->compile('$_%s = $this->value(%s, true); if (empty($_%s)):', $var, $this->resolve($attrs, 'var'), $var);
		} else {
			echo $this->compile('$_%s = $this->value(%s, true); if (!empty($_%s)):', $var, $this->resolve($attrs, 'var'), $var);
		}
		break;
	case self::TAG_CLOSE:
		echo $this->compile('endif;');
}


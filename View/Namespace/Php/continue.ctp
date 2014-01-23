<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		$nested = $this->resolve($attrs, 'nested'); echo $this->compile('continue%s;', ($nested)? ' ' . $nested : '');
}


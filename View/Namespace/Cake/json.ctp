<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$out = json_encode($this->value(%s)); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->resolve($attrs, 'var'), $this->resolve($attrs, 'set'));
}


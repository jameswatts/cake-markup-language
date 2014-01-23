<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		if ($this->resolve($attrs, 'defer', array('default' => 'true', 'type' => self::TYPE_BOOLEAN)) === 'true') {
			echo $this->compile('$out = call_user_func_array(array($this, \'element\'), array(%s, (array) %s, (array) %s)); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->resolve($attrs, 'name'), $this->resolve($attrs, 'vars', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'set'));
		} else {
			eval(sprintf(' ?> <?php $out = $this->element(%s, (array) %s, (array) %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; } ?> <?php ', $this->resolve($attrs, 'name'), $this->resolve($attrs, 'vars', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'set')));
		}
}


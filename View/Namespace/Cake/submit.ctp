<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$out = $this->%s->submit(%s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'caption'), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'set'));
}


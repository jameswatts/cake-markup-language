<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$out = $this->%s->url(%s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Html'], $this->resolve($attrs, 'url'), $this->resolve($attrs, 'full', array('type' => self::TYPE_BOOLEAN)), $this->resolve($attrs, 'set'));
}


<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$out = $this->%s->cache(%s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Cache'], $this->resolve($attrs, 'file'), $this->resolve($attrs, 'out'), $this->resolve($attrs, 'set'));
}


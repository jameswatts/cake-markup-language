<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('$out = $this->%s->link("", %s, %s, %s); echo substr($out, 0, -4);', $this->{$ns}->settings['classes']['Html'], $this->resolve($attrs, 'url'), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'confirm'));
		break;
	case self::TAG_SELF:
		$value = $this->resolve($attrs, 'value');
		$url = $this->resolve($attrs, 'url');
		if ($value === '""') {
			$value = $url;
		}
		echo $this->compile('$out = $this->%s->link(%s, %s, %s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Html'], $value, $url, $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'confirm'), $this->resolve($attrs, 'set'));
		break;
	case self::TAG_CLOSE:
		echo '</a>';
}


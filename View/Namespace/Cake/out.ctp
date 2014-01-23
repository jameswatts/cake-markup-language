<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		$value = $this->resolve($attrs, 'value', array('format' => null));
		if (is_null($value)) {
			$value = (isset($attrs['default']))? $this->resolve($attrs, 'default', array('format' => null)) : '';
		}
		$safe = $this->resolve($attrs, 'safe', array('default' => 'true', 'type' => self::TYPE_BOOLEAN));
		echo $this->compile('ob_start();');
		echo $value;
		echo $this->compile('$out = ob_get_clean();');
		if ($this->resolve($attrs, 'nl2br', array('type' => self::TYPE_BOOLEAN)) === 'true') {
			echo $this->compile(($safe === 'true')? 'echo nl2br(h(html_entity_decode($out)));' : 'echo nl2br($out);');
		} else {
			echo $this->compile(($safe === 'true')? 'echo h(html_entity_decode($out));' : 'echo $out;');
		}
}


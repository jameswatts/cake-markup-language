<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$options = %s; ob_start(); $return = $this->requestAction(%s, $options); $output = ob_get_clean(); $set = %s; if (!empty($set)) { $this->set($set, (in_array(\'return\', $options))? $return : $output); } else { echo $output; }', $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'url', array('default' => '/')), $this->resolve($attrs, 'set'));
}


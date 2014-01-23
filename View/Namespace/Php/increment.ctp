<?php
if ($state === self::TAG_OPEN || $state === self::TAG_SELF) {
	echo $this->compile('$this->viewVars[%s]++;', $this->resolve($attrs, 'var'));
}


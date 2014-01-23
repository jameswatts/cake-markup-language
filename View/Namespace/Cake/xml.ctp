<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('App::uses("Xml", "Utility"); $out = Xml::build($this->get(%s), array("return" => "simplexml"))->asXML(); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->resolve($attrs, 'var'), $this->resolve($attrs, 'set'));
}


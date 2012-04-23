<?php

namespace MARSFW;

require '../start.inc.php';

function fetch($loc) {
	$hash = 'data-' . sha1($loc);
	if (file_exists($hash)) {
		return file_get_contents($hash);
	}

	$f = file_get_contents($loc);
	$fh = fopen($hash, 'w');
	fwrite($fh, $f);
	fclose($fh);
	return $f;
}

$dom = fetch_tidy_dom(fetch('http://www.php.net/manual/en/function.image2wbmp.php'), 'UTF-8');

header('Content-Type: text/plain; charset=UTF-8');

$str = 'image2wbmp';

function searchNode(\DomNode $node, $text, $prefix = '') {
	$out = array();

	if ($node->hasAttributes()) {
		$attrs = $node->attributes;
		for ($x = 0; $x < $attrs->length; $x++) {
			$item = $attrs->item($x);
			
			if ($text == $item->textContent) {
				$out ["{$prefix}[{$item->nodeName}]"] = $item;
			}
		}
	}
	if ($node->hasChildNodes()) {
		$nodes = array();
		foreach ($node->childNodes as $child) {
			if (!($child instanceof \DOMElement)) {
				continue;
			}

			if (!isset($nodes[$child->nodeName])) {
				$nodes[$child->nodeName] = 0;
			} else {
				$nodes[$child->nodeName]++;
			}
			$pref = "{$prefix}/{$child->nodeName}|{$nodes[$child->nodeName]}";

			if ($text == trim($child->textContent)) {
				$out [$pref] = $child;
			} else {
				$out += searchNode($child, $text, $pref);
			}
		}
	}
	return $out;
}

function getNodeFromPath(\DOMDocument $d, $path) {
	preg_match_all('#/(.*?)\\|([0-9]+)(\[(.*?)\])?#', $path, $matches);
	unset($matches[0], $matches[3]);
	$path = explode('/', $path);
	foreach ($matches[1] as $id => $tagname) {
		$idx = (int) $matches[2][$id];
		$count = 0;
		foreach ($d->childNodes as $child) {
			if (!($child instanceof \DOMElement))
				continue;
			if ($child->nodeName != $tagname)
				continue;
			if ($count == $idx) {
				$d = $child;
				break;
			}
			$count++;
		}
	}
	return $d;
}

$out = searchNode($dom, '$threshold');

$node = getNodeFromPath($dom, "/html|0/body|0/div|2/div|0/ul|0");
$nodes = array();
foreach ($node->childNodes as $cn) {
	try {
		$attr = $cn->firstChild->attributes;
		flush();

		$link = $attr->getNamedItem('href')->textContent;
		$type = explode('.', $link);
		$type = $type[0];
		if ($type != 'function')
			continue;

		$cdom = fetch_tidy_dom(fetch('http://www.php.net/manual/en/' . $attr->getNamedItem('href')->textContent), 'UTF-8');

		$cnode = getNodeFromPath($cdom, "/html|0/body|0/div|2/div|1/div|1/div|1/div|0");

		foreach ($cnode->childNodes as $ccnode) {
			if (0)
				$attrs = new \DOMNamedNodeMap;
			$attrs = $ccnode->attributes;
			$nattrs = array();
			if ($attrs)
				for ($x = 0; $x < $attrs->length; $x++) {
					$item = $attrs->item($x);
					$nattrs[$item->nodeName] = $item->textContent;
				}

			$nodes[$link][$ccnode->nodeName][@$nattrs['class']][] = preg_replace('#\s+#', ' ', $ccnode->textContent);
		}
		$nodes[$link]['#textcontent'] = $cnode->textContent;
	} catch (\Exception $ex) {
		//var_dump ($ex);
	}
}


$names = array(
	'true', 'color', 'dashed', 'line', 'filled', 'fill', 'arc', 'ellipse', 'polygon',
	'rectangle', 'border', 'to', 'height', 'width', 'text', 'correct', 'screen', 'window',
	'effect', 'copy', 'font', 'encode', 'load', 'slant', 'rotate', 'free',
	'extend', 'bbox', 'brush', 'style', 'thickness', 'tile', 'embed', 'parse', 'resolve',
	'resized', 'create', 'from', 'gd', 'part', 'set', 'for', 'index', 'total',
	'transparent', 'merge', 'gray', 'resampled', 'get', 'image', 'size', 'blending', 'up',
	'deallocate', 'allocate', 'alpha', 'match', 'at', 'closest', 'hwb', 'exact',
	'gif', 'jpeg', 'png', 'xbm', 'wbmp', 'xpm',
);
$properties = array(
	'resource $image' => 'handler',
	'resource $image1' => 'handler',
	'resource $dst_im' => 'handler',
	'resource $dst_image' => 'handler'
);
$replace = array(
	'resource $image2' => array(
		'in' => 'GDImage $image',
		'out' => '$image->handler',
	),
	'resource $src_im' => array(
		'in' => 'GDImage $source',
		'out' => '$source->handler',
	),
	'resource $src_image' => array(
		'in' => 'GDImage $source',
		'out' => '$source->handler',
	),
	'resource $brush' => array(
		'in' => 'GDImage $brush',
		'out' => '$source->handler',
	),
	'int $color' => array(
		'in' => 'Color $c',
		'out' => '$c->toGDInt()',
	),
);
$resourceObj = 'GDImage';

$dict = array();
foreach ($names as $name) {
	$dict[$name] = ucfirst($name);
}

$prefix = 'image';
$staticMethods = '';
$methods = '';
foreach ($nodes as $func) {
	$funcname = $func['span']['methodname'][0];
	$optional = $func['#textcontent'];
	$optional = preg_replace('#[\s+]#', ' ', $optional);
	$optional = explode('[', $optional);
	foreach ($optional as &$part) {
		$part = trim($part, ' []();,');
	}
	unset($optional[0],$part);

	$methodname = $funcname;
	$methodname = preg_replace('#([^g]?[^d0-9])2([a-z])#', '\\1_to_\\2', $methodname);
	$methodname = explode('_', $methodname);

	if ($methodname[0] == $prefix) {
		unset($methodname[0]);
		$methodname = array_values($methodname);
	}
	for ($x = 1; isset($methodname[$x]); $x++) {
		$methodname[$x] = ucfirst($methodname[$x]);
	}
	$methodname = implode('', $methodname);
	if (strpos($methodname, $prefix) === 0) {
		$methodname = substr($methodname, strlen($prefix));
	}
	$returnObj = @$func['span']['type'][0] == 'resource';
	$returnType = @$func['span']['type'][0];
	$params = '';
	$fparams = '';
	$start = false;
	$fstart = false;
	$static = true;
	foreach ($func['span']['methodparam'] as $param) {
		if ($param == 'void')
			continue;
		$oparam = $param;

		if (isset($properties[$param])) {
			$param = '$this->' . $properties[$param];
			$static = false;
		} else {
			$paramp = explode(' ', $param, 3);

			if (empty($paramp[2]) and in_array($oparam, $optional)) {
				$paramp[2] = '= NULL';
			}
			//var_dump ([$oparam,$paramp,$optional]);
			
			if ($paramp[0] != 'array' and !class_exists('\\' . $paramp[0])) {
				$param = $paramp[1];
			}

			if ($start) {
				$params .= ',';
			} else {
				$start = true;
			}

			if (isset($replace[$oparam])) {
				$params .= $replace[$oparam]['in'] . @$paramp[2];
			} else {
				$params .= $param . @$paramp[2];
			}

			$param = $paramp[1];
		}

		if ($fstart) {
			$fparams.= ',';
		} else {
			$fstart = true;
		}

		if (isset($replace[$oparam])) {
			$fparams .= $replace[$oparam]['out'];
		} else {
			$fparams .= $param;
		}
	}

	$methodname = strtr($methodname, $dict);
	$methodname[0] = strtolower($methodname[0]);

	$return = "\\$funcname({$fparams})";
	if ($returnObj)
		$return = "new $resourceObj($return)";
	if ($returnType != 'void')
		$return = "return $return";

	$func = "\n" . ($static ? 'static ' : '') . "function $methodname ($params){\n" .
			"\t$return;\n" .
			"}";

	if ($static)
		$staticMethods .= $func;
	else
		$methods .= $func;
}
echo '<?php
	
namespace MARSFW;

class GDImage extends WrapperObject{
',
 $staticMethods, $methods, '
	 }';

die;


$node = getNodeFromPath($dom, "/html|0/body|0/div|2/div|1/div|1/div|1/div|0");

$nodes = array();
foreach ($node->childNodes as $cnode) {
	if (0)
		$attrs = new \DOMNamedNodeMap;
	$attrs = $cnode->attributes;
	$nattrs = array();
	if ($attrs)
		for ($x = 0; $x < $attrs->length; $x++) {
			$item = $attrs->item($x);
			$nattrs[$item->nodeName] = $item->textContent;
		}

	$nodes[$cnode->nodeName][@$nattrs['class']][] = preg_replace('#\s+#', ' ', $cnode->textContent);
}

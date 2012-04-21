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
			//var_dump ($item->textContent);
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

$out = searchNode($dom, 'imagearc');
var_dump(searchNode($dom, 'imagearc'), searchNode($dom, 'toc'));
//var_dump ($dom->getElementsByTagName('html')->item(0)->textContent);
$str = '';
for ($x = 0; $x < 0x20; $x++){
	$str .=chr($x);
	var_dump (addcslashes(chr($x), "\0..\377"));
}

trigger_error($str);
$_SESSION['a'] = new \stdClass;
a;

$node = getNodeFromPath($dom, "/html|0/body|0/div|2/div|0/ul|0");
foreach ($node->childNodes as $cn) {
	var_dump(array($cn->nodeName, $cn->textContent, $cn->hasAttributes() ? $cn->attributes->getNamedItem('href')->textContent : null));
}


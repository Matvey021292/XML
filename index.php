<!-- <?php

	$parser = xml_parser_create('utf-8');
	function startElement($parser,$tag,$attr){

		if ($tag =="CONTENT" || $tag == "BOOKS") {
			echo "<li>$tag:";
			echo "<ul>";
		}else{
			echo "<li>$tag";
		}
		
		
	}
	function onEnd($parser,$tag){
		if ($tag =="CONTENT" || $tag == "BOOKS"){
			echo "</li></ul>";
		
		}else{
			echo "</li>";
		}
	}
	function onText($parser,$text){
		echo "$text";
	}
	$parserHandler = xml_set_element_handler($parser,'startElement','onEnd' );
	// var_dump($parserHandler);
	xml_set_character_data_handler($parser,'onText');

	$file = file_get_contents('new.xml');
	echo "<ul>";
	xml_parse($parser, $file);
	echo "</ul>";

?> -->

<?php
	$dom = new DOMDocument();
	$dom->load('new.xml');
	// echo "<pre>";
	// var_dump($dom->documentElement);
	// echo "</pre>";
	$subtitle = $dom->createElement('subtitle');
	$text = $dom->createTextNode('i\'m subtitle');
	$subtitle->appendChild($text);
	$books = $dom->getElementsByTagName('books');
	foreach ($books as $book) {
		$book->appendChild($subtitle);
	}
	$dom->save('new.xml');
?>


Osman.ramazanov (20:23):
<?php

$parser = xml_parser_create('utf-8');

function startElement($parser, $tag, $attr)
{
    if($tag=='CATALOG' || $tag=='BOOK') {
        echo "<li>$tag";
        echo "<ul>";
    } else {
        if(isset($attr['CURRENCY'])){
            echo "<li>$tag: {$attr['CURRENCY']}";
        } else {
            echo "<li>$tag:";
        }

    }

}

function onEnd($parser, $tag)
{
    if($tag=='CATALOG' || $tag=='BOOK') {
        echo "</li></ul>";
    } else {
        echo '</li>';
    }
}

function onText($parser, $text)
{
    echo $text;
}

$parserHandler = xml_set_element_handler($parser, 'startElement', 'onEnd');

xml_set_character_data_handler($parser, 'onText');

$file = file_get_contents('new.xml');
echo '<ul>';
xml_parse($parser, $file);
echo '</ul>';
Osman.ramazanov (20:44):
<?php
$dom = new DOMDocument();

$dom->load('new.xml');
$subtitle = $dom->createElement('subtitle');
$text = $dom->createTextNode("I'm subtitle");
$subtitle->appendChild($text);

$books = $dom->getElementsByTagName('book');

for($i = 0; $i < $books->length; $i++){
    $new = $subtitle->cloneNode(true);
    $books->item($i)->appendChild($new);
}

$dom->save('new.xml');

$xml = simplexml_load_file('new.xml');
$xml->book[0]->title = "Little Marmade. vol2";
$xml->saveXML('new.xml');
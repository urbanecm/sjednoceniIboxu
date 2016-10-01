<?php

// $txt = '{{Infobox - hudební žánr
// |name=Garage house
// |bgcolor=#FA8072
// |color=white
// |stylistic_origins= [[Elektronická taneční hudba]], [[disco]], [[gospel]], [[soul (hudba)|soul]]

// |cultural_origins=Brzké osmdesáté léta; [[New York|New York City]] a [[New Jersey]], [[Spojené státy americké|U.S.]]

// |instruments= [[klávesy]] - [[vokály]] - [[syntezátor|syntetizér]] - [[Bicí souprava|bicí]]
// |popularity=
// |derivatives=[[UK Garage]]
// |subgenrelist=Subgenres
// |fusiongenres=
// |regional_scenes=
// |other_topics=}}';

// $regexp = '/([\s]*\|[\s]*)(cultural_origins)([\s]*=[ \t]*)/i';
// $new_content  = preg_replace($regexp, "\n | AAA = ", $txt, 1, $count);
// var_dump($new_content);

set_time_limit(0);
//ini_set("display_errors", 1);
//error_reporting(E_ALL ^ E_NOTICE);
require_once('botclasses.php');
require_once('login_data.php');

function pre($txt){
  return '<pre style="border:1px dotted silver;margin-bottom:1em">'.htmlspecialchars($txt).'</pre>';
}

function mb_str_replace($needle, $replacement, $haystack){
  $needle_len = mb_strlen($needle);
  $replacement_len = mb_strlen($replacement);
  $pos = mb_strpos($haystack, $needle);
  while ($pos !== false){
    $haystack = mb_substr($haystack, 0, $pos).$replacement.mb_substr($haystack, $pos + $needle_len);
    $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
  }
  return $haystack;
}

function get_template( $content, $template ) {
  $data = $content;
  $template = preg_quote($template, ' ');
  $r = "/{{".$template."(?:[^{}]*(?:{{[^}]*}})?)+(?:[^}]*}})?/i";
  preg_match_all($r, $data, $matches);
  if(isset($matches[0])){
    return $matches[0];
  }
  else return null;
}

function replace_template($old_template_name, $new_template, $txt){
  $regexp = "/{{".$template."(?:[^{}]*(?:{{[^}]*}})?)+(?:[^}]*}})?/i";
  return preg_replace($regexp, $new_template, $txt);
}

$wiki = new wikipedia;
$wiki->quiet = true;
$wiki->login(USERNAME, PASSWORD);

$old_name = 'Infobox Chronologie';
$new_name = 'Infobox - chronologie';
$params = array(
'Umělec' => 'umělec',
'Typ' => 'typ',
'Background' => 'barva pozadí',
'Předchozí singl' => 'předchozí singl',
'Poslední singl' => 'předchozí singl',
'Tento singl' => 'tento singl',
'Další singl' => 'další singl',
'Předchozí album' => 'předchozí album',
'Poslední album' => 'předchozí album',
'Toto album' => 'toto album',
'Další album' => 'další album',
);


$tmp = $wiki->move('Šablona:'.$old_name, 'Šablona:'.$new_name, 'sjednocení infoboxu');
$tmp = $wiki->move('Šablona:'.$old_name.'/doc', 'Šablona:'.$new_name.'/doc', 'sjednocení infoboxu', null, 'noredir');
$articles = $wiki->whatusethetemplate($old_name); //, '&eifilterredir=nonredirects'
// $articles = array('Šablona:'.$new_name.'/doc');
echo "TODO: ".count($articles)."\n-----------------------------------\n";
$i = 0;
foreach($articles as $a){
  echo ++$i.' - '.iconv('UTF-8', 'IBM852', $a).":";
  $content = $wiki->getpage($a);
  $total_count = 0;
  $new_content = $content;
  $templates = get_template($content, $old_name);
  foreach($templates as $template){
    $new_template = $template;


    // $reserved_image_words = array('náhled', 'thumb', 'thumbnail', 'vpravo', 'right', 'vlevo', 'left', 'center', 'střed', 'žádné', 'none', 'rám', 'frame', 'framed', 'bezrámu', 'frameless', 'okraj', 'border', 'upright');
    // $obrazek = $popisek = $velikost_obrazku = null;
    // $regex = '/screenshot[\s]*=[\s]*\[\[(soubor|file|image):(.*\..{3})\|(.*)\]\][ \t]*\n/i';
    // preg_match($regex, $new_template, $matches);
    // $obrazek = trim($matches[2]);
    // $parts = explode('|', $matches[3]);
    // if(is_array($parts)){
    //   foreach($parts as $part){
    //     if(in_array(strtolower($part), $reserved_image_words)) continue;
    //     elseif(substr($part, '-2') == 'px') $velikost_obrazku = $part;
    //     elseif(substr($part, 0, 3) == 'alt') $alt = $part;
    //     else $popisek = $part;
    //   }
    // }
    // $regex = '/screenshot[\s]*=(.*)\n/i';
    // $new_template = preg_replace($regex, " obrázek = ".$obrazek."\n | velikost obrázku = ".$velikost_obrazku."\n | alt=".$popisek."\n", $new_template);  //.$alt
    // $regex = preg_replace('/image[\s]*=[\s]*(soubor|file|image):/i', 'image =', $new_template);
    // $new_template = str_ireplace(array('soubor:', 'image:', 'file:'), '', $new_template);
    foreach($params as $param => $substitution){
      // if($param == 'Rok') $regexp = '/([\s]*\|[\s]*)('.preg_quote($param).')([\s]*=[ \t]*)/';
      // else
      $regexp = '/([\s]*\|[\s]*)('.preg_quote($param).')([\s]*=[ \t]*)/i';
      // if($param == 'web') $new_template  = preg_replace($regexp, "\n | ".$substitution.' = http://', $new_template, 1, $count);
      // else
      $new_template  = preg_replace($regexp, "\n | ".$substitution.' = ', $new_template, -1, $count);
      $total_count += $count;
      // $new_template = preg_replace('/http:\/\/[ \t]*\n/i', "\n", $new_template, -1, $count);
      // $new_template = str_ireplace('Infobox - region|', 'Infobox - region', $new_template, $count);
      // $new_template = str_ireplace('Infobox - region |', 'Infobox - region', $new_template, $count);
    }
    // var_dump($template);
    // $new_content = replace_template($old_name, $new_template, $new_content);
    $new_content = mb_str_replace($template, $new_template, $new_content);
    // $total_count += $count;
  }
  // $new_content = mb_str_replace($old_name, $new_name, $new_content);
  $new_content = str_ireplace($old_name, $new_name, $new_content, $count);
  $total_count += $count;
  $sum = array();
  if($total_count > 0){
    $sum[] = 'sjednocení infoboxů';
    $count = 0;
    if(mb_stripos($new_content, 'timeline', 0, 'utf-8') === false){ //odstraneni dvojitych mezet BACHA NA TIMELINE
      $new_content = preg_replace('/[ \t]+/', ' ', $new_content);
      // if($count > 0) $sum[] = 'odstranění vícenásobných mezer';
      $count = 0;
      // $new_content = preg_replace('/(?:(?:\r\n|\r|\n)\s*){3}/s', "\n\n", $new_content, -1, $count);
      // if($count > 0) $sum[] = 'odstranění nadbytečného odřádkování';
      $count = 0;
    }
    $new_content = str_ireplace('vjazyce2', 'subst:vjazyce2', $new_content, $count);
    if($count > 0) $sum[] = 'substituce šablony vjazyce2';
    $count = 0;
    $new_content = str_ireplace(array('[[image:', '[[file:'), '[[Soubor:', $new_content, $count);
    if($count > 0) $sum[] = 'image/file → soubor';
    $count = 0;
    $new_content = str_ireplace(array('<br>', '<br/>', '</br>', '</ br>'), '<br />', $new_content, $count);
    if($count > 0) $sum[] = 'úprava tagu zalomení';
    $count = 0;
  }
  if($content != $new_content){
    // var_dump($content, $new_content);
    // echo pre($content);
    // echo '<hr style="height:10px;background-color:darkblue;color:blue">';
    // echo pre($new_content);
    // echo '<hr style="height:20px;background-color:darkred;color:red">';
    // die;
    // if($i > 5) die;
    $summary = implode(', ', $sum);
    $edit = $wiki->edit($a, $new_content, $summary, true);
    if($edit['edit']['result'] == 'Success'){
      echo "\tOK (".++$j.")\n";
    }
    else echo print_r($edit, true)."\n";
    ob_flush();
    flush();
    // die;
  }
  else echo "-\n";
  // die;
}

?>

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

/*
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
);*/

/*
$old_name = 'Infobox české obce a města';
$new_name = 'Infobox - česká obec';
$params = array(
'název' => 'název',
'status' => 'status',
'foto' => 'obrázek',
'popisek.foto' => 'popisek obrázku',
'vlajka' => 'vlajka',
'znak' => 'znak',
'pečeť' => 'pečeť',
'NUTS5' => 'nuts5',
'kraj' => 'kraj',
'NUTS3' => 'nuts3',
'okres' => 'okres',
'NUTS4' => 'nuts4',
'souběh' => 'souběh',
'ob.roz.půs' => 'obec s rozšířenou působností',
'pov.ob' => 'pověřená obec',
'země' => 'země',
'k.ú.' => 'katastrální území',
'výměra' => 'výměra',
'obyvatelé' => 'počet obyvatel',
'obyv.datum' => 'obyvatelé datum',
'domů' => 'počet domů',
'zeměpisná šířka' => 'zeměpisná šířka',
'zeměpisná délka' => 'zeměpisná délka',
'nad.výš' => 'nadmořská výška',
'PSČ' => 'psč',
'početzsj' => 'počet zsj',
'početč' => 'počet částí',
'početk' => 'počet katastrálních území',
'adresa' => 'adresa',
'starostka' => 'starostka',
'starosta' => 'starosta',
'web' => 'web',
'úř.web' => 'úřední web',
'úřední web' => 'úřední web',
'email' => 'email',
'mapa' => 'mapa',
'loc-map' => 'loc-map',
'části' => 'části',
'commons' => 'commons',
);

    $regex = '/NUTS5[\s]*=([\w\t ]*)\n/i';
    preg_match($regex, $new_template, $matches);
    $nuts5 = trim($matches[1]);
    $regex = '/NUTS4[\s]*=([\w\t ]*)\n/i';
    preg_match($regex, $new_template, $matches);
    $nuts4 = trim($matches[1]);
    $nuts5 = preg_split('/[\t ]+/', $nuts5);
    if($nuts4 == $nuts5[0]){
      if(count($nuts5) > 1) $nuts5 = $nuts5[1];
      else $nuts5 = implode(' ', $nuts5);
    }
    else{
      if(empty($nuts4) && count($nuts5) > 1){
        $nuts4 = $nuts5[0];
        $nuts5 = $nuts5[1];
      }
      else $nuts5 = implode(' ', $nuts5);
    }

      if($param == 'NUTS4') $new_template  = preg_replace('/([\s]*\|[\s]*)(NUTS4)([\s]*=[ \t]*[\w ]*\n)/i', "\n | nuts4 = ".$nuts4."\n", $new_template, 1, $count);
      elseif($param == 'NUTS5') $new_template  = preg_replace('/([\s]*\|[\s]*)(NUTS5)([\s]*=[ \t]*[\w ]*\n)/i', "\n | nuts5 = ".$nuts5."\n", $new_template, 1, $count);
      elseif($param == 'web' || $param == 'úř.web' || $param == 'úřední web') $new_template  = preg_replace($regexp, "\n | ".$substitution.' = http://', $new_template, 1, $count);

*/

/*
$old_name = 'Infobox hrad';
$new_name = 'Infobox - hrad';
$params = array(
'název' => 'název',
'obrázek' => 'obrázek',
'šířkaobr' => 'velikost obrázku',
'popis' => 'popisek',
'popis1' => 'popisek',
'popis2' => 'alt',
'Poloha' => 'poloha',
'zeměpisná šířka' => 'zeměpisná šířka',
'zeměpisná délka' => 'zeměpisná délka',
'Stát' => 'stát',
'Město' => 'město',
'Historická země' => 'historická země',
'Vystavěn' => 'vystavěn',
'Zničen' => 'zničen',
'Zrekonstruován' => 'zrekonstruován',
'Architekt' => 'architekt',
'Sloh' => 'sloh',
'Stavební materiál' => 'stavební materiál',
'Účel' => 'účel',
'Počet obyvatel' => 'počet obyvatel',
'Původní majitel' => 'původní majitel',
'Rod' => 'rod',
'Současný majitel' => 'současný majitel',
'loc-map' => 'loc-map',
);
*/


/*
$old_name = 'Infobox letadlo';
$new_name = 'Infobox - letadlo';
$params = array(
'název' => 'název',
'typ' => 'typ',
'výrobce' => 'výrobce',
'image' => 'obrázek',
'text' => 'popisek',
'konstruktér' => 'konstruktér',
'první let' => 'první let',
'zaveden' => 'zavedeno',
'vyřazen' => 'vyřazeno',
'výroba' => 'výroba',
'vyrobeno kusů' => 'vyrobeno kusů',
'charakter' => 'charakter',
'cena za kus' => 'cena za kus',
'cena za program' => 'cena za program',
'vyvinut z typu' => 'vyvinuto z typu',
'varianty' => 'varianty',
'další vývoj' => 'další vývoj',
'hlavní uživatel' => 'hlavní uživatel',
'více uživatelů' => 'více uživatelů',
);
*/

/*$old_name = 'Infobox automobil';
$new_name = 'Infobox - automobil';
$params = array(
'název' => 'název',
'obrázek' => 'obrázek',
'velikost obrázku' => 'velikost obrázku',
'popis' => 'popisek',
'popis2' => 'popisek',
'popis1' => 'alt',
'výrobce' => 'výrobce',
'vyrobce' => 'výrobce',
'jména' => 'jména',
'dalsinazvy' => 'jména',
'roky' => 'roky',
'produkce' => 'roky',
'kusů' => 'kusů',
'místa' => 'výrobní místa',
'vyroba' => 'výrobní místa',
'facelift' => 'facelift',
'karosárna' => 'karosárna',
'úpravce' => 'úpravce',
'předchůdce' => 'předchůdce',
'predchozityp' => 'předchůdce',
'nástupce' => 'nástupce',
'nasledujicityp' => 'nástupce',
'generace' => 'generace',
'koncern' => 'koncern',
'mateřská' => 'mateřská společnost',
'příbuzné' => 'příbuzné vozy',
'pribuznevozy' => 'příbuzné vozy',
'konkurence' => 'konkurence',
'karoserie' => 'karoserie',
'pocetdveri' => 'karoserie',
'designer' => 'designer',
'pohon' => 'pohon',
'třída' => 'třída',
'trida' => 'třída',
'platforma' => 'platforma',
'koncepce' => 'koncepce',
'délka' => 'délka',
'delka' => 'délka',
'šířka' => 'šířka',
'sirka' => 'šířka',
'výška' => 'výška',
'vyska' => 'výška',
'rozvor' => 'rozvor',
'převisp' => 'přední převis',
'převisz' => 'zadní převis',
'rozchod' => 'rozchod',
'svýška' => 'světlá výška',
'úhel' => 'nájezdový úhel',
'rám' => 'rám',
'kufr' => 'kufr',
'zavazprostor' => 'kufr',
'náklad' => 'náklad',
'hmotnost' => 'hmotnost',
'pohotovost' => 'pohotovostní hmotnost',
'pohotovostní' => 'pohotovostní hmotnost',
'celková' => 'celková hmotnost',
'užitečná' => 'užitečná hmotnost',
'osob' => 'osob',
'rychlost' => 'maximální rychlost',
'zrychlení' => 'zrychlení',
'nádrž' => 'nádrž',
'objemnadrze' => 'nádrž',
'spotřeba' => 'spotřeba',
'baterie' => 'baterie',
'dojezd' => 'dojezd',
'odpor' => 'aerodynamický odpor',
'aerodynamika' => 'aerodynamický odpor',
'euroncap' => 'euroncap',
'rok' => 'rok euroncap',
'motor' => 'motor',
'objem' => 'objem',
'válců' => 'počet válců',
'výkon' => 'výkon',
'motor2' => 'motor2',
'objem2' => 'objem2',
'válců2' => 'počet válců2',
'výkon2' => 'výkon2',
'motor3' => 'motor3',
'objem3' => 'objem3',
'válců3' => 'počet válců3',
'výkon3' => 'výkon3',
'převodovka' => 'převodovka',
'prevodovka' => 'převodovka',
'druh' => 'druh převodovky',
'stupňů' => 'počet stupňů',
'převodovka2' => 'převodovka2',
'prevodovka2' => 'převodovka2',
'druh2' => 'druh převodovky2',
'stupňů2' => 'počet stupňů2',
'převodovka3' => 'převodovka3',
'prevodovka3' => 'převodovka3',
'druh3' => 'druh převodovky3',
'stupňů3' => 'počet stupňů3',
);*/
/*
$old_name = 'Infobox barva';
$new_name = 'Infobox - barva';
$params = array(
'RGB' => 'rgb',
'hex' => 'hex',
'css' => 'css',
'CMYK' => 'cmyk',
'HSV' => 'hsv',
'Lab' => 'lab',
);
*/

/*$old_name = 'Infobox chráněné území v Česku';
$new_name = 'Infobox - chráněné území v Česku';
$params = array(
'typ' => 'typ',
'název' => 'název',
'foto' => 'obrázek',
'popis' => 'popisek',
'vyhlášena' => 'datum vyhlášení',
'vyhlásil' => 'vyhlásil',
'zrušena' => 'datum zrušení',
'úsop' => 'úsop',
'lokalita' => 'lokalita',
'výška' => 'nadmořská výška',
'výměra' => 'výměra',
'zeměpisná šířka' => 'zeměpisná šířka',
'zeměpisná délka' => 'zeměpisná délka',
'okres' => 'okres',
'okres2' => 'okres2',
'okres3' => 'okres3',
'okres4' => 'okres4',
'poznámky' => 'poznámky',
'commons' => 'commons',
'commonscat' => 'commonscat',
'loc-map' => 'loc-map',
);*/

$old_name = 'Infobox řád';
$new_name = 'Infobox - řád';
$params = array(
'název' => 'název',
'původní název' => 'původní název',
'obrázek' => 'obrázek',
'šířka obrázku' => 'velikost obrázku',
'popis obrázku' => 'popisek',
'země' => 'země',
'datum založení' => 'datum založení',
'zakladatel' => 'zakladatel',
'schválil' => 'schválil',
'kategorie řádu' => 'kategorie řádu',
'počet tříd' => 'počet tříd',
'heslo' => 'heslo',
'odznak' => 'odznak',
'oděv' => 'oděv',
'patroni' => 'patroni',
'hvězda' => 'hvězda',
'stuha' => 'stuha',
'obrázek stuhy' => 'obrázek stuhy',
'další odkazy' => 'další odkazy',
);


/*
TODO: nahradit posledni album za predchozi album v infobox album
TODO: zajistit spravne popisky u osob (aby obsahovaly px)
TODO: obrazky a loga v Infobox - operační systém
TODO: Infobox - doména nejvyššího řádu - uzavreni sablony ve clancich je pomoci |}} a jeste casto na spatnem radku
navboxovat Šablona:Tři pilíře EU
           Šablona:Křesťanská demokracie
           Šablona:Liberalismus
           Šablona:Anarchismus
*/

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
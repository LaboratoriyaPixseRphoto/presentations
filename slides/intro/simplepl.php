<?php
  $url = 'http://wherein.yahooapis.com/v1/document';
  $appid = 'Gux4Z8LIkY1IKfVXnRcMegs3IjNfmUhl';

  $q = <<<EOB
I was born in Greenland, grew up in Denmark and have also lived in Canada, Brazil and now live in
Sunnyvale.  Currently at the University of Illinois in Champaign for Hack Day.
Jack London is not around.

EOB;

  $post = "appid=$appid&documentType=text/plain&documentContent=".rawurlencode($q);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  $data = curl_exec($ch);
  curl_close($ch);
  $x = simplexml_load_string($data);
  foreach($x->document->placeDetails as $p) {
    $woeid =$p->place->woeId;
    $type = $p->place->type;
    $name = $p->place->name;
    $lat = $p->place->centroid->latitude;
    $lon = $p->place->centroid->longitude;
    echo "$woeid $type: $name at $lat,$lon<br>\n";
  }
?>

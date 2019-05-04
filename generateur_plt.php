<?php
if ($argc != 4) {
  echo "Arguments: program largeur hauteur ou densiter manquant ! \n";
  die();
}

$x = $argv[1];
$y = $argv[2];
$density = $argv[3];
$plateau = $y."\n";

for ($i=0; $i < $y; $i++) {
  for ($j=0; $j < $x; $j++) {
    if (rand(0, $y)*2 < $density){
      $plateau .= "o";
    }
    else {
      $plateau .= ".";
    }
  }
  $plateau .= "\n";
}

$plt_file = fopen("plateau.txt", "w");
fwrite($plt_file, $plateau);
fclose($plt_file);

 ?>

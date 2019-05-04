<?php

function bsq($tab, $size)
{
  $result = [];
  $bsqr_size = 1;
  echo $size."\n";
  foreach ($tab as $y => $line) 
  {
    $nbr_x = count($line);
    $nbr_y = $size;
    foreach ($line as $x => $value) 
    {
      if($value != "o")
      {
        if (!empty($value) && empty($result)) 
        {
          $result = [1, $x, 0];
        }
        for ($sq_size=$bsqr_size; ($sq_size + $y) < $nbr_y && ($sq_size + $x) < $nbr_x; $sq_size++) 
        {
          for ($sq_y=0; $sq_y <= $sq_size; $sq_y++) 
          {
            for ($sq_x=0; $sq_x <= $sq_size; $sq_x++) 
            {
              if ($tab[$y+$sq_y][$x+$sq_x]!=".") 
              {
                if ($bsqr_size < $sq_size) 
                {
                  $bsqr_size = $sq_size;
                  $bsqr_x = $x;
                  $bsqr_y = $y;
                  $result = [$bsqr_size, $bsqr_x, $bsqr_y];
                }
                break 3;
              }
            }
          }
        }
      }
    }
  }
  return $result;
}


function check_argv($arg)
{
  if (count($arg) != 2)
  {
    echo "Veuillez renseigner le fichier map\n par example :\n php bsq.php ******.txt\n";
    exit;
  }
}

function check_file($file)
{
  if (!is_file($file))
  {
    echo "Le fichier renseigner n'as pas était trouver\n";
    exit;
  }
}

function check_size($array)
{
  if (!preg_match('#[0-9]+#', $array[0]))
  {
    echo "La premiere ligne doit être un nombre\n";
    exit;
  }
}

function check_size_tab($size, $array)
{
  if($size != (count($array)-1)) 
  {
    echo "La taille de la map ne corespend pas au chiffre indiquer en première ligne\n";
    exit;
  }
}

function check_line_size($array, $size)
{
  foreach ($array as $line) 
  {
    for ($i=0; $i < $size-1; $i++) 
    {
      if (count($array[$i]) != count($array[$i+1]))
      {
        echo "Chaque ligne doit avoir la même taille\n";
        exit;
      }
    }
  }
}

function check_content($array)
{
  foreach ($array as $key => $line) 
  {
    if ($key != count($array)-1)
    {
      foreach ($line as $value) 
      {
        if(!preg_match('#\.#', $value) && !preg_match('#o#', $value))
        {
          echo "Les map doit être constituer que de '.' ou de 'o' \n";
          exit;
        }
      }
    }
  }
}

function open($file)
{
  $handle = fopen($file, "r");
  return fread($handle, filesize($file));
}

function string_to_array($string)
{
  $array = explode("\n", $string);
  return $array;
}

function line_to_array(&$array)
{
  foreach ($array as &$value) 
  {
    $value = str_split($value);
  }
}

function get_size(&$array)
{
  $var=$array[0];
  array_shift($array);
  return $var;
}

function result($tab, $result)
{
  foreach ($tab as $y => $line) 
  {
    foreach ($line as $x => $value) 
    {
      if ($result[1] <= $x && $x < $result[0]+$result[1] && $result[2] <= $y && $y < $result[0]+$result[2])
      {
        echo "x";
      }
      else
      {
        echo $value;
      }
    }
    echo "\n";
  }
}

function exec_bsq($arg)
{
  check_argv($arg);
  check_file($arg[1]);
  $result = [];
  $strtab = open($arg[1]);
  $tab = string_to_array($strtab);
  check_size($tab);
  $size = intval(get_size($tab));
  check_size_tab($size, $tab);
  line_to_array($tab);
  check_line_size($tab, $size);
  check_content($tab);
  $result = bsq($tab, $size);
  result($tab, $result);
}

exec_bsq($argv);

?>

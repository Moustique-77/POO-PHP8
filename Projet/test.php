<?php
// save info
function save($character)
{
  echo "Entrer le nom de la sauvegarde";
  fscanf(STDIN, "%s", $nameSave);

  $save = fopen($nameSave . ".txt", "w");

  fwrite($save, $character->getName() . "\n");


  fclose($save);
}

// Allows to load the information stored
function openSave($character)
{
  foreach (glob("*.txt") as $fileName) {
    echo $fileName . "\n";
  }

  echo "Entre le nom de la sauvegarde : ";
  fscanf(STDIN, "%s", $nameSave);
  echo $nameSave;
  $save = fopen($nameSave, "r");

  $character->setLvl(fgets($save));
}

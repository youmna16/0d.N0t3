<?php



function check($var){
  //Validate => remove unwated space * trim
  $var=trim($var);
  // remove html tags *srip_tags
  $var=strip_tags($var);
  // remove slaches *removeslaches*
  $var=stripslashes($var);
  return $var;

}

 ?>

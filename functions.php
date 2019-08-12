
<?php
function yearsort($dateIn){
      $dateOut=[];
      $size = count($dateIn);
      $thisYear = date('Y');
      $j=0;
      for($i=0;$i<$size;$i++){
        if($thisYear <= substr($dateIn[$i], -4)){
          $dateOut[$j]= strtotime($dateIn[$i])*1000;
          $j++;
        }
      }
      return $dateOut;
}
?>
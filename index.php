<?php

//ビンゴシート配列作成
$bingo = array();
$S = (int)trim(fgets(STDIN));

for($i = 0; $i < $S; $i++){
    $bingo[$i] =  explode(' ',trim(fgets(STDIN)));
}

//発表される単語配列作成
$words = array();
$N = (int)trim(fgets(STDIN));

for($i = 0; $i < $N; $i++){
    $words[$i] = trim(fgets(STDIN));
    
}




$opened = array();


//データを初期化
function initArray(&$opened,$S) {
    for ($y = 0; $y < $S; ++$y) {
        for($x = 0; $x < $S; ++$x) {
            $opened[$y][$x] = false;
        }    
    }
}



//$bingoの中の単語と一致している物を$wordと定義、一致している場合はその場所を返す
function findPosByWord($bingo,$word,$S) {
        for($y = 0; $y < $S; $y++) {
          for($x = 0; $x < $S; $x++) {
              if($bingo[$y][$x] === $word ) {
                 return array($y, $x);
              }
        }     
    }
    return NULL;
}

//穴を開ける箇所をtrueとする
function openBingo(&$opened, $x, $y) {
    $opened[$y][$x] = true;
}



//データを初期化作業
initArray($opened,$S);


//ビンゴに穴を開ける作業
for($i = 0; $i < $N; $i++){
    $pos = findPosByWord($bingo,$words[$i],$S);
    if(!is_null($pos)){
        openBingo($opened,$pos[1],$pos[0]);
    }
}


//ビンゴ判定作業
function isClear($opened,$S) {
    // 横軸判定
    for($y = 0; $y < $S; ++$y) {
        for($x = 0; $x < $S; ++$x) {
            if (!$opened[$y][$x]) break;
            
            if ($x == $S-1) {
                return true;
            }
        }
    }
    
     // 縦軸判定
    for($x = 0; $x < $S; ++$x) {
        for($y = 0; $y < $S; ++$y) {
            if (!$opened[$y][$x]) break;
            if ($y == $S-1) {
                return true;
            }
        }
    }
    
    // 斜め判定①
    for($i = 0; $i < $S; ++$i) {
        if (!$opened[$i][$i]) break;
        if ($i == $S-1) {
            return true;
        }
    }
    
    // 斜め判定②
    for($i = 0; $i < $S; ++$i) {
        if (!$opened[$i][$S-1 - $i]) break;
        if ($i == $S-1) {
            return true;
        }
    }    
    

}





// ビンゴの場合は"yes",そうでない場合は"no"を表示する
echo isClear($opened,$S)? "yes":"no";



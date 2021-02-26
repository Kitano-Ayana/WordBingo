<?php

//ビンゴシートのマス目($S)の作成
$S = (int)trim(fgets(STDIN));

//ビンゴシート配列($bingo)
$bingo = array();

//ビンゴシート配列の作成
for($i = 0; $i < $S; $i++){
    $bingo[$i] =  explode(' ',trim(fgets(STDIN)));
}

//発表される単語($N)の作成
$N = (int)trim(fgets(STDIN));

//発表される単語配列
$words = array();

//発表される単語配列の作成
for($i = 0; $i < $N; $i++){
    $words[$i] = trim(fgets(STDIN));
    
}




//ビンゴシートの単語と発表される単語が一致しているか確認する配列
$opened = array();


//ビンゴシートと発表される単語の一致確認のデータを初期化
function initArray(&$opened,$S) {
    for ($y = 0; $y < $S; ++$y) {
        for($x = 0; $x < $S; ++$x) {
            $opened[$y][$x] = false;
        }    
    }
}



//$bingoの中から指定した単語($word)を探し、一致してる単語があればその場所を返す
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



//ビンゴシートの単語と発表される単語の一致確認データを初期化
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

            //穴があいてない場合は中止する
            if (!$opened[$y][$x]) break;

            //一列穴が開いた場合trueとする
            if ($x == $S-1) {
                return true;
            }
        }
    }
    
     // 縦軸判定
    for($x = 0; $x < $S; ++$x) {
        for($y = 0; $y < $S; ++$y) {

            //穴があいてない場合は中止する
            if (!$opened[$y][$x]) break;

            //一列穴が開いた場合trueとする
            if ($y == $S-1) {
                return true;
            }
        }
    }
    
    // 斜め判定①
    for($i = 0; $i < $S; ++$i) {

            //穴があいてない場合は中止する
            if (!$opened[$i][$i]) break;

            //一列穴が開いた場合trueとする
            if ($i == $S-1) {
            return true;
        }
    }
    
    // 斜め判定②
    for($i = 0; $i < $S; ++$i) {

        //穴があいてない場合は中止する
        if (!$opened[$i][$S-1 - $i]) break;

        //一列穴が開いた場合trueとする
        if ($i == $S-1) {
            return true;
        }
    }    
    

}





// ビンゴの場合は"yes",そうでない場合は"no"を表示する
echo isClear($opened,$S)? "yes":"no";



<?php


function encode_rle(string $input_path, string $output_path){
    $str = file_get_contents ($input_path);


    if(!isset($str)){
        echo "KO";
        return "KO";
    }

    $len = strlen ($str);
    $count = 0;
    $output = '';
    $count2 = 1;
    $i = 0;


    if(is_null($str)){
        file_put_contents($output_path, $output);
        return 0;
    }
    
    if(isset($str[0]) && !isset($str[1])){
        $output .=chr($count).chr(1).$str[0];
        file_put_contents($output_path, $output);
        return 0;
        
    }

    
    while($i <= $len){
        if (isset($str[$i]) && isset($str[$i+1]) && $str[$i+1] === $str[$i]){
            while ($str[$i] === $str[$i+1] && isset($str[$i+1])){
                $count2++;
                $i++;
                if($count2 == 255){

                    $output.=chr(255).$str[$i];
                    $count2 = 0;
                    
                }
            }
       
            $output .=chr($count2).$str[$i];
            $count2 = 1;
        }
        elseif (isset($str[$i]) && isset($str[$i+1]) && $str[$i+1] != $str[$i]){

            $a = $i;

            while($str[$i] != $str[$i+1] && isset($str[$i+1])){
                $count2++;
                $i++;
            }if(isset($str[$i+1])){
                $count2--;
                $i--;
            }
            $output .=chr($count).chr($count2);
            while ($a <= $i){
                $output .= $str[$a];
                $a++;
            }$count2 = 1;
        }$i++;
    }
    
    file_put_contents($output_path, $output );
    return 0;
    
}

function decode_rle(string $input_path, string $output_path){
    $str = file_get_contents ($input_path);

    if(!isset($str)){
        echo "KO";
        return "KO";
    }

    $len = strlen ($str);
    $count = 0;
    $output = '';
    $count2 = 1;
    $i = 0;
    

    if(is_null($str)){
        file_get_contents($input_path,);
        return 0;
    }
    if ($len == 1){
        return 1;
    }
    while($i < $len){
        if(unpack("C", $str[$i])[1] >0){
            $nbr_loop = unpack("C", $str[$i])[1];
            if (!isset($str[$i+1])){
                return 1;
            }
            $i++;
            for($x = 0; $nbr_loop > $x; $x++){
                $output .= $str[$i];
            }
        }elseif(unpack("C", $str[$i])[1] == $count){
            $i++;
            $nbr_loop = unpack("C", $str[$i])[1];
            for($x=0; $nbr_loop > $x; $x++){
                if(isset($str[$i+1])){
                $i++;
                $output .=$str[$i];
                }else {
                    return 1;
                }
                
            
            }
        }$i++;
    }
    file_put_contents($output_path, $output );

}



if(isset($argv[1]) && $argv[1] === 'encode'){	
	$source = (isset($argv[2])) ? $argv[2] : '';
	$dest = $argv[3];
	if ($source === '') {
		echo 'KO'."\n";
		return 1;
	}
   
	$result = encode_rle($source, $dest);
    if ($result == 0){
       echo "OK";
       return (0);
    }
    else {
       echo "KO";
       return (1);
    }
	echo "\n";
}

if(isset($argv[1]) && $argv[1] === 'decode'){	
	$source = (isset($argv[2])) ? $argv[2] : '';
	$dest = $argv[3];
	if ($source === '') {
		echo 'KO'."\n";
		return 1;
	}
   
	$result = decode_rle($source, $dest);
    if ($result == 0){
       echo "OK";
       return (0);
    }
    else {
       echo "KO";
       return (1);
    }
	echo "\n";
}
        
    
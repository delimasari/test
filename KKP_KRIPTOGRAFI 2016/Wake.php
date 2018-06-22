<?php

//error_reporting(E_ERROR | E_PARSE);
//$sumber = $_FILES['file2']['tmp_name'];
//$fileName = $_FILES['file2']['name'];
//$handler = fopen($sumber, "r");
//$ukuran_file = $_FILES['file2']['size'];
//$type_file = $_FILES['file2']['type'];

class Wake{
	public $isi_berkas;
	public $key;
	public $roundKey;
	public function AddBiner($a,$b){
		$carry = 0;
	for($i=0; $i<32; $i++){
		$a[$i] = substr($a, $i, 1);
		$b[$i] = substr($b, $i, 1); 
		$c[$i] = (int) $a[$i];
		$d[$i] = (int) $b[$i];
		}
	for($i=31; $i>=0; $i--){	
		$res[$i] = ($c[$i] ^ $d[$i]) ^ $carry;
		if($c[$i] && $d[$i] == 1 || $c[$i] && $carry == 1 || $carry && $d[$i]){
			$carry = 1;
		}
		else{
		$carry = 0;
		}
	}
	$j=0;
	$k=32;
	while($j<32){
		$resi[$k] = $res[$j];
		$j++;
		$k--;	
	}
	$result = implode("",$resi);
		return $result;
	}
	public function ShiftRight($a,$b){
		$Fshift = substr($a,0, 32-$b);
		$Fshift = str_pad($Fshift, 32, 0, STR_PAD_LEFT);
		return $Fshift;
	}
	public function FBiner($a,$b){
		for($i=0; $i<8; $i++){
        	$a[$i] = substr($a, $i, 1);
			$b[$i] = substr($b, $i, 1);
			$c[$i] = intval($a[$i]) ^ intval($b[$i]);
		}
		$result = implode("",$c);
		return $result;
	}
	public function FOpBiner($operasi,$a,$b){
		for($i=0; $i<32; $i++){
        	$a[$i] = substr($a, $i, 1);
			$b[$i] = substr($b, $i, 1);
			if($operasi == "XOR"){
			    $c[$i] = intval($a[$i]) ^ intval($b[$i]);
    		}
			elseif($operasi == "AND"){
			    $c[$i] = intval($a[$i]) & intval($b[$i]);
    		}
			elseif($operasi == "OR"){
			    $c[$i] = intval($a[$i]) | intval($b[$i]);
    		}
		}
		$result = implode("",$c);
		return $result;
	
	}
	public function PembentukanSBox($key){
		$this->key = $key;
		$tt[0] = str_pad(decbin(hexdec("726A8F3B")),32,0, STR_PAD_LEFT);
		$tt[1] = str_pad(decbin(hexdec("E69A3B5C")),32,0, STR_PAD_LEFT);
		$tt[2] = str_pad(decbin(hexdec("D3C71FE5")),32,0, STR_PAD_LEFT);
		$tt[3] = str_pad(decbin(hexdec("AB3C73D2")),32,0, STR_PAD_LEFT);
		$tt[4] = str_pad(decbin(hexdec("4D3A8EB3")),32,0, STR_PAD_LEFT);
		$tt[5] = str_pad(decbin(hexdec("0396D6E8")),32,0, STR_PAD_LEFT);
		$tt[6] = str_pad(decbin(hexdec("3D4C2F7A")),32,0, STR_PAD_LEFT);
		$tt[7] = str_pad(decbin(hexdec("9EE27CF3")),32,0, STR_PAD_LEFT);
		//memecah key menjadi 4 bagian dan memasukannya kedalam box $t.
		$key_hex = "";
		$j=0;
/* 		for ($i=0; $i<strlen($this->key); $i++){
			$ord = ord($this->key[$i]);
			$key_hex .= str_pad(decbin($ord),8,"0", STR_PAD_LEFT);	

 		}*/
		$j=0;
		$a = '';
		for($i=0;$i<16;$i++){
			$ord = ord($this->key[$j]);
			$key_hex .= str_pad(decbin($ord),8,"0", STR_PAD_LEFT);	
			if($j==strlen($this->key)-1){
				$j=0;
			}else{
				$j++;
			}
		}
		$t[0] = substr($key_hex, 0, 32); 
		$t[1] = substr($key_hex, 32, 32);
		$t[2] = substr($key_hex, 64, 32);
		$t[3] = substr($key_hex, 96, 32);
		//langkah ke 3, untuk n=4 - 255
		for($n=4; $n<=255; $n++){
			$c = $t[$n-4];
			$d = $t[$n-1];
			$x = $this->AddBiner($c,$d);	
			$r[$n] = $this->ShiftRight($x,3);
			$e = $this->FOpBiner("AND",$x,str_pad(decbin("7"),32,0, STR_PAD_LEFT));
			$t[$n] = $this->FOpBiner("XOR",$r[$n],$tt[bindec($e)]);
		}
		//langkah ke 4, untuk n=0 - n=22
		for($n=0; $n<=22; $n++){
			$t[$n] = $this->AddBiner($t[$n],$t[$n+89]);
		}
		//langkah ke 5, set beberapa nilai
		$x = $t[33];
		$a = str_pad(decbin(hexdec("01000001")),32,0, STR_PAD_LEFT);
		$b = str_pad(decbin(hexdec("FF7FFFFF")),32,0, STR_PAD_LEFT);
		$z = $this->FOpBiner("OR",$t[59],$a);
		$z = $this->FOpBiner("AND",$z,$b);
		$x = $this->FOpBiner("AND",$x,$b);
		$x = $this->AddBiner($x,$z);
		// udah persiss
		//langkah ke 6, untuk t=0 - t=255
		$e = str_pad(decbin(hexdec("00FFFFFF")),32,0, STR_PAD_LEFT);
		for($n=0; $n<=255; $n++){
			$x = $this->AddBiner($this->FOpBiner("AND",$x,$b),$z);
			$t[$n] = $this->FOpBiner("AND",$t[$n],$e); 
			$t[$n] = $this->FOpBiner("XOR",$t[$n],$x);
		}//oke sip sama
		//langkah ke 7, inisialisasi beberapa nilai
		$t[256] = $t[0];
		$f = str_pad(decbin("255"),32,0, STR_PAD_LEFT);//ini jadiin 32 bit dong, semuanya juga hexdec decbin.
		$x = $this->FOpBiner("AND",$x,$f);	
		//langkah 8, lakukan beberapa set nilai
		for($n=0; $n<=255; $n++){
			$q = str_pad(decbin($n),32,0, STR_PAD_LEFT);
			$y = $this->FOpBiner("XOR",$q,$x);
			$temp = $this->FOpBiner("AND",$this->FOpBiner("XOR",$t[bindec($y)],$x),$f);//beberapa blm bener
			$t[$n] = $t[bindec($temp)];
			$t[bindec($x)] = $t[$n+1];
		}
		return $t;
	}
	public function PembentukanKunci($key,$roundKey){
		$t = $this->PembentukanSBox($key);
		$key_hex = "";
		for ($i=0; $i<strlen($this->key); $i++){
			$ord = ord($this->key[$i]);
			$key_hex .= str_pad(decbin($ord),8,"0", STR_PAD_LEFT);	
		}
		$a[0] = substr($key_hex, 0, 32); 
		$b[0] = substr($key_hex, 32, 32);
		$c[0] = substr($key_hex, 64, 32);
		$d[0] = substr($key_hex, 96, 32);
		for($i=0; $i<$roundKey; $i++){
			$a[$i+1] = $this->FroundKey($a[$i], $d[$i], $t);
			$b[$i+1] = $this->FroundKey($b[$i], $a[$i+1], $t);
			$c[$i+1] = $this->FroundKey($c[$i], $b[$i+1], $t);
			$d[$i+1] = $this->FroundKey($d[$i], $c[$i+1], $t);
		}
		$Fkey = $d[$roundKey];
		return $Fkey;
	}
	function FroundKey($a,$b,$t){
		$c = $this->AddBiner($a,$b);
	
		$d = $this->ShiftRight($c,8);
		$e = $this->FOpBiner("AND",$c, str_pad(decbin("255"),32,0, STR_PAD_LEFT));
		$res = $this->FOpBiner("XOR",$d,$t[bindec($e)]);
		return $res;
	}
	function enkripsiwake($isi_berkas,$key,$roundKey){
		$key = $this->PembentukanKunci($key, $roundKey);
		$k[0] = substr($key, 0, 8); 
		$k[1] = substr($key, 8, 8);
		$k[2] = substr($key, 16, 8);
		$k[3] = substr($key, 24, 8);
		$plain = "";
		for ($i=0; $i<strlen($isi_berkas); $i++){
			$ord = ord($isi_berkas[$i]);
			$plain[$i] = str_pad(decbin($ord),8,"0", STR_PAD_LEFT);	
			}
		$j =0;
		$res = "";
		for($n=0; $n<strlen($isi_berkas); $n++){
			$res[$n] = $this->FBiner($plain[$n],$k[$j]);
			$res[$n] = chr(bindec($res[$n]));
			if($j<3){
				$j++;
			}else{
				$j=0;
			}
		}
		$res = implode("",$res);
		return $res;
	}
	function dekripsiwake($isi_berkas,$key,$roundKey){
		$key = $this->PembentukanKunci($key,$roundKey);
		$k[0] = substr($key, 0, 8); 
		$k[1] = substr($key, 8, 8);
		$k[2] = substr($key, 16, 8);
		$k[3] = substr($key, 24, 8);
		$cipher = "";
		for ($i=0; $i<strlen($isi_berkas); $i++){
			$ord = ord($isi_berkas[$i]);
			$cipher[$i]= str_pad(decbin($ord),8,"0", STR_PAD_LEFT);	
		}
		$j =0;

		for($n=0; $n<strlen($isi_berkas); $n++){
			$res[$n] = $this->FBiner($cipher[$n],$k[$j]);
			$res[$n] = chr(bindec($res[$n]));
			if($j<3){
				$j++;
			}else{
				$j=0;
			}
		}
		$res = implode("",$res);
		return $res;
	}

}

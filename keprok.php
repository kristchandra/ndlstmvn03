<?php
date_default_timezone_set('Asia/Jakarta');
include "function.php";
echo color("green","[]      BISMILLAHIRRAHMANIRRAHIM      []\n");
echo color("yellow","[]          BY : KOMPLONK             []\n");
echo color("green","[]  Time  : ".date('[d-m-Y] [H:i:s]')."   []\n");
function change(){
        $nama = nama();
        $email = str_replace(" ", "", $nama) . mt_rand(100, 999);
        ulang:
        echo color("nevy","(•) Nomor : ");
        // $no = trim(fgets(STDIN));
        $nohp = trim(fgets(STDIN));
        $nohp = str_replace("62","62",$nohp);
        $nohp = str_replace("(","",$nohp);
        $nohp = str_replace(")","",$nohp);
        $nohp = str_replace("-","",$nohp);
        $nohp = str_replace(" ","",$nohp);

        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            if (substr(trim($nohp),0,3)=='62') {
                $hp = trim($nohp);
            }
            else if (substr(trim($nohp),0,1)=='0') {
                $hp = '62'.substr(trim($nohp),1);
        }
         elseif(substr(trim($nohp), 0, 2)=='62'){
            $hp = '6'.substr(trim($nohp), 1);
        }
        else{
            $hp = '1'.substr(trim($nohp),0,13);
        }
    }
        $data = '{"email":"'.$email.'@gmail.com","name":"'.$nama.'","phone":"+'.$hp.'","signed_up_country":"ID"}';
        $register = request("/v5/customers", null, $data);
        if(strpos($register, '"otp_token"')){
        $otptoken = getStr('"otp_token":"','"',$register);
        echo color("green","+] Kode verifikasi sudah di kirim")."\n";
        otp:
        echo color("nevy","?] Otp: ");
        $otp = trim(fgets(STDIN));
        $data1 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $otptoken . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
        $verif = request("/v5/customers/phone/verify", null, $data1);
        if(strpos($verif, '"access_token"')){
        echo color("green","+] Berhasil mendaftar\n");
        $token = getStr('"access_token":"','"',$verif);
        $uuid = getStr('"resource_owner_id":',',',$verif);
        echo color("green","+] Token : ".$token."\n");
        save("token.txt",$token);
        echo "\n".color("yellow","!] Claim voc GOFOOD");
        echo "\n".color("yellow","!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        $goride1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"GOFOOD022620A"}');
        $message1 = fetch_value($goride1,'"message":"','"');
        if(strpos($goride1, 'Promo kamu sudah bisa dipakai.')){
        echo "\n".color("green","+] Message: ".$message1);
        goto setpin;
        }else{
        echo "\n".color("red","-] Message: ".$message1);
        sleep(3);
        $cekvoucher = request('/gopoints/v3/wallet/vouchers?limit=15&page=1', $token);
        $total = fetch_value($cekvoucher,'"total_vouchers":',',');
        $voucher1 = getStr1('"title":"','",',$cekvoucher,"1");
        $voucher2 = getStr1('"title":"','",',$cekvoucher,"2");
        $voucher3 = getStr1('"title":"','",',$cekvoucher,"3");
        $voucher4 = getStr1('"title":"','",',$cekvoucher,"4");
        $voucher5 = getStr1('"title":"','",',$cekvoucher,"5");
        $voucher6 = getStr1('"title":"','",',$cekvoucher,"6");
        $voucher7 = getStr1('"title":"','",',$cekvoucher,"7");
        $voucher8 = getStr1('"title":"','",',$cekvoucher,"8");
        $voucher9 = getStr1('"title":"','",',$cekvoucher,"9");
        $voucher10 = getStr1('"title":"','",',$cekvoucher,"10");
        $voucher11 = getStr1('"title":"','",',$cekvoucher,"11");
        $voucher12 = getStr1('"title":"','",',$cekvoucher,"12");
        echo "\n".color("yellow","!] Total voucher ".$total." : ");
        echo "\n".color("green","1.".$voucher1);
        echo "\n".color("green","2.".$voucher2);
        echo "\n".color("green","3.".$voucher3);
        echo "\n".color("green","4.".$voucher4);
        echo "\n".color("green","5.".$voucher5);
        echo "\n".color("green","6.".$voucher6);
        echo "\n".color("green","7.".$voucher7);
        echo "\n".color("green","8.".$voucher8);
        echo "\n".color("green","9.".$voucher9);
        echo "\n".color("green","10.".$voucher10);
        echo "\n".color("green","11.".$voucher11);
        echo "\n".color("green","12.".$voucher12)."\n";
         setpin:
         echo color("nevy","=============( SET PIN )=============")."\n";
         echo color("yellow","========( PIN ANDA = 112233 )========")."\n";
         $data2 = '{"pin":"112233"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         otpsetpin:
         echo color("nevy","?] Otp set pin: ");
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         $messageverifotpsetpin = fetch_value($verifotpsetpin,'"message":"','"');
         if(strpos($verifotpsetpin, 'OTP kamu tidak berlaku. Silakan masukkan OTP yang masih berlaku.')){
         echo color("red","-] Message: ".$messageverifotpsetpin)."\n";
         goto setpin;
         }else{
         echo color("green","+] Message: +] SUKSES!!!");
         }
         }else{
         goto setpin;
         }
         }else{
         echo color("red","-] Otp yang anda input salah");
         echo"\n==================================\n\n";
         echo color("yellow","!] Silahkan input kembali\n");
         goto otp;
         }
         }else{
         echo color("red","NOMOR SUDAH TERDAFTAR/SALAH !!!");
         echo "\nMau ulang? (y/n): ";
         $pilih = trim(fgets(STDIN));
         if($pilih == "y" || $pilih == "Y"){
         echo "\n==============Register==============\n";
         goto ulang;
         }else{
         echo "\n==============Register==============\n";
         goto ulang;
  }
 }
}
echo change()."\n"; ?>

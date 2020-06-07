<?php
if($_POST)
{
 $to_Email = "serwis@sbram.pl"; //Podaj tu email docelowy
 $subject = "=?UTF-8?B?".base64_encode("Wiadomość ze strony sbram.pl")."?=";
  
  
 //Sprawdzamy czy jest to rządanie Ajax, jeśli nie..
 if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
  
 //Kończymy skrypt wysyłając dane JSON
 $output = json_encode(
 array(
 'type'=>'error', 
 'text' => 'Rządanie musi przejść przez AJAX'
 ));
  
 die($output);
 } 
  
 //Sprawdzamy czy wszystkie pola zostały wysłane. kończymy skrypt jeśli nie (tutaj dodawaj więcej pól, które są wymagane)
 if(!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["message"]))
 {
 $output = json_encode(array('type'=>'error', 'text' => 'POLA SĄ PUSTE!'));
 die($output);
 }
 
 //Pobieramy dane z formularza
 $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
 $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
 $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
 $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
  
 //Dodatkowa validacja PHP (tylko dla pól wymaganych)
 if(strlen($name)<3) // Wywala błąd jeśli imię ma mniej niż 3 znaki
 {
 $output = json_encode(array('type'=>'error', 'text' => 'Imię jest za krótkie!'));
 die($output);
 }
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //sprawdzamy email
 {
 $output = json_encode(array('type'=>'error', 'text' => 'Proszę podać poprawny email!'));
 die($output);
 }
 if(strlen($message)<5) //Sprawdzamy czy wiadomość ma więcej niż 5 znaków
 {
 $output = json_encode(array('type'=>'error', 'text' => 'Wiadomość za krótka! Wpisz coś jeszcze.'));
 die($output);
 }
  
 //Nagłówki do Maila

$headers = "MIME-Version: 1.0\r\n";
$headers.= "Content-Type: text/plain;charset=utf-8\r\n";
$headers.= "Reply-To: ".$email."" . "\r\n";
$headers.= "X-Mailer: PHP/" . phpversion();


  
 $sentMail = @mail($to_Email, $subject, $message .' -'.$name.' -'.$phone, $headers, "-f serwis@sbram.pl");
  
 if(!$sentMail)
 {
 $output = json_encode(array('type'=>'error', 'text' => 'Nie można wysłać wiadomości. Sprawdź konfigurację PHP Mail'));
 die($output);
 }else{
 $output = json_encode(array('type'=>'message', 'text' => 'Witaj '.$name .' Dziękuję za wiadomość!'));
 die($output);
 }
}
?>
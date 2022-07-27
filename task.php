/**
* Автор: Сугак Никита
*
* Дата реализации: 27.07.2022 10:00
*
* Дата изменения: 27.07.2022 19:20
*
* Утилита для работы с базой данных
<?php
include 'person.php';
include 'idPerson.php';

$tom = new Person([4, 'Tom', 'Joch', '10.08.2001', 0, 'Minsk']);
$bob = new Person([5, 'Bob', 'Joch', '11.11.2011', 0, 'Minsk']);
$bob2 = new Person(5);
$kat = new Person([6, 'Kat', 'Tiskovskay', '28.03.2002', 1, 'Minsk']);

Person::deleteInBd(6);

$StdClass = new Person([$tom->id, $tom->name, $tom->secondName, Person::getYears($tom->dateOfBirdth), Person::convertSexInText($tom->sex), "Minsk"]);

$id = new IdPerson('>=4'); 
$person = $id->getPerson();
$id->deleteInBd();
?>
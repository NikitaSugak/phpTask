/**
* Автор: Сугак Никита
*
* Дата реализации: 27.07.2022 10:00
*
* Дата изменения: 27.07.2022 19:20
*
* Класс IdPerson
<?php

if (class_exists('Person')) {
    /**
    Класс для получения и удаления экземпляров класса Person из базы данных.
    */
    class IdPerson
    {
        private $id = [];

        function __construct($var)
        {
            try {
                $conn = new PDO('mysql:host=localhost', 'root', 'admin');
            }
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            $sql = 'SELECT id FROM php.person WHERE id ' . $var;
            $result = $conn->query($sql);

            while ($row = $result->fetch()) {
                $this->id[] = $row['id'];
            }
        }

        function deleteInBd()
        {
            foreach ($this->id as $id) {
                Person::deleteInBd($id);
            }
        }

        function getPerson()
        {
            $person = [];

            try {
                $conn = new PDO('mysql:host=localhost', 'root', 'admin');
            }
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            foreach ($this->id as $id) {
                $sql = 'SELECT * FROM php.person WHERE id = ' . $id;
                $result = $conn->query($sql);
                $row = $result->fetch();
                $person[] = new Person([$row['id'], $row['name'], $row['second_name'], $row['date_of_birdth'], $row['sex"'], $row['city_of_birdth']]);
            }

            return $person;
        }
    }
} else {
    echo 'Ошибка: класс Person не существует';
}
?>
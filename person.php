/**
* Автор: Сугак Никита
*
* Дата реализации: 12.05.2022 17:00
*
* Дата изменения: 16.05.2022 03:10
*
* Класс Person
<?php
/**
Класс для сохранения и удаления экземпляров этого класса в базе данных.
 */
class Person
{ 
    private $id, $name, $secondName, $dateOfBirdth, $sex, $cityOfBirdth;
      
    function __construct($person)
    {
        if(is_int($person)) {
            try {
                $conn = new PDO('mysql:host=localhost', 'root', 'admin');
            }
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            $sql = 'SELECT * FROM php.person WHERE id = ' . $person;
            $result = $conn->query($sql);
            $row = $result->fetch();

            $this->id = $person;
            $this->name = $row['name'];
            $this->secondName = $row['second_name'];
            $this->dateOfBirdth = $row['date_of_birdth'];
            $this->sex = $row['sex'];
            $this->cityOfBirdth = $row['city_of_birdth'];
        } else if (is_array($person)) {
            $this->id = $person[0];
            $this->name = $person[1];
            $this->secondName =$person[2];
            $this->dateOfBirdth = $person[3];
            $this->sex = $person[4];
            $this->cityOfBirdth = $person[5];

            Person::saveInBd();
        }
    }

    public function __get($property)
    {
        switch ($property) {
            case 'id':
                return $this->id;
            case 'name':
                return $this->name;
            case 'secondName':
                return $this->secondName;
            case 'dateOfBirdth':
                return $this->dateOfBirdth;
            case 'sex':
                return $this->sex;
            case 'cityOfBirdth':
                return $this->cityOfBirdth;
            default:
                break;
        }
    }

    private function saveInBd()
    {
        try {
            $conn = new PDO('mysql:host=localhost', 'root', 'admin');
        }
        catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $sql = "INSERT INTO php.person (name, second_name, date_of_birdth, sex, city_of_birdth) VALUES ('"
             . $this->name . "', '" 
             . $this->secondName . "', '" 
             . $this->dateOfBirdth ."', "
             .$this->sex .", '"
             . $this->cityOfBirdth ."')";
     
        $conn->exec($sql);
    }

    static function deleteInBd($id)
    {
        try {
            $conn = new PDO('mysql:host=localhost', 'root', 'admin');
        }
        catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        $sql = 'DELETE FROM php.person WHERE id = ' . $id;
     
        $conn->exec($sql);
    }

    static function getYears($dateOfBirdth)
    {
        $years = date('Y') - ($dateOfBirdth[6] . $dateOfBirdth[7] . $dateOfBirdth[8] .  $dateOfBirdth[9]);
        
        if ($dateOfBirdth[0] . $dateOfBirdth[1] > date('j')) {
            if ($dateOfBirdth[3] . $dateOfBirdth[4] >= date('m')) {
                $years = $years - 1;
            }
        } elseif ($dateOfBirdth[3] . $dateOfBirdth[4] > date('m')) {
            $years = $years - 1;
        }

        return $years;
    }

    static function convertSexInText($sex)
    {
        if ($sex == 0){
            return 'Муж';
        } elseif ($sex == 1){
            return 'Жен';
        } else {
            return 'Неопределённый пол';
        }
    }
}
?>
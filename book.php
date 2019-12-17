<?php

class book
{
    private $db;

    public function __construct($db_connect)
    {
        $this->db = $db_connect;
    }

    public function add($name, $author, $image_url, $language, $owner_id, $temp_owner_id)
    {
        try {
            $sql = "INSERT INTO books(name, author, image_url, language, owner_id, temp_owner_id)
                               VALUES(:name, :author, :image_url, :language, :owner_id, :temp_owner_id)";
            $query = $this->db->prepare($sql);
            $query->bindParam(":name", $name);
            $query->bindParam(":author", $author);
            $query->bindParam(":language", $language);
            $query->bindParam(":image_url", $image_url);
            $query->bindParam(":owner_id", $owner_id);
            $query->bindParam(":temp_owner_id", $temp_owner_id);
            $query->execute();
        } catch
        (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }

    public function takeBook($temp_owner_id, $id_books)
    {
        try {
            $sql = "UPDATE books SET temp_owner_id =:temp_owner_id WHERE id_books=:id_books";
            $query = $this->db->prepare($sql);
            $query->bindParam(":temp_owner_id", $temp_owner_id);
            $query->bindParam(":id_books", $id_books);
            $query->execute();
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }

    public function searchBook($bookName)
    {
        try {
            $sql = "SELECT * FROM books WHERE name LIKE :keyword";
            $query = $this->db->prepare($sql);
            $query->bindParam(":keyword", $bookName);
            $query->execute();
            while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<h3>" . print_r($r, true) . "</h3>";
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}



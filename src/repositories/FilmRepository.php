<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Film.php';

class FilmRepository extends Repository
{
    public function findAll(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT
                "f"."id" "id",
                "title",
                "posterUrl",
                "avgRate",
                "description",
                "releaseDate",
                "d"."id" "directorId",
                "firstName",
                "lastName"
            FROM "Films" f
            JOIN "FilmDetails" fd
                ON "f"."id" = "fd"."filmId"
            JOIN "Directors" d 
                ON "fd"."directorId" = "d"."id"
        ');
        $stmt->execute();
        $this->database->disconnect();

        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($films as $film) {
            $result[] = new Film(
                $film['title'],
                $film['posterUrl'],
                $film['description'],
                $film['releaseDate'],
                new Director(
                    $film['firstName'],
                    $film['lastName'],
                    $film['directorId'],
                ),
                $film['avgRate'],
                $film['id'],
            );
        }

        return $result;
    }

    public function findAllByTitle(string $title): array {
        $title = '%'.strtolower($title).'%';

        $stmt = $this->database->connect()->prepare('
            SELECT
                "f"."id" "id",
                "title",
                "posterUrl",
                "avgRate",
                "description",
                "releaseDate",
                "d"."id" "directorId",
                "firstName",
                "lastName"
            FROM "Films" f
            JOIN "FilmDetails" fd
                ON "f"."id" = "fd"."filmId"
            JOIN "Directors" d 
                ON "fd"."directorId" = "d"."id"
            WHERE
                LOWER("title") LIKE :title OR
                LOWER("description") LIKE :title
        ');
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->execute();
        $this->database->disconnect();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(string $id): ?Film
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "Films" WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $this->database->disconnect();

        $film = $stmt->fetch(PDO::FETCH_ASSOC);


        // @TODO Throw Exception
        if ($film === false) {
            return null;
        }

        return new Film(
            $film['title'],
            $film['posterUrl'],
            $film['avgRate'],
            $film['id']
        );
    }

    public function create(Film $film): void {
        // @TODO Transaction
        // @TODO Close connection!
        $conn = $this->database->connect();

        $stmt = $conn->prepare('
            INSERT INTO "Films" ("title", "posterUrl")
            VALUES (?, ?)
            RETURNING "id"
        ');
        $stmt->execute([
            $film->getTitle(),
            $film->getPosterUrl(),
        ]);

        $insertedFilm = $stmt->fetch(PDO::FETCH_ASSOC);
        $filmId = $insertedFilm['id'];  // Assuming 'id' is the column name

        $stmt = $conn->prepare('
            INSERT INTO "FilmDetails" ("filmId", "description", "releaseDate", "directorId")
            VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([
            $filmId,
            $film->getDescription(),
            $film->getReleaseDate(),
            $film->getDirector()->getId()
        ]);

        $this->database->disconnect();

        echo "Hello";
    }
}

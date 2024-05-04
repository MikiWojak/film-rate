<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Role.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function findByUsername(string $username, bool $includePassword = false): ?User
    {
        $limitedFields = '"userId", "username", "email", "roleId", "roleName"';
        $fields = $includePassword ? '*' : $limitedFields;

        $this->database->connect();
        $stmt = $this->database->getConnection()->prepare('
            SELECT '.$fields.'
            FROM "Users2Roles"
            WHERE username = :username
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $this->database->disconnect();

        $userRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->findByProcessUser($userRows);
    }

    public function findByEmail(string $email, bool $includePassword = false): ?User
    {
        $limitedFields = '"userId", "username", "email", "roleId", "roleName"';
        $fields = $includePassword ? '*' : $limitedFields;

        $this->database->connect();
        $stmt = $this->database->getConnection()->prepare('
            SELECT '.$fields.'
            FROM "Users2Roles"
            WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $this->database->disconnect();

        $userRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->findByProcessUser($userRows);
    }

    private function findByProcessUser(array $userRows) : ?User {
        if (count($userRows) === 0) {
            return null;
        }

        $roles = [];

        foreach ($userRows as $row) {
            $roles[] = new Role(
                $row['roleName'],
                $row['roleId'],
            );
        }

        return new User(
            $userRows[0]['username'],
            $userRows[0]['email'],
            $roles,
            $userRows[0]['password'] ?? null,
            $userRows[0]['userId']
        );
    }

    public function create(User $user) : void
    {
        try {
            $this->database->connect();

            $this->database->getConnection()->beginTransaction();

            $stmt = $this->database->getConnection()->prepare('
                INSERT INTO "Users" ("username", "email", "password")
                VALUES (?, ?, ?)
                RETURNING id
            ');
            $stmt->execute([
                $user->getUsername(),
                $user->getEmail(),
                $user->getPassword(),
            ]);

            $insertedUser = $stmt->fetch(PDO::FETCH_ASSOC);
            $userId = $insertedUser['id'];

            foreach ($user->getRoles() as $role) {
                $stmt = $this->database->getConnection()->prepare('
                    INSERT INTO "Role2User" ("roleId", "userId")
                    VALUES (?, ?)
                ');
                $stmt->execute([
                    $role->getId(),
                    $userId,
                ]);
            }

            $this->database->getConnection()->commit();

        } catch (Exception $e) {
            $this->database->getConnection()->rollBack();

            throw $e;
        } finally {
            $this->database->disconnect();
        }
    }
}

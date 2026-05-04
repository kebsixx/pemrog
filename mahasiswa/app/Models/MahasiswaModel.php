<?php
declare(strict_types=1);

namespace App\Models;

class MahasiswaModel
{
    private \PDO $db;
    private string $schema;

    public function __construct(\PDO $db, string $schema = 'mahasiswa')
    {
        $this->db = $db;
        $this->schema = $schema;
    }

    public function login(string $user, string $pass): ?array
    {
        $sql = "SELECT id, username, password FROM {$this->schema}.mahasiswa WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $user]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        if (!password_verify($pass, $row['password'])) {
            return null;
        }

        return $row;
    }

    public function getProfile(int $id): ?array
    {
        $sql = "SELECT id, nrp, nama, alamat, ttl, email, nohp, username FROM {$this->schema}.mahasiswa WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function getAllMahasiswa(): array
    {
        $sql = "SELECT id, nrp, nama FROM {$this->schema}.mahasiswa ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function isUsernameTaken(string $username): bool
    {
        $sql = "SELECT 1 FROM {$this->schema}.mahasiswa WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);

        return (bool) $stmt->fetchColumn();
    }

    public function register(array $data): bool
    {
        $sql = "INSERT INTO {$this->schema}.mahasiswa (nama, nrp, alamat, ttl, email, nohp, username, password)
                VALUES (:nama, :nrp, :alamat, :ttl, :email, :nohp, :username, :password)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nama' => $data['nama'],
            ':nrp' => $data['nrp'],
            ':alamat' => $data['alamat'],
            ':ttl' => $data['ttl'],
            ':email' => $data['email'],
            ':nohp' => $data['nohp'],
            ':username' => $data['username'],
            ':password' => $data['password'],
        ]);
    }
}

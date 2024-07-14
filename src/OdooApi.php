<?php

namespace Codemusk\OdooApi;

use Ripcord\Ripcord;

class OdooApi
{
    protected $url;
    protected $db;
    protected $username;
    protected $password;
    protected $uid;
    protected $models;

    public function __construct($url, $db, $username, $password)
    {
        $this->url = $url;
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
        $this->authenticate();
    }

    protected function authenticate()
    {
        try {
            $common = Ripcord::client("$this->url/xmlrpc/2/common");
            $this->uid = $common->authenticate($this->db, $this->username, $this->password, []);
            $this->models = Ripcord::client("$this->url/xmlrpc/2/object");
        } catch (\Exception $e) {
            throw new \Exception("Authentication failed: " . $e->getMessage());
        }
    }

    public function listRecords($model, $offset = 0, $limit = 10, $fields = [])
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'search_read',
                [[]],
                ['offset' => $offset, 'limit' => $limit, 'fields' => $fields]
            );
        } catch (\Exception $e) {
            throw new \Exception("Error listing records: " . $e->getMessage());
        }
    }

    public function createRecord($model, $data)
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'create',
                [$data]
            );
        } catch (\Exception $e) {
            throw new \Exception("Error creating record: " . $e->getMessage());
        }
    }

    public function readRecord($model, $recordId, $fields = [])
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'read',
                [$recordId],
                ['fields' => $fields]
            );
        } catch (\Exception $e) {
            throw new \Exception("Error reading record: " . $e->getMessage());
        }
    }

    public function updateRecord($model, $recordId, $data)
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'write',
                [[$recordId], $data]
            );
        } catch (\Exception $e) {
            throw new \Exception("Error updating record: " . $e->getMessage());
        }
    }

    public function deleteRecord($model, $recordId)
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'unlink',
                [[$recordId]]
            );
        } catch (\Exception $e) {
            throw new \Exception("Error deleting record: " . $e->getMessage());
        }
    }

    public function searchAndRead($model, $domain = [], $fields = [], $offset = 0, $limit = 10)
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'search_read',
                [$domain],
                ['offset' => $offset, 'limit' => $limit, 'fields' => $fields]
            );
        } catch (\Exception $e) {
            throw new \Exception("Error searching and reading records: " . $e->getMessage());
        }
    }

    public function listRecordFields($model)
    {
        try {
            return $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                $model,
                'fields_get',
                []
            );
        } catch (\Exception $e) {
            throw new \Exception("Error listing record fields: " . $e->getMessage());
        }
    }
}

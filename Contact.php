<?php

/**
 * Classe de conexão com o DB
 * @author Emerson Martins
 */
Class Contact
{
    private $attributes;

    public function __construct()
    {
        
    }

    public function __set(string $attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        return $this;        
    }

    public function __get(string $attribute)
    {
        return $this->attributes[$attribute];
    }

    public function __isset($attribute)
    {
        return isset($this->attributes[$attribute]);
    }

    /**
     * Salvar contato
     * @return boolean
     */
    public function save()
    {
        $columns = $this->prepare($this->attributes);
        if (!isset($this->id)) {
            $query = "INSERT INTO contatos (".
                implode(', ', array_keys($columns)).
                ") VALUES (".
                implode(', ', array_values($columns)).");";
        } else {
            foreach ($columns as $key => $value) {
                if ($key !== 'id') {
                    $define[] = "{$key}={$value}";
                }
            }
            $query = "UPDATE contatos SET ".implode(', ', $define)." WHERE id='{$this->id}';";
        }
        if ($connection = Connection::getInstance()) {
            $stmt = $connection->prepare($query);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }
        return false;
    }

    /**
     * Tornar valores aceitos para sintaxe SQL
     * @return string
     */
    private function escape($data)
    {
        if (is_string($data) & !empty($data)) {
            return "'".addslashes($data)."'";
        } elseif (is_bool($data)) {
            return $data ? 'TRUE' : 'FALSE';
        } elseif ($data !== '') {
            return $data;
        } else {
            return 'NULL';
        }
    }
 
    /**
     * Verifica se data são próprios para ser salvos
     * @param array $data
     * @return array
     */
    private function prepare($data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (is_scalar($value)) {
                $result[$key] = $this->escape($value);
            }
        }
        return $result;
    }
 
    /**
     * Retorna uma lista de contatos
     * @return array/boolean
     */
    public static function all()
    {
        $connection = Connection::getInstance();
        $stmt    = $connection->prepare("SELECT * FROM contatos;");
        $result  = [];

        if ($stmt->execute()) {
            while ($rs = $stmt->fetchObject(Contact::class)) {
                $result[] = $rs;
            }
        }

        if (count($result) > 0) {
            return $result;
        }

        return false;
    }
 
    /**
     * Retornar o número de registros
     * @return int/boolean
     */
    public static function count()
    {
        $connection = Connection::getInstance();
        $count   = $connection->exec("SELECT count(*) FROM contatos;");

        if ($count) {
            return (int) $count;
        }

        return false;
    }
 
    /**
     * Encontra um recurso pelo id
     * @param type $id
     * @return type
     */
    public static function find($id)
    {
        $connection = Connection::getInstance();
        $stmt = $connection->prepare("SELECT * FROM contatos WHERE id='{$id}';");

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchObject('Contact');
                if ($result) {
                    return $result;
                }
            }
        }

        return false;
    }
 
    /**
     * Destruir um recurso
     * @param type $id
     * @return boolean
     */
    public static function destroy($id)
    {
        $connection = Connection::getInstance();

        if ($connection->exec("DELETE FROM contatos WHERE id='{$id}';")) {
            return true;
        }

        return false;
    }
}

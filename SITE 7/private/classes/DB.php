<?php
class DB {
    private static $con;
    private static $dbnm;
    private static $conMethod;
    public static $lastInsertID;

    public function __construct(int $conMethod, string $host = '', string $user = '', string $pass = '', string $dbnm = '', string $port = '') {
        if (!empty($host) && !empty($user) && !empty($dbnm)) {
            self::$conMethod = $conMethod;

            try {
                switch ($conMethod) {
                    case 1: // MySQL (deprecated)
                        if (function_exists('mysql_connect')) {
                            self::$con = @mysql_connect($host, $user, $pass) ?: throw new Exception("Failed to connect! #MySQL");
                            if (!@mysql_select_db($dbnm, self::$con)) {
                                self::$dbnm = $dbnm;
                            }
                        } else {
                            throw new Exception("MySQL extension is deprecated in PHP 8");
                        }
                        break;

                    case 2: // MySQLi
                        self::$con = @mysqli_connect($host, $user, $pass, $dbnm);
                        if (!self::$con) {
                            throw new Exception("Failed to connect! #MySQLi");
                        }
                        break;

                    case 3: // PDO-MySQL
                        $dsn = "mysql:host={$host};dbname={$dbnm}";
                        $options = [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false,
                        ];
                        self::$con = new PDO($dsn, $user, $pass, $options);
                        break;

                    default:
                        throw new Exception("Invalid connection method");
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                throw $e;
            }
        } else {
            throw new Exception("Incomplete connection parameters");
        }
    }

public static function Executa(string $sql, array $params = []): array|bool {
    if (empty(self::$con) || empty($sql)) {
        return false;
    }

    $sql_ini = strtoupper(substr(trim($sql), 0, 6));

    try {
        switch (self::$conMethod) {
            case 1: // MySQL (deprecated)
                // MySQL não suporta parâmetros preparados diretamente
                if (!empty(self::$dbnm)) {
                    @mysql_select_db(self::$dbnm, self::$con);
                }
                $query = @mysql_query($sql, self::$con);
                if (!$query) return false;

                return match($sql_ini) {
                    'SELECT' => mysql_fetch_all($query),
                    'INSERT' => self::handleMySQLInsert($query),
                    default => true
                };

            case 2: // MySQLi
                // MySQLi requer preparação manual
                if (!empty(self::$dbnm)) {
                    mysqli_select_db(self::$con, self::$dbnm);
                }
                $stmt = mysqli_prepare(self::$con, $sql);
                if (!$stmt) return false;

                if (!empty($params)) {
                    $types = str_repeat('s', count($params)); // Todos os parâmetros como string
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                }

                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                return match($sql_ini) {
                    'SELECT' => mysqli_fetch_all($result, MYSQLI_ASSOC),
                    'INSERT' => self::handleMySQLiInsert($stmt),
                    default => true
                };

            case 3: // PDO-MySQL
                $stmt = self::$con->prepare($sql);
                $stmt->execute($params);

                return match($sql_ini) {
                    'SELECT' => $stmt->fetchAll(),
                    'INSERT' => self::handlePDOInsert($stmt),
                    default => true
                };

            default:
                return false;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

    private static function handleMySQLInsert($query): bool {
        self::$lastInsertID = mysql_insert_id(self::$con);
        return true;
    }

    private static function handleMySQLiInsert($query): bool {
        self::$lastInsertID = mysqli_insert_id(self::$con);
        return true;
    }

    private static function handlePDOInsert($query): bool {
        self::$lastInsertID = self::$con->lastInsertId();
        if (empty(self::$lastInsertID)) {
            $idQuery = self::$con->query("SELECT @@IDENTITY AS lastInsertID");
            $result = $idQuery->fetch();
            self::$lastInsertID = $result['lastInsertID'];
        }
        return true;
    }

    public static function close(): void {
        switch (self::$conMethod) {
            case 1:
                if (function_exists('mysql_close')) {
                    @mysql_close(self::$con);
                }
                break;
            case 2:
                mysqli_close(self::$con);
                break;
        }
        self::$con = null;
    }
}
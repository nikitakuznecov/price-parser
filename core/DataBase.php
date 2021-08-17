<?

namespace PParser\Core;

/**
 * Простенький класс для работы с базой данных MSQL
 */
class DataBase extends Singleton
{
    /**
     * Идентификатор соединения
     */
    private $mysqli;

    /**
     * Символ значения в запросе
     */
    private $sym_query = "{?}";

    /**
     * Поскольку конструктор Одиночки вызывается только один раз, постоянно
     * открыто всего лишь одино соединение с базой данных.
     */
    protected function __construct()
    {

        $config = Config::getInstance();
        $this->mysqli = new \MySQLi($config->getValue("hostname"), $config->getValue("username"), $config->getValue("password"), $config->getValue("database"));
        $this->mysqli->query("SET lc_time_names = 'ru_RU'");
        $this->mysqli->query("SET NAMES 'utf8'");

    }

    /**
     * Вспомогательный метод, который заменяет "символ значения в запросе" на конкретное значение, которое проходит через "функции безопасности"
     */
    protected function getQuery($query, $params): mixed
    {
        if ($params) {
            for ($i = 0; $i < count($params); $i++) {
                $pos = strpos($query, $this->sym_query);
                $arg = "'" . $this->mysqli->real_escape_string($params[$i]) . "'";
                $query = substr_replace($query, $arg, $pos, strlen($this->sym_query));
            }
        }
        return $query;
    }

    /**
     * SELECT-метод, возвращающий таблицу результатов
     */

    public function select($query, $params = false): mixed
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if (!$result_set) return false;
        return $this->resultSetToArray($result_set);
    }

    /**
     * SELECT-метод, возвращающий одну строку с результатом
     */

    public function selectRow($query, $params = false): mixed
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if ($result_set->num_rows != 1) return false;
        else return $result_set->fetch_assoc();
    }

    /**
     * SELECT-метод, возвращающий значение из конкретной ячейки
     */

    public function selectCell($query, $params = false): mixed
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if ((!$result_set) || ($result_set->num_rows != 1)) return false;
        else {
            $arr = array_values($result_set->fetch_assoc());
            return $arr[0];
        }
    }

    /**
     * НЕ-SELECT методы (INSERT, UPDATE, DELETE). Если запрос INSERT, то возвращается id последней вставленной записи
     */
    public function query($query, $params = false): mixed
    {
        $success = $this->mysqli->query($this->getQuery($query, $params));
        if ($success) {
            if ($this->mysqli->insert_id === 0) return true;
            else return $this->mysqli->insert_id;
        } else return false;
    }

    /**
     * Преобразование result_set в двумерный массив
     */

    protected function resultSetToArray($result_set): array
    {
        $array = array();
        while (($row = $result_set->fetch_assoc()) != false) {
            $array[] = $row;
        }
        return $array;
    }

    /**
     * При уничтожении объекта закрывается соединение с базой данных
     */
    public function __destruct()
    {
        if ($this->mysqli) $this->mysqli->close();
    }
}

?>
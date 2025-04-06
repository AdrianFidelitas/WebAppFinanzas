<?php
namespace app\models;
use \PDO;

if (file_exists(__DIR__ . "/../../config/server.php")) {
    require_once __DIR__ . "/../../config/server.php";
}

class mainModel {
    private $server = DB_SERVER;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    protected function connect() {
        $connection = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db, $this->user, $this->pass);
        $connection->exec("SET CHARACTER SET utf8");
        return $connection;
    }

    protected function execQuery($query) {
        $sql = $this->connect()->prepare($query);
        $sql->execute();
        return $sql;
    }

    public function cleanString($string) {
        $words = ["<script>", "</script>", "<script src", "<script type=", "SELECT * FROM", "SELECT ", " SELECT ", "DELETE FROM", "INSERT INTO", "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES", "SHOW DATABASES", "<?php", "?>", "--", "^", "<", ">", "==", "=", ";", "::"];

        $string = trim($string);
        $string = stripslashes($string);

        foreach ($words as $word) {
            $string = str_ireplace($word, "", $string);
        }

        $string = trim($string);
        $string = stripslashes($string);

        return $string;
    }

    protected function verifyData($filter, $string) {
        if (preg_match("/^" . $filter . "$/", $string)) {
            return false;
        } else {
            return true;
        }
    }

    protected function execStoredProcedure($procedureName, $data) {
        $query = "CALL $procedureName(";

        $C = 0;
        foreach ($data as $item) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $item["parameter_marker"];
            $C++;
        }

        $query .= ")";

        $sql = $this->connect()->prepare($query);

        foreach ($data as $item) {
            $sql->bindParam($item["parameter_marker"], $item["parameter_value"]);
        }

        $sql->execute();

        return $sql;
    }

    public function paginateTables($page, $totalPages, $url, $buttons) {
        $table = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

        if ($page <= 1) {
            $table .= '<a class="pagination-previous is-disabled" disabled>Previous</a><ul class="pagination-list">';
        } else {
            $table .= '<a class="pagination-previous" href="' . $url . ($page - 1) . '/">Previous</a><ul class="pagination-list">';
            $table .= '<li><a class="pagination-link" href="' . $url . '1/">1</a></li><li><span class="pagination-ellipsis">&hellip;</span></li>';
        }

        $ci = 0;
        for ($i = $page; $i <= $totalPages; $i++) {
            if ($ci >= $buttons) {
                break;
            }

            if ($page == $i) {
                $table .= '<li><a class="pagination-link is-current" href="' . $url . $i . '/">' . $i . '</a></li>';
            } else {
                $table .= '<li><a class="pagination-link" href="' . $url . $i . '/">' . $i . '</a></li>';
            }

            $ci++;
        }

        if ($page == $totalPages) {
            $table .= '</ul><a class="pagination-next is-disabled" disabled>Next</a>';
        } else {
            $table .= '<li><span class="pagination-ellipsis">&hellip;</span></li><li><a class="pagination-link" href="' . $url . $totalPages . '/">' . $totalPages . '</a></li></ul>';
            $table .= '<a class="pagination-next" href="' . $url . ($page + 1) . '/">Next</a>';
        }

        $table .= '</nav>';
        return $table;
    }
}

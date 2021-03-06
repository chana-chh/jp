<?php

/**
 * Osnovni model
 *
 * Svaki model mora da nasledi ovu klasu
 *
 * @version v 0.0.1
 * @author ChaSha
 * @copyright Copyright (c) 2019, ChaSha
 */

namespace App\Modeli;

use Illuminate\Support\Facades\URL;

/**
 * Model
 *
 * @author ChaSha
 * @abstract
 */
abstract class ModelChaSha
{

    /**
	 * PDO wrapper
	 * @var \App\Classes\Db
	 */
    protected $db;

    /**
	 * Naziv tabele modela
	 * @var string
	 */
    protected $table;

    /**
	 * Primarni kljuc tabele modela
	 * @var string
	 */
    protected $pk = 'id';

    /**
	 * Naziv momdela
	 * @var string
	 */
    protected $model;

    /**
	 * Konfiguracija za paginaciju
	 * @var array
	 */
    protected $pagination_config;

    /**
	 * Konstruktor
	 *
	 * @param \App\Classes\QueryBuilder Query builder
	 * @throws \Exception Ako tabele u QueryBuilder-u i Model-u nisu iste
	 */
    public function __construct()
    {
        $this->db = DbChaSha::instance();
        $this->pagination_config = [
            'per_page' => 50,
            'page_span' => 3,
            'css' => [
                'buttons_container' => 'pagination',
                'button_active' => 'active',
                'button_disabled' => 'disabled',
                'goto' => 'form-control',
            ]
        ];
        $this->model = get_class($this);
    }

    /**
	 * Izvrsava upit preko PDO
	 *
	 * Za upite koji menjaju podatke u bazi
	 * INSERT, UPDATE, DELETE
	 *
	 * @param string $sql SQL izraz
	 * @param array $params Parametri za parametrizovani upit
	 * @return \PDOStatement
	 */
    public function run(string $sql, array $params = null)
    {
        return Db::run($sql, $params);
    }

    /**
	 * Izvrsava upit preko PDO
	 *
	 * Za upite koji vracaju podatke iz baze
	 * SELECT
	 *
	 * @param string $sql SQL izraz
	 * @param array $params Parametri za parametrizovani upit
	 * @return array Niz rezultata (instanci Model-a) upita
	 */
    public function fetch(string $sql, array $params = null, string $model = null)
    {
        $model = ($model === null) ? $this->model : $model;
        return DbChaSha::fetch($sql, $params, $model);
    }

    /**
	 * Vraca sve zapise iz tabele (sortirane)
	 *
	 * @param string $sort_column Naziv kolone za sortiranje
	 * @param string $sort Ncin sortiranja
	 * @return array|\App\Classes\Model Niz modela ili jedan model
	 */
    public function all(string $sort_column = null, $sort = 'ASC')
    {
        $order_by = '';
        $params = null;
        $sort = ($sort === 'DESC') ? $sort : 'ASC';
        if ($sort_column !== null && !empty(trim($sort_column))) {
            $order_by = " ORDER BY :{$sort_column} {$sort}";
            $params = [":{$sort_column}" => $sort_column];
        }
        $sql = "SELECT * FROM {$this->table}{$order_by};";
        return $this->fetch($sql, $params);
    }

    /**
	 * Pronalazi red po PK
	 *
	 * @param $id Vrednost PK reda koji se trazi
	 * @return \App\Classes\Model
	 */
    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->pk} = :id LIMIT 1;";
        $params = [":id" => $id];
        return $this->fetch($sql, $params) === [] ? null : $this->fetch($sql, $params)[0];
    }

    /**
	 * Vraca SELECT sa navedenim kolonama
	 */
    public function select(array $columns)
    {
        $cols = implode(', ', $columns);
        $sql = "SELECT {$cols} FROM {$this->table};";
        return $this->fetch($sql);
    }

    /**
	 * Vraca broj redova u tabeli
	 */
    public function countTable()
    {
        $sql = "SELECT COUNT(*) AS table_count FROM {$this->table}";
        return (int)$this->fetch($sql)[0]->table_count;
    }

    /**
	 * Vraca podatke i linkove za stranicu
	 *
	 * @param integer $page Broj stranice
	 * @param integer $perpage Broj redova na stranici
	 * @return array podaci + linkovi
	 */
    public function paginate(int $page, string $sql = null, array $params = null, int $perpage = null, int $span = null)
    {
        $sql = ($sql !== null) ? $sql : "SELECT * FROM {$this->table};";
        $data = $this->pageData($page, $sql, $params, $perpage);
        $links = $this->pageLinks($page, $perpage, $span);
        return ['data' => $data, 'links' => $links];
    }

    /**
	 * Vraca podatke za stranicu
	 *
	 * @param integer $page Broj stranice
	 * @param integer $perpage Broj redova na stranici
	 * @return array \App\Classes\Model Niz modela sa podacima
	 */
    protected function pageData(int $page, string $sql, array $params = null, int $perpage = null)
    {
        $sql = substr_replace($sql, 'SELECT SQL_CALC_FOUND_ROWS', 0, 6);
        if ($perpage === null) {
            $perpage = $this->pagination_config['per_page'];
        }
        $limit = $perpage;
        $offset = ($page - 1) * $perpage;
        $sql = rtrim($sql, ';');
        $sql .= " LIMIT {$limit} OFFSET {$offset};";
        $data = $this->fetch($sql, $params);
        return $data;
    }

    /**
	 * Vraca broj redova poslednjeg upita bez limita
	 */
    protected function foundRows()
    {
        $sql = "SELECT FOUND_ROWS() AS count;";
        return (int)$this->fetch($sql)[0]->count;
    }

    /**
	 * Vraca linkove i dr. za paginaciju
	 */
    protected function pageLinks(int $page, int $perpage = null)
    {
        $css = $this->pagination_config['css'];
        $links = [];
        $links['current_page'] = $page;
        if ($perpage === null) {
            $perpage = $this->pagination_config['per_page'];
        }
        $links['per_page'] = $perpage;
        $span = $this->pagination_config['page_span'];
        $count = $this->foundRows();
        $links['total_rows'] = $count;
        $u = explode('?', URL::full());
        $url = $u[0];
        $links['url'] = $url;
        $pages = (int)ceil($count / $perpage);
        $links['total_pages'] = $pages;
        $full_span = (($span * 2 + 1) > $pages) ? $pages : $span * 2 + 1;
        $prev = ($page > 2) ? $page - 1 : 1;
        $links['prev_page'] = $prev;
        $next = ($page < $pages) ? $page + 1 : $pages;
        $links['next_page'] = $next;
        $start = $page - $span;
        $end = $page + $span;
        if ($page <= $span + 1) {
            $start = 1;
            $end = $full_span;
        }
        if ($page >= $pages - $span) {
            $start = $pages - $span * 2;
            $end = $pages;
        }
        if ($full_span >= $pages) {
            $start = 1;
            $end = $pages;
        }
        $disabled_begin = ($page === 1) ? $css['button_disabled'] : "";
        $disabled_end = ($page === $pages) ? $css['button_disabled'] : "";
        $zapis_od = (($page - 1) * $perpage) + 1;
        $zapis_do = ($zapis_od + $perpage) - 1;
        $zapis_do = $zapis_do >= $count ? $count : $zapis_do;
        $links['row_from'] = $zapis_od;
        $links['row_to'] = $zapis_do;

        $buttons = "<ul class=\"{$css['buttons_container']}\">";
        $buttons .= "<li class=\"paginate_button {$disabled_begin}\"><a href=\"{$url}?page=1\" tabindex=\"-1\">1</a></li>";
        $buttons .= "<li class=\"paginate_button {$disabled_begin}\"><a href=\"{$url}?page={$prev}\" tabindex=\"-1\"><i class=\"fa fa-angle-left\"></i></a></li>";
        for ($i = $start; $i <= $end; $i++) {
            $current = '';
            if ($page === $i) {
                $current = $css['button_active'] . ' ' . $css['button_disabled'];
            }
            $buttons .= "<li class=\"paginate_button {$current}\"><a href=\"{$url}?page={$i}\" tabindex=\"-1\">{$i}</a></li>";
        }
        $buttons .= "<li class=\"paginate_button {$disabled_end}\"><a href=\"{$url}?page={$next}\" tabindex=\"-1\"><i class=\"fa fa-angle-right\"></i></a></li>";
        $buttons .= "<li class=\"paginate_button {$disabled_end}\"><a href=\"{$url}?page={$pages}\" tabindex=\"-1\">{$pages}</a></li>";
        $buttons .= "</ul>";
        $links['buttons'] = $buttons;
        $goto = "<select class=\"{$css['goto']}\" name=\"pgn-goto\" id=\"pgn-goto\">";
        for ($i = 1; $i <= $pages; $i++) {
            $selected = '';
            if ($page === $i) {
                $selected = ' selected';
            }
            $goto .= "<option value=\"{$url}?page={$i}\"{$selected}>{$i}</option>";
        }
        $goto .= "</select>";
        $links['select'] = $goto;

        return $links;
    }

    /**
	 * Vraca naziv tabele Model-a
	 *
	 * @return string
	 */
    public function getTable()
    {
        return $this->table;
    }

    /**
	 * Vraca naziv primarnog kljuca tabele Model-a
	 *
	 * @return string
	 */
    public function getPrimaryKey()
    {
        return $this->pk;
    }

    /**
	 * Vraca naziv Model-a
	 *
	 * @return string
	 */
    public function getModel()
    {
        return $this->model;
    }

    /**
	 * Vraca poslednji uneti ID
	 *
	 * @return string
	 */
    public function getLastId()
    {
        return Db::getLastInsertedId();
    }

    /**
	 * Vraca poslednji broj redova tabele
	 *
	 * @return integer
	 */
    public function getLastCount()
    {
        return Db::getLastRowCount();
    }

    /**
	 * Vraca poslednju PDO gresku
	 *
	 * @return string
	 */
    public function getLastError()
    {
        return Db::getLastError();
    }

    /**
	 * Vraca poslednji izvrseni PDO upit
	 *
	 * @return string
	 */
    public function getLastQuery()
    {
        return Db::getLastQuery();
    }

    /**
	 * Vraca kolone tabele
	 *
	 * @return array
	 */
    public function getTableFields()
    {
        $sql = "SHOW COLUMNS FROM {$this->table};";
        return $this->fetch($sql);
    }

    /**
	 * Vraca kljuceve tabele
	 *
	 * @return array
	 */
    public function getTableKeys()
    {
        $sql = "SHOW KEYS FROM {$this->table};";
        return $this->fetch($sql);
    }
}

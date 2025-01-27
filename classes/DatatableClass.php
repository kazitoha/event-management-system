<?php
class DatatableClass
{
    private $db;
    private $table;
    private $perPage;
    private $currentPage;
    private $totalRecords;
    private $totalPages;

    public function __construct($db, $table, $perPage = 10)
    {
        $this->db = $db;
        $this->table = $table;
        $this->perPage = $perPage;
        $this->setTotalRecords();
        $this->setTotalPages();
    }

    private function setTotalRecords()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
        $this->totalRecords = $stmt->fetchColumn();
    }

    private function setTotalPages()
    {
        $this->totalPages = ceil($this->totalRecords / $this->perPage);
    }
    public function getData($currentPage = 1)
    {
        $this->currentPage = $currentPage;
        $offset = ($this->currentPage - 1) * $this->perPage;
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $this->perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createLinks($baseUrl)
    {
        if ($this->totalPages <= 1) {
            return '';
        }

        $links = '<nav><ul class="pagination">';
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $active = ($i == $this->currentPage) ? 'active' : '';
            $links .= "<li class='page-item $active'><a class='page-link' href='{$baseUrl}&paginate=$i'>$i</a></li>";
        }
        $links .= '</ul></nav>';

        return $links;
    }
}

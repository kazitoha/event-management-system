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

    public function getEventData($currentPage = 1, $sortBy = 'name', $sortOrder = 'ASC', $searchTerm = '')
    {
        $this->currentPage = $currentPage;
        $offset = ($this->currentPage - 1) * $this->perPage;

        // Ensure the sort order is valid
        $validColumns = ['name', 'location', 'date', 'max_capacity', 'status'];
        if (!in_array($sortBy, $validColumns)) {
            $sortBy = 'name'; // Default to 'name' if invalid column
        }
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC'; // Default to 'DESC' if invalid order

        // Sanitize and escape search term for LIKE clause
        $searchTerm = '%' . $searchTerm . '%';

        // Query to fetch data with sorting
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}
                                    WHERE name LIKE :searchTerm OR location LIKE :searchTerm
                                    ORDER BY {$sortBy} {$sortOrder} LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
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

    public function exportCsv()
    {
        // Retrieve all the records
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Open the output stream
        $output = fopen('php://output', 'w');

        // Set the correct headers to force download of the CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $this->table . '_data.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output CSV column headers (if there is data)
        if (!empty($data)) {
            fputcsv($output, array_keys($data[0])); // Use the keys of the first row as the header
        }

        // Output data rows
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        // Close the output stream
        fclose($output);

        // Make sure no further HTML or content is output
        exit;
    }
}

<?php
class DatatableClass
{
    private $loadClasses;
    private $perPage;
    private $currentPage;
    private $totalRecords;
    private $totalPages;

    public function __construct($loadClasses, $perPage = 10)
    {
        $this->loadClasses = $loadClasses;
        $this->perPage = $perPage;
    }

    public function getData($currentPage = 1, $sortBy = 'name', $sortOrder = 'ASC', $searchTerm = '', $page, $statusFilter = '', $dateFilter = '')
    {
        $this->currentPage = $currentPage;

        if ($page == 'event_management') {
            $this->totalRecords = $this->loadClasses->getTotalEventRecords($searchTerm);
            $this->totalPages = ceil($this->totalRecords / $this->perPage);
            return $this->loadClasses->getEventData($this->currentPage, $this->perPage, $sortBy, $sortOrder, $searchTerm, $statusFilter, $dateFilter);
        }
        if ($page = 'user_management') {
            $this->totalRecords = $this->loadClasses->getTotalUserRecords($searchTerm);
            $this->totalPages = ceil($this->totalRecords / $this->perPage);
            return $this->loadClasses->getUserData($this->currentPage, $this->perPage, $sortBy, $sortOrder, $searchTerm);
        }
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

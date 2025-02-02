<?php
class DatatableClass
{
    private $eventClass;
    private $perPage;
    private $currentPage;
    private $totalRecords;
    private $totalPages;

    public function __construct($eventClass, $perPage = 10)
    {
        $this->eventClass = $eventClass;
        $this->perPage = $perPage;
    }

    public function getData($currentPage = 1, $sortBy = 'name', $sortOrder = 'ASC', $searchTerm = '', $page)
    {
        $this->currentPage = $currentPage;

        if ($page == 'event_management') {
            $this->totalRecords = $this->eventClass->getTotalEventRecords($searchTerm);
            $this->totalPages = ceil($this->totalRecords / $this->perPage);
            return $this->eventClass->getEventData($this->currentPage, $this->perPage, $sortBy, $sortOrder, $searchTerm);
        }
        if ($page = 'user_management') {
            $this->totalRecords = $this->eventClass->getTotalUserRecords($searchTerm);
            $this->totalPages = ceil($this->totalRecords / $this->perPage);
            return $this->eventClass->getUserData($this->currentPage, $this->perPage, $sortBy, $sortOrder, $searchTerm);
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

<?php
class Page {
    private $quantity; // Tổng số lượng
    private $maxQuantityInPage; // Số lượng tối đa trong 1 trang
    private $maxPageInBar; // Số trang tối đa trong một thanh
    private $currentPage; // Trang hiện tại

    public function __construct($quantity, $maxQuantityInPage, $maxPageInBar, $currentPage) {
        $this->quantity = $quantity;
        $this->maxQuantityInPage = $maxQuantityInPage;
        $this->maxPageInBar = $maxPageInBar;
        $this->setCurrentPage($currentPage);
    }


    public function setCurrentPage($currentPage) {
        if ($currentPage > $this->getPages()) {
            $this->currentPage = $this->getPages();
        }else {
            $this->currentPage = $currentPage;
        }
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPages()  {
        return ceil($this->quantity/$this->maxQuantityInPage);
    }
    
    public function getMinPreviousPage(){
        $currentPage = $this->currentPage;
        $maxPageInBar = $this->maxPageInBar;

        $page = $currentPage - floor($maxPageInBar/2);
        if ($page >= ($this->getPages() - $maxPageInBar + 1)) {
            $page = $this->getPages() - $maxPageInBar;
        }   
        if ($page <= 2) {
            $page = 1;
        }
        if ($page <= 0) {
            return 1;
        }
        return $page;
    }
    
    public function getMaxNextPage(){
        $currentPage = $this->currentPage;
        $maxPageInBar = $this->maxPageInBar;

        $page = intval($currentPage) + floor($maxPageInBar/2);
        if ($page < $maxPageInBar) {
            $page = $maxPageInBar + 1;
        }
        if ($page >= $this->getPages() - 1) {
            $page = $this->getPages();
        }
        return floor($page);
    }
    
    public function getMinIndex() {
        return (($this->currentPage - 1) * $this->maxQuantityInPage);
    }
    
    public function getMaxIndex() {
        $currentPage = $this->currentPage;
        $maxQuantityInPage = $this->maxQuantityInPage;
        $quantity = $this->quantity;

        $index = $currentPage * $maxQuantityInPage - 1;
        if ($index > $quantity - 1) {
            return $quantity - 1;
        }
        return $index;
    }
    
    public function isContainMinPage() {
        return $this->getMinPreviousPage() == 1;
    }
    
    public function isContainMaxPage() {
        return $this->getMaxNextPage() == $this->getPages();
    }
}
?>
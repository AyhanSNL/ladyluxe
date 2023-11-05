<?php
Class n11 {
    protected static $_appKey, $_appSecret, $_parameters, $_sclient;
    public $_debug = false;
    public function __construct(array $attributes = array()) {
        self::$_appKey = $attributes['appKey'];
        self::$_appSecret = $attributes['appSecret'];
        self::$_parameters = ['auth' => ['appKey' => self::$_appKey, 'appSecret' => self::$_appSecret]];
    }
    public function setUrl($url) {
        self::$_sclient = new \SoapClient($url);
    }
    public function ozellik($ID,$data) {
        $this->setUrl('https://api.n11.com/ws/CategoryService.wsdl');
        self::$_parameters['categoryId'] = $ID;
        self::$_parameters['pagingData'] = $data;
        return self::$_sclient->GetCategoryAttributes(self::$_parameters);
    }
    public function GetTopLevelCategories() {
        $this->setUrl('https://api.n11.com/ws/CategoryService.wsdl');
        return self::$_sclient->GetTopLevelCategories(self::$_parameters);
    }
    public function GetSubCategories($catID) {
        $this->setUrl('https://api.n11.com/ws/CategoryService.wsdl');
        self::$_parameters['categoryId'] = $catID;
        return self::$_sclient->GetSubCategories(self::$_parameters);
    }
    public function GetParentCategory($catID) {
        $this->setUrl('https://api.n11.com/ws/CategoryService.wsdl');
        self::$_parameters['categoryId'] = $catID;
        return self::$_sclient->GetParentCategory(self::$_parameters);
    }
    public function SaveProduct(array $product = Array()) {
        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
        self::$_parameters['product'] = $product;
        return self::$_sclient->SaveProduct(self::$_parameters);
    }
    public function updateProductBasic($productSellerCode,$price,$img,$desc,$stock) {
        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
        self::$_parameters['productId'] = null;
        self::$_parameters['productSellerCode'] = $productSellerCode;
        self::$_parameters['price'] = $price;
        self::$_parameters['description'] = ''.$desc.'';
        self::$_parameters['images'] = [
                    'image' =>
                        [
                            'url' => ''.$img.'',
                            'order' => 1
                        ]
        ];
        self::$_parameters['stockItems'] = [
            'stockItem' =>
                [
                    'id' => null,
                    'quantity' => $stock,
                    'sellerStockCode' => ''.$productSellerCode.'',
                    'optionPrice' => $price
                ]
        ];
        self::$_parameters['productDiscount'] = [
            'discountType' => '1',
            'discountValue' => '0',
            'discountStartDate' => '',
              'discountEndDate' => ''
        ];
        return self::$_sclient->updateProductBasic(self::$_parameters);
    }
    public function DeleteProductBySellerCode($productSellerCode) {
        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
        self::$_parameters['productSellerCode'] = $productSellerCode;
        return self::$_sclient->DeleteProductBySellerCode(self::$_parameters);
    }
    public function GetProductBySellerCode($urunKodu) {
        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
        self::$_parameters['sellerCode'] = $urunKodu;
        return self::$_sclient->GetProductBySellerCode(self::$_parameters);
    }
    public function GetShipmentTemplate($name) {
        $this->setUrl('https://api.n11.com/ws/ShipmentService.wsdl');
        self::$_parameters['name'] = $name;
        return self::$_sclient->GetShipmentTemplate(self::$_parameters);
    }
    public function __destruct() {
        if ($this->_debug) {
            print_r(self::$_parameters);
        }
    }
}
?>

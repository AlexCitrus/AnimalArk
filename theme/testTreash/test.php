<!-- Classes -->
class Product
{
    private $productId;
    private $productName;
    private $productDescription;
    private $productBrand;

    function __construct($productId, $productName, $productDescription, $productBrand) 
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productBrand = $productBrand;
    }

    function getId() 
    {
        return $this->productId;
    }

    function getName() 
    {
        return $this->productName;
    }

    function getDescription() 
    {
        return $this->productDescription;
    }

    function getBrand() 
    {
        return $this->productBrand;
    }
}

class Item extends Product
{
    
}


<!-- Code for add -->




<!-- Code for retrieval -->




<!-- Code for update -->




<!-- Code for delete -->
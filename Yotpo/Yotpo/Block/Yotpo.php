<?php
namespace Yotpo\Yotpo\Block;
class Yotpo extends \Magento\Framework\View\Element\Template
{
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\UrlInterface $urlinterface,
    \Magento\Catalog\Helper\Image $imageHelper,
    \Yotpo\Yotpo\Block\Config $config,
    \Psr\Log\LoggerInterface $logger,
    array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_urlinterface = $urlinterface;
        $this->_config = $config;
        $this->_imageHelper = $imageHelper;
        $this->_logger = $logger;
        parent::__construct($context, $data);
    }

    public function getProduct()
	{
		if (!$this->hasData('product')) {
            $this->_logger->addDebug('YOTPO             !$this->hasData(product)         ');
            $this->setData('product', $this->_coreRegistry->registry('current_product'));
            $this->_logger->addDebug('YOTPO             !$this->hasData(product)         '.json_encode($this->hasData('product')));
            $this->_logger->addDebug('YOTPO             !$this->hasData(product)         '.json_encode($this->getData('product')));

        }
        return $this->getData('product');
    }

    public function getProductId() {
         $this->_logger->addDebug('YOTPO             getProductId         '.json_encode($this->getProduct()));
    	return $this->getProduct()->getId();
    }

    public function getProductName() {
        $productName = $this->getProduct()->getName();
        return htmlspecialchars($productName);
    }
    
    public function getProductDescription()
    {
        return $this->getProduct()->getShortDescription();        
    }

    public function getProductUrl()
    {
        return $this->_urlinterface->getCurrentUrl();
    }    

    public function isRenderWidget()
    {
        return $this->getProduct() != null && 
        ($this->_config->getShowWidget() || $this->getData('fromHelper'));
    }    

    public function isRenderBottomline()
    {
        return $this->_config->getShowBottomline();
    } 

    public function getProductImageUrl()
    {
        return $this->_imageHelper->init($this->getProduct(), 'image');;
    } 
    
    private function isProductPage()
    {
        return $this->getProduct() != null;
    }     
}
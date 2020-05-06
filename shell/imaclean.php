<?php

require_once 'abstract.php';

class MZperX_Shell_Imaclean extends Mage_Shell_Abstract
{
    public function run()
    {
        if ($this->getArg('delete')) {

            $model      = Mage::getModel('defcon2imaclean/imaclean');
            $collection = Mage::getModel('defcon2imaclean/imaclean')->getCollection();
            foreach ($collection as $imaclean) {
                $model->load($imaclean->getId());
                echo 'Delete file: ' . $imaclean->getFilename() . "\n";
                unlink('media/catalog/product' . $imaclean->getFilename());
                $model->setId($imaclean->getId())->delete();
            }
            return;

        } else if ($this->getArg('collect')) {

            Mage::helper('defcon2imaclean')->compareList();
            return;

        }

        echo $this->usageHelp();
    }

    public function usageHelp()
    {
        $file = basename(__FILE__);
        return <<<USAGE
Usage:  php -f $file -- [options]

  collect   Collect unused product images
  delete    Delete collected images

USAGE;
    }

    public function _applyPhpVariables()
    {
    }

}

$shell = new MZperX_Shell_Imaclean();
$shell->run();

# Mage2 Module Ace B2bRegistration

    ``ace/module-b2bregistration``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities


## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Ace`
 - Enable the module by running `php bin/magento module:enable Ace_B2bRegistration`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require ace/module-b2bregistration`
 - enable the module by running `php bin/magento module:enable Ace_B2bRegistration`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Direct from gitHub
    composer config repositories.ace-b2bregistration git https://github.com/durgagupta/b2bregistration.git
    composer require ace/module-b2bregistration:dev-master



## Configuration




## Specifications


## Attributes
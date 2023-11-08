# magento2-magezon-blog

Hyvä Themes Compatibility module for Magezon_Blog
 
## Installation

First install the Magezon_Blog extension according to the installation instructions from Magezon.
Since Magezon does not offer composer based installations of their modules, the Magezon_Blog extension has to be installed as a separate step.

Once Magezon_Blog is installed, follow these instructions:
  
1. Install via composer
    ```
    composer config repositories.hyva-themes/magento2-magezon-blog git git@gitlab.hyva.io:hyva-themes/hyva-compat/magento2-magezon-blog.git
    composer require hyva-themes/magento2-magezon-blog
    ```
2. Enable module
    ```
    bin/magento setup:upgrade
    ```
   

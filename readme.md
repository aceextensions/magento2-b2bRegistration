# Mage2 Module Ace B2bRegistration

This extension supports separate retailer and wholesaler registration and also supports Magento's default general registration for the general group. It also supports wholesaler/retailer registration from the Magento register page

## Main Functionalities
* Enable/disable Additional B2B Registration functionality of the extension from the admin panel. 
* Support enable/disable Email functionality of the whole module from the admin panel.    
* Show Shortcut Of Registration Form In Top Menu
* In Approval Settings, the admin can easily use `Status` like,
    * Normal Account
    * B2B Pending
    * B2B Approval
    * B2B Reject

* Give The Admin Time To Manage The Registrations
* Approve New B2B Registrations Automatically
* In B2B Customer, the admin can use functionality like,     
    * Enable the B2B button for the enabling/disable button of the B2B registration in frontend.
    * B2B button text for change text of the B2B button in frontend.
    * Enable Tax/vat Field, Enable Address Fileds, Enable Gender Field, Enable Date of birth Field for enabling/disable from the B2B registration page.

## TODO
#### Super User:
* Superuser will be able to add multiple child users to access the business account and place orders.
* Superuser will be able to add multiple addresses and multiple child users.
* Superuser will be able to assign multiple billing addresses to child users by clicking on the "Assign Address" button.
* Superuser will be able to view all the orders placed by child users.
All the Users will have an option to "Checkout with multiple addresses" if multiple shipping is enabled in the admin panel.  
* Superuser will be able to Edit the child user information like email id and name.
* Superuser will not be able to Delete the child user.
 

#### Child User:
* Child user will be able to login with registered email id and password which will be sent to his email id. 
* After logging in, the child user will be directed to My Account page * where he will be able to view billing and shipping address by default assigned by Superuser.
* Child user will not be able to edit or delete the Billing address but child user will be able to add an additional shipping address.
* Child user will be able to select assigned address as Billing address and shipping address and added address as Shipping address". 
* Child user will be able to place an order by adding products to cart and through the wish list.
* Child user will not be able to edit his profile information like his email id, company name and GST number in the account information section.

## Installation
\* = in production please use the `--keep-generated` option

### Composer

 - Install the module composer by running `composer require aceextensions/module-b2bregistration`
 - enable the module by running `php bin/magento module:enable Aceextensions_B2bRegistration`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

* TODO

## Attributes

* `b2b_activasion_status` customer attribute for status 
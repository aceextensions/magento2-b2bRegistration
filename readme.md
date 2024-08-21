# Mage2 Module Ace B2bRegistration

This extension supports separate retailer and wholesaler registration and also supports Magento's default general registration for the general group. It also supports wholesaler/retailer registration from the Magento register page

## Key Features

* **Toggle B2B Registration:** Easily enable or disable the Additional B2B Registration functionality directly from the admin panel.
* **Email Functionality Control:** Manage the email functionality for the entire module with a simple enable/disable option from the admin panel.
* **Quick Access:** Display a shortcut to the registration form in the top menu for easy access.
* **Approval Settings:** Admins can manage approval statuses, including:
  * Normal Account
  * B2B Pending
  * B2B Approval
  * B2B Reject
* **Registration Management:** Allow admins to efficiently manage and approve B2B registrations.
* **Auto-Approval:** Option to automatically approve new B2B registrations.
* **B2B Customer Features:** Admins can configure various B2B customer settings, such as:
  * Enabling/disabling the B2B registration button on the frontend.
  * Customizing the text for the B2B registration button.
  * Enabling/disabling fields like Tax/VAT, Address, Gender, and Date of Birth on the B2B registration page.

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
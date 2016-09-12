MageFaker
=========

##Sample data generator for Magento 1.9

MageFaker allows you to generate sample data from the Magento Backend. 
The content is not designed for showcasing, but is great for faster development, testing and benchmarking.

Names and images come from the Magento sample data package and Magento 2.0.

#Features

- Add any number of desired data (large numbers can take a while)
- Products can be assigned to multiple categories
- Ability to remove fake data, without losing "real" content
- Quick create custom categories

#Currently supported datatypes

- Categories
- Simple products
- Configurable products (with color swatches)
- Product reviews and ratings

#Requirements

- Magento 1.9.x
- PHP 5.4 or higher

#Installation

**Normal installation**

1. Copy module files to your Magento installation
2. Clear caches and logout from the backend

**Using composer**

1. Add the firegento repo if you haven't already: 
```javascript
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://packages.firegento.com"
        }
    ]
}
```
2. Include MageFaker:
```
composer require ovs/magefaker
```
3. Clear caches and logout from the backend

#How to use

1. Login to your Magento admin
2. Go to system -> MageFaker
3. Choose your options and press start
4. Run indexer

#Enable configurable swatches

1. Generate some configurable products
2. Go to system -> configuration -> configurable swatches
3. Enable configurable swatches and choose "Fake Color" as attribute to show in product detail and product listing page

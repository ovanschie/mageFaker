mageFaker
=========

**Sample data generator for Magento [WIP]**

This simple module generates sample data for Magento. 
U can insert unlimited data of any type. It is not designed for showcase content, due to duplicated product names and limited images, but it is great for development / testing / benchmarking. It uses names and images from the Magento sample data package.

#Features

- Add any number of desired content. 1 - 10.000 products for example (large numbers can take a while)
- Products can be assigned to multiple categories
- Ability to remove fake data, without losing "real" content

#Currently supported data types

 - Categories
 - Simple products
 - Configurable products & color swatches
 - Product reviews and ratings

 More to come.

#Requirements

- Magento            >= 1.9.0 (older versions untested)
- PHP                >= 5.4
- Memory limit       >= 512M
- Unlimited max_execution_time preferred

#How to use

- Copy module files to your project root
- Login to your Magento admin
- Go to system -> Faker data
- Choose your options and press start
- Run indexer

#Enable configurable (color) swatch

1. Generate some fake configurable products
2. Go to system -> configuration -> configurable swatches
3. Enable configurable swatches and choose "Fake Color" as attribute to show in product detail and product listing page
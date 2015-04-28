mageFaker
=========

**Sample data generator for Magento [WIP]**

This simple module generates sample data for Magento. 
U can insert unlimited data of any type. It is not designed for showcase content, due to duplicated product names and limited images, but it is great for development / testing / benchmarking. It uses names and images from the Magento sample data package.

#Features

- Add any number of desired content. 1 - 10.000 products for example (large numbers can take a while)
- Products can be assigned to any category (or multiple)
- Multilayered categories
- Remove any type of fake data, without losing "real" content

#Currently supported data types

 - Categories
 - Simple products
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

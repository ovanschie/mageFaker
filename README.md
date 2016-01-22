MageFaker
=========

**Sample data generator for Magento**

This simple module generates sample data for Magento. 
U can insert unlimited data of any type. It is not designed for showcase content, due to duplicated product names and limited images, but is great for development / testing / benchmarking. Names and images come from the Magento sample data package.

#Features

- Add any number of desired data (large numbers can take a while)
- Products can be assigned to multiple categories
- Ability to remove fake data, without losing "real" content
- Quick create custom categories

#Currently supported data types

- Categories
- Simple products
- Configurable products with color swatches
- Product reviews and ratings

More to come.

#Requirements

- Magento            >= 1.9.x (older versions untested)
- PHP                >= 5.4

#How to use

1. Copy module files to your project root
2. Login to your Magento admin
3. Go to system -> MageFaker
4. Choose your options and press start
5. Run indexer

#Enable configurable (color) swatch

1. Generate some fake configurable products
2. Go to system -> configuration -> configurable swatches
3. Enable configurable swatches and choose "Fake Color" as attribute to show in product detail and product listing page
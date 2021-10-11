<?php

return [
    'title'   =>  'Product',
    'name'   =>  'Name',
    'retailer'   =>  'Retailer',
    'addProduct'   =>  'Add Product',
    'editProduct'   =>  'Edit Product',
    'viewProduct'   =>  'View Product',
    'empty' => 'Product not available',    
    'product'   =>  'Product',
    'products'   =>  'Products',
    'category'   =>  'Category',
    'addMore'   =>  'Add More',
    'remove'   =>  'Remove',
    'fields'    =>  [
        'name' => 'Name',
        'description' => 'Description',
        'specification' => 'Specification',
        'category' => 'Category',
        'location' => 'Location',
        'rent' => 'Rent',
        'security' => 'Security',
        'quantity' => 'Quantity',
        'price' => 'Price',
        'image' => 'Thumbnail Image',
        'gallery' => 'Gallery',
        'nonAvailabilityDate' => 'Non Availability Date',
        'ifAny' => '(If any)',
        'status'   =>  'Status',
    ],
    'placeholders' => [
        'productName' => 'Product Name',
        'productDescription' => 'Product Description',
        'productSpecification' => 'Product Specification',
        'productCategory' => 'Product Category',
        'selectCategory' => 'Select Category',
        'location' => 'Location',
        'rentPerDay' => 'Rent per day',
        'productSecurity' => 'Product Security',
        'productQuantity' => 'Product Quantity',
        'productPrice' => 'Product Price',
        'nonAvailableDates' => 'Non Available Date',
    ],
    'validations'    =>  [
        'productNameRequired' => 'Please enter the product name',
        'productDescription' => 'Please enter the product description',
        'productSpecification' => 'Please enter the product specification',
        'productCategory' => 'Please select the product category',
        'selectedProductCategory' => 'Selected category does not exist',
        'locationRequired' => 'Please enter the location',
        'rentRequired' => 'Please enter the rent amount',
        'rentRegex' => 'Rent must be greater than zero',
        'securityRequired' => 'Please enter the security amount',
        'securityRegex' => 'Security must be greater than zero',
        'quantityRequired' => 'Please enter the product quantity',
        'quantityRegex' => 'Quantity must be greater than zero',
        'priceRequired' => 'Please enter the product price',
        'priceRegex' => 'Price must be greater than zero',
        'thumbnailRequired' => 'Please upload the thumbnail image',
        'thumbnailExtenstion' => 'Please upload .jpeg, .jpg or .png file',
        'thumbnailSize' => 'File size should not be more than 2MB',
        'galleryExtenstion' => 'Please upload .jpeg, .jpg or .png file',
        'gallerySize' => 'File size should not be more than 2MB',
        'nonAvailabileDatesAfterOrEqual' => 'The non availabile dates must be a date after or equal to ' . date(session()->get('date')),
    ],
    'messages' => [
        'saveProduct' => 'Product saved successfully',
        'updateProduct' => 'Product updated successfully',
        'deleteProduct' => 'Product deleted successfully',
    ]
];
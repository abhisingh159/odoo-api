# OdooApi

## Introduction

OdooApi is a Laravel package for interacting with the Odoo API using Ripcord. This package provides a simple and clean way to integrate Odoo's functionalities into your Laravel application.

## Installation

1. **Install the package via composer:**

    ```bash
    composer require codemusk/odoo-api
    ```

2. **Add the service provider and alias to your `config/app.php` file (for Laravel versions below 11):**

    ```php
    'providers' => [
        // Other Service Providers
        Codemusk\OdooApi\OdooApiServiceProvider::class,
    ],

    'aliases' => [
        // Other Facades
        'OdooApi' => Codemusk\OdooApi\Facades\OdooApi::class,
    ],
    ```

3. **For Laravel 11 and above, add the service provider and alias to the `extra` section of your package's `composer.json`:**

    ```json
    "extra": {
        "laravel": {
            "providers": [
                "Codemusk\\OdooApi\\OdooApiServiceProvider"
            ],
            "aliases": {
                "OdooApi": "Codemusk\\OdooApi\\Facades\\OdooApi"
            }
        }
    }
    ```

4. **Publish the configuration file:**

    ```bash
    php artisan vendor:publish --provider="Codemusk\OdooApi\OdooApiServiceProvider"
    ```

5. **Configure the package by editing the `config/odooapi.php` file with your Odoo connection details:**

    ```php
    return [
        'url' => env('ODOO_URL', 'http://your-odoo-instance.com'),
        'db' => env('ODOO_DB', 'your-database-name'),
        'username' => env('ODOO_USERNAME', 'your-username'),
        'password' => env('ODOO_PASSWORD', 'your-password'),
    ];
    ```

## Usage

Here is an example of how to use the OdooApi package in a Laravel controller:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codemusk\OdooApi\Facades\OdooApi;

class TestController extends Controller
{
    public function test()
    {
        try {
            // List records
            $partners = OdooApi::listRecords('res.partner', 0, 10, ['name', 'email']);
        
            // Create a record
            $newPartner = OdooApi::createRecord('res.partner', [
                'name' => 'New Partner',
                'email' => 'newpartner@example.com',
            ]);
        
            // Update a record
            $updateResult = OdooApi::updateRecord('res.partner', $newPartner, [
                'name' => 'Updated Partner Name',
            ]);
        
            // Delete a record
            $deleteResult = OdooApi::deleteRecord('res.partner', $newPartner);
        
            // Read a specific record
            $record = OdooApi::readRecord('res.partner', 8);
        
            // Search and read records
            $filteredRecords = OdooApi::searchAndRead('res.partner', [['name', 'ilike', 'John']], ['name', 'email'], 0, 10);
        
            // List record fields
            $fields = OdooApi::listRecordFields('res.partner');
        
            // Output results (example)
            dd($partners, $newPartner, $updateResult, $deleteResult, $record, $filteredRecords, $fields);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
```

Methods
The following methods are available to interact with the Odoo API:

listRecords($model, $offset = 0, $limit = 10, $fields = [])
Fetches a list of records from a specified model.

$model: The name of the Odoo model (e.g., 'res.partner').
$offset: The offset for pagination (default is 0).
$limit: The maximum number of records to retrieve (default is 10).
$fields: An array of fields to retrieve (default is an empty array).
createRecord($model, $data)
Creates a new record in a specified model.

$model: The name of the Odoo model (e.g., 'res.partner').
$data: An associative array of the data to be inserted.
updateRecord($model, $id, $data)
Updates an existing record in a specified model.

$model: The name of the Odoo model (e.g., 'res.partner').
$id: The ID of the record to be updated.
$data: An associative array of the data to be updated.
deleteRecord($model, $id)
Deletes a record from a specified model.

$model: The name of the Odoo model (e.g., 'res.partner').
$id: The ID of the record to be deleted.
readRecord($model, $id)
Reads a specific record from a specified model.

$model: The name of the Odoo model (e.g., 'res.partner').
$id: The ID of the record to be read.
searchAndRead($model, $domain, $fields, $offset = 0, $limit = 10)
Searches for records based on a domain and then reads them.

$model: The name of the Odoo model (e.g., 'res.partner').
$domain: An array specifying the search domain.
$fields: An array of fields to retrieve.
$offset: The offset for pagination (default is 0).
$limit: The maximum number of records to retrieve (default is 10).
listRecordFields($model)
Lists the fields of a specified model.

$model: The name of the Odoo model (e.g., 'res.partner').

Troubleshooting
Ensure you have the PHP XML-RPC library installed. For PHP 8, you can use:

```bash
sudo apt-get install php-xmlrpc
```
or 

```bash
brew install php@8.3
```

If you encounter issues with authentication, check your Odoo connection details in the config/odooapi.php file.

Contributing
Feel free to submit issues or pull requests.

License
This package is open-sourced software licensed under the MIT license.

```perl
This `README.md` provides a comprehensive overview of the package, installation instructions, usage examples, and detailed descriptions of each method available for interacting with the Odoo API.
```

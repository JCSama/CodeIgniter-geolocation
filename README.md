# CodeIgniter Geolocation Library

CodeIgniter Geolocation library allows you to locate an IP Address using "ipinfodb" API.

# Installation

CodeIgniter Versoin >= 2.x.x

Copy the file `config/geolocation.php` to the `application/config` folder.

Copy the file `libraries/geolocation.php` to the `application/libraries` folder.

# Usage

You need to subscribe to http://ipinfodb.com/register.php to get your API KEY and then,

Open `application/config/geolocation.php` and put it there :

```php
$config['api_key'] = 'YOUR_API_KEY';
```

After that, you can call the library within your controller for instance like following :

```php
$this->load->library('Geolocation');
$this->load->config('geolocation', true);

$config = $this->config->config['geolocation'];

$this->geolocation->initialize($config);
$this->geolocation->set_ip_address($ip); // IP to locate
// $this->geolocation->set_format('json');
// OR you can change the format within `config/geolocation.php` config file
$country = $this->geolocation->get_country();
var_dump($country);

// For more precision
$city = $this->geolocation->get_city();
if($city === FALSE)
    var_dump($this->geolocation->get_error());
else
    var_dump($city);
```

# Additional parameters

You can change the result format within the config file,
or leave it empty to return a PHP Array

Open `application/config/geolocation.php` :

```php
$config['format'] = 'json'; // available format : xml|raw|json  or empty for php array
```

# IpInfoDb API :

For more information about the API please visit : http://ipinfodb.com

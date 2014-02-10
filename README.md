basfoiy
=======

dhivehi english dictionary


config file :

```php
	return array(
	            'token' => 'thetoken',
	            'limit' => '5',
	            'findSimilar' => false,
	            'db' => array(
	                    'host' => '127.0.0.1',
	                    'db' => 'basfoi',
	                    'user' => 'root',
	                    'pass' => 'root'
	                ),
	            'apiKeys' => array(
	                    'fbAppId' => 'fbkey',
	                    'analytics' => array(
	                            'account' => 'basfoiy.mv',
	                            'domain' => 'UA-xxxxxxxx-1'
	                        ),
	                ),
	        );
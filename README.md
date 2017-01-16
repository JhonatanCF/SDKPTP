#PlaceToPay SDK SOAP WS - Version 1.0.1

##Instalación

Se instala a traves de composer:

    composer require jhonatancf/sdkptp

##Configuración
1. El archivo config_ws.json contiene los parametros de conexión al WebService de PlaceToPay(WSDL, login, transactionalKey)
2. El archivo config_bd.php contiene los datos de conexión a la base de datos por medio de Eloquent. Modificar los datos de acceso según la bd de datos que se tenga configurada.
3. Crear la tabla transactions con la siguiente estructura:

-
    CREATE TABLE transactions (
      transaction_id integer NOT NULL,
      session_id VARCHAR(32) NOT NULL,
      return_code VARCHAR(30) NOT NULL,
      created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (transaction_id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
## Uso
Instancia y métodos disponibles.
Para ver el funcionamiento y los valores retornados por las funciones dirijase a la sección de tests.

-
```php
  use JhonatanCF5\SDKPlaceToPay;
  
  $sdk = new SDKPlaceToPay();

  //Bank List
  $sdk->getBankList();

  // Create new transaction
  $sdk->createTransaction(PSETransactionRequest $transactionRequest);

  // Create new transaction MultiCredit
  $sdk->createTransactionMultiCredit(PSETransactionMultiCreditRequest $transactionRequest);

  //Transaction information 
  $sdk->getTransactionInformation($transactionID);

  //Refresh transactions pending
  $sdk->refreshTransactionsPending();
```

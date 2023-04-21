# Radar

**Valida os seus dados de forma simpes.**

Radar é uma **biblioteca** escrita em php, totalmente orientada a objectos que permite a validação de formularios html no backend de uma forma mais fácil.

## Uso Básico
**O radar contém dois validadores**, um para campos obrigátorios e outro para campos não obrigátorios.

**nota:** Nos dois casos abaixo as funções de validação irão retornar um array contendo o erro caso o dado seja inválido ou o próprio dado caso este seja válido.

* Se o campo não for obrigatório

```php
use Radar\Validators\RequiredData;

$nonRequiredData = new NonRequiredData();
$nonRequiredData->setLenght(2, 6, 'apenas caracteres entre 2 e 6');

$passwordData = $this->nonRequiredData->validateString('', 'password invalida');

var_dump($passwordData);

/**
 * resultado
 * 
 * [
 *      'chars' => '',
 *      'error' => 'apenas caracteres entre 2 e 6'
 * ]
*/
```

* Se o campo for obrigatorio
```php
use Radar\Validators\RequiredData;

$requiredData = new RequiredData('este campo é obrigatório');
$nameData = $this->requiredData->validateName('felizardo', 'nome invalido');

var_dump($nameData);

/**
 * resultado
 * 
 * [
 *      'name' => 'felizardo',
 *      'error' => ''
 * ]
*/
```

A função `setlenght()` estabelece uma delimitacao entre os caracteres e caso a delemitacao for respeitada um erro sera retorno pela funcao `validatePassword()`.

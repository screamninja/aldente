<p align="center"><a href="https://github.com/screamninja/php-framework" target="_blank"><img src="https://github.com/screamninja/php-framework/blob/master/public/images/page-logo.png"></a></p>
<h1 align="center">Al Dente framework</h1>

<p align="center">With this framework your website is <b>Al Dente</b>.</p>

## About Al Dente
This is a simple PHP framework for web applications.

## Highlights
* Object oriented
* Based on Model–View–Controller (MVC) pattern
* MySQL database usage
* The PHP Data Objects (PDO) connections to database
* Logging with PSR-3
* AJAX form submit (switchable)
* API based on JSON-RPC with token access
* User authorization on PHP/MySQL/Sessions
* Unit tests on PHPUnit

## Getting Started

<h3 align="center">ВНИМАНИЕ! ДОКУМЕНТАЦИЯ В ПРОЦЕССЕ ДОПОЛНЕНИЯ!</h3>

Точкой входа является файл `index.php` в папке `public`. При запросе файла `index.php` у сервера, начинается исполнение PHP-скрипта:
- создаётся объект класса **Router**;
- вызывается метод `run()`;
- при возникновении исключений (<a href="http://php.net/manual/en/class.exception.php" target="_blank">Exception</a>) информации о них логгируется посредством вызова статичного метода `getLogger()` класса **LoggerConfig**.

### Маршрутизация (Routing)

`__construct()`-метод класса **Router** выполняет следующие функции:
- стартует новую сессию, либо возобновляет существующую;
- объявляет константу для дериктории Вашего проекта;
- принимает задекларированные маршруты проекта, по средствам создания экземпляра класса **RouterConfig** и вызыва статичного метода `get()`;
- вызывая собственный метод `add()`, добавляет регулярные выражения к маршрутам.

Все маршруты декларируются в папке `app/config` в классе **RouterConfig** (файл `RouterConfig.php`) в статичном методе `get()` ассоциативным массивом следующего вида:

``` php
'account/login' => [            // путь в url после доменного имени, например, aldente.com/account/login
    'controller' => 'account',  // 1-й ключ всегда 'controller' => 1-е значение 'название контроллера'
    'action' => 'login',        // 2-й ключ всегда 'action' => 2-е значение 'название экшена'
],
```

Метод `run()` - основной "рабочий" метод **Router**, в чьи задачи входят очень важные функции. Будучи, своего рода регулировщиком на дороге ведущей к страницам Вашего проекта, он держит всё под своим контролем. С помощью вспомогательного метода `match()` он проверяет существование вызываемого пользователем маршрута, а так же его правельность и доступность. А ещё, он точно знает будут ли Ваши контроллеры и экшены в нужном месте и в нужное время. Если Вы не андроид или ИИ выбравшийся на свободу из подвалов военной лаборатории, то Вы на себе должны знать, что люди делают ошибки. И как раз на этот случай, будь эта ошибка пользователя или разработчика метод `run()` укажет ему путь на Ваши страницы с соответсвубщим кодом (**404**, **403**).

## Security Vulnerabilities
If you discover a security vulnerability, please send an e-mail to [Dmitry Kuleznev](https://github.com/screamninja) via screamninja@gmail.com.

## License
This PHP-framework is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
